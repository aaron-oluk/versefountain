<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Poem;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Event;
use App\Models\Subscription;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // All methods in this controller should implicitly be protected by an 'isAdmin' middleware
    // or a policy that checks for admin role.

    /**
     * Show the admin dashboard.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Admin access required.');
        }

        $status = $request->query('status', 'all');
        $type = $request->query('type', 'all');

        $applyStatus = function ($query) use ($status) {
            if ($status === 'pending') {
                $query->where('approved', false);
            } elseif ($status === 'approved') {
                $query->where('approved', true);
            }
        };

        $contentItems = collect();

        if ($type === 'all' || $type === 'book') {
            $booksQuery = Book::query();
            $applyStatus($booksQuery);

            $contentItems = $contentItems->concat(
                $booksQuery->latest()
                    ->take(20)
                    ->get()
                    ->map(function ($book) {
                        return [
                            'uuid' => $book->uuid,
                            'title' => $book->title,
                            'author' => $book->author ?? 'Unknown',
                            'type' => 'book',
                            'status' => $book->approved ? 'approved' : 'pending',
                            'created_at' => $book->created_at,
                            'model' => $book,
                        ];
                    })
            );
        }

        if ($type === 'all' || $type === 'poem') {
            $poemsQuery = Poem::query()->with('author:id,username');
            $applyStatus($poemsQuery);

            $contentItems = $contentItems->concat(
                $poemsQuery->latest()
                    ->take(20)
                    ->get()
                    ->map(function ($poem) {
                        return [
                            'uuid' => $poem->uuid,
                            'title' => $poem->title,
                            'author' => optional($poem->author)->username ?? 'Unknown',
                            'type' => 'poem',
                            'status' => $poem->approved ? 'approved' : 'pending',
                            'created_at' => $poem->created_at,
                            'model' => $poem,
                        ];
                    })
            );
        }

        $contentItems = $contentItems
            ->sortByDesc('created_at')
            ->values();

        $activeChatrooms = \App\Models\ChatRoom::withCount('members')
            ->orderByDesc('members_count')
            ->take(5)
            ->get();

        $stats = [
            'total_users' => User::count(),
            'active_creators' => User::where('role', '!=', 'admin')->count(),
            'pending_books' => Book::where('approved', false)->count(),
            'pending_poems' => Poem::where('approved', false)->count(),
            'total_tickets' => Ticket::count(),
            'recent_payments' => Payment::latest()->take(5)->get(),
            'active_chatrooms' => $activeChatrooms,
            'pending_submissions' => Book::where('approved', false)->count() + Poem::where('approved', false)->count(),
        ];

        return view('admin.dashboard', [
            'stats' => $stats,
            'contentItems' => $contentItems,
            'statusFilter' => $status,
            'typeFilter' => $type,
            'activeChatrooms' => $activeChatrooms,
        ]);
    }

    /**
     * Retrieve a list of all registered users.
     */
    public function getUsers()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        // Exclude sensitive data like password hash
        $users = \App\Models\User::all(['id', 'username', 'email', 'role', 'created_at']);
        return response()->json($users);
    }

    /**
     * Update a user's information.
     */
    public function updateUser(Request $request, User $user)
    {
        $currentUser = Auth::user();
        if (!$currentUser || $currentUser->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }

        $validatedData = $request->validate([
            'username' => ['sometimes', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'isAdmin' => ['sometimes', 'boolean'],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'], // 'confirmed' checks for password_confirmation
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json($user->only(['id', 'username', 'email', 'isAdmin']));
    }

    /**
     * Delete a user account.
     */
    public function deleteUser(User $user)
    {
        $currentUser = Auth::user();
        if (!$currentUser || $currentUser->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }

        if ($currentUser->id === $user->id) {
            return response()->json(['message' => 'Admins cannot delete their own account via this endpoint.'], 403);
        }

        $user->delete();
        return response()->json(null, 204);
    }

    /**
     * Retrieve a list of books that are awaiting administrative approval.
     */
    public function getPendingBooks()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        $books = Book::where('approved', false)->get();
        return response()->json($books);
    }

    /**
     * Retrieve a list of poems that are awaiting administrative approval.
     */
    public function getPendingPoems()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        $poems = Poem::where('approved', false)->get();
        return response()->json($poems);
    }

    /**
     * Approve a book.
     */
    public function approveBook(Book $book)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        $book->approved = true;
        $book->save();
        return response()->json($book);
    }

    /**
     * Delete a book.
     */
    public function deleteBook(Book $book)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        $book->delete();
        return response()->json(null, 204);
    }

    /**
     * Delete a poem.
     * Note: PoemController also has a destroy method, this is for admin to delete any poem.
     */
    public function deletePoem(Poem $poem)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        $poem->delete();
        return response()->json(null, 204);
    }

    /**
     * Update the status of a payment.
     */
    public function updatePaymentStatus(Request $request, Payment $payment)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }

        $validatedData = $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'completed', 'refunded', 'failed'])],
            'paddlePaymentId' => ['nullable', 'string'],
            'paddleTransactionId' => ['nullable', 'string'],
            'refundReason' => ['nullable', 'string'],
        ]);

        $payment->update($validatedData);
        return response()->json($payment);
    }

    /**
     * Initiate a refund for a payment.
     */
    public function refundPayment(Request $request, Payment $payment)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }

        if ($payment->status === 'refunded') {
            return response()->json(['message' => 'Payment is already refunded.'], 409);
        }

        $request->validate([
            'refundReason' => 'nullable|string',
        ]);

        // --- Integration with Paddle (or other payment gateway) to actually process refund ---
        try {
            // Example: Call Paddle API to process refund
            // PaddleService::processRefund($payment->paddlePaymentId, $request->refundReason);

            $payment->status = 'refunded';
            $payment->refundReason = $request->refundReason ?? 'Admin initiated refund.';
            $payment->save();

            // Also update associated tickets to refunded status
            Ticket::where('payment_id', $payment->id)->update(['isRefunded' => true, 'status' => 'cancelled']);

            return response()->json($payment);
        } catch (\Exception $e) {
            Log::error("Refund processing error for payment ID {$payment->id}: " . $e->getMessage());
            return response()->json(['message' => 'Failed to process refund.'], 500);
        }
    }

    /**
     * Update the status of a ticket.
     */
    public function updateTicketStatus(Request $request, Ticket $ticket)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }

        $validatedData = $request->validate([
            'status' => ['required', 'string', Rule::in(['active', 'cancelled', 'used'])],
        ]);

        $ticket->update($validatedData);
        return response()->json($ticket);
    }

    /**
     * Retrieve all tickets associated with a specific event.
     */
    public function getTicketsForEvent(Event $event)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        $tickets = $event->tickets()->with('user:id,username')->get();
        return response()->json($tickets);
    }

    /**
     * Show the admin users management page.
     */
    public function usersPage(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Admin access required.');
        }

        $search = $request->query('search');
        $role = $request->query('role', 'all');

        $usersQuery = User::query()
            ->select('id', 'username', 'email', 'role', 'created_at')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role !== 'all', function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->latest();

        $users = $usersQuery->paginate(20);

        $stats = [
            'total_users' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'creators' => User::where('role', 'creator')->count(),
            'regular' => User::where('role', 'user')->count(),
        ];

        return view('admin.users', compact('users', 'stats', 'search', 'role'));
    }

    /**
     * Show the admin subscriptions management page.
     */
    public function subscriptionsPage(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Admin access required.');
        }

        $status = $request->query('status', 'all');
        $plan = $request->query('plan', 'all');

        $subscriptionsQuery = Subscription::query()
            ->with('user:id,username,email')
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($plan !== 'all', function ($query) use ($plan) {
                $query->where('plan_type', $plan);
            })
            ->latest();

        $subscriptions = $subscriptionsQuery->paginate(20);

        $stats = [
            'total_subscriptions' => Subscription::count(),
            'active' => Subscription::where('status', 'active')->count(),
            'cancelled' => Subscription::whereNotNull('cancelled_at')->count(),
            'on_trial' => Subscription::whereNotNull('trial_ends_at')
                ->where('trial_ends_at', '>', now())->count(),
            'monthly_revenue' => Subscription::where('status', 'active')
                ->where('plan_type', 'monthly')
                ->sum('amount'),
            'yearly_revenue' => Subscription::where('status', 'active')
                ->where('plan_type', 'yearly')
                ->sum('amount'),
        ];

        return view('admin.subscriptions', compact('subscriptions', 'stats', 'status', 'plan'));
    }

    /**
     * Show the admin finances page.
     */
    public function financesPage(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Admin access required.');
        }

        $period = $request->query('period', '30');
        $startDate = now()->subDays((int)$period);

        $payments = Payment::with('user:id,username')
            ->where('created_at', '>=', $startDate)
            ->latest()
            ->paginate(20);

        $stats = [
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'period_revenue' => Payment::where('status', 'completed')
                ->where('created_at', '>=', $startDate)
                ->sum('amount'),
            'total_payments' => Payment::count(),
            'period_payments' => Payment::where('created_at', '>=', $startDate)->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'refunded_total' => Payment::where('status', 'refunded')->sum('amount'),
            'refunded_count' => Payment::where('status', 'refunded')->count(),
        ];

        // Revenue by day for chart
        $revenueByDay = Payment::where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.finances', compact('payments', 'stats', 'period', 'revenueByDay'));
    }

    /**
     * Show the admin reports and analytics page.
     */
    public function reportsPage(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Admin access required.');
        }

        $period = $request->query('period', '30');
        $startDate = now()->subDays((int)$period);

        // User growth
        $userGrowth = User::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Content stats
        $contentStats = [
            'total_books' => Book::count(),
            'new_books' => Book::where('created_at', '>=', $startDate)->count(),
            'pending_books' => Book::where('approved', false)->count(),
            'total_poems' => Poem::count(),
            'new_poems' => Poem::where('created_at', '>=', $startDate)->count(),
            'pending_poems' => Poem::where('approved', false)->count(),
        ];

        // Event stats
        $eventStats = [
            'total_events' => Event::count(),
            'upcoming_events' => Event::where('date', '>', now())->count(),
            'total_tickets' => Ticket::count(),
            'tickets_sold' => Ticket::where('status', 'active')->count(),
        ];

        // Top creators - use subqueries for PostgreSQL compatibility
        $topCreators = User::withCount(['poems', 'uploadedBooks as books_count'])
            ->whereHas('poems')
            ->orWhereHas('uploadedBooks')
            ->get()
            ->sortByDesc(fn($user) => $user->poems_count + $user->books_count)
            ->take(10)
            ->values();

        // Chatroom stats
        $chatroomStats = [
            'total_rooms' => \App\Models\ChatRoom::count(),
            'active_rooms' => \App\Models\ChatRoom::has('members')->count(),
        ];

        return view('admin.reports', compact(
            'period',
            'userGrowth',
            'contentStats',
            'eventStats',
            'topCreators',
            'chatroomStats'
        ));
    }

    /**
     * Get notifications for the current user.
     */
    public function getNotifications(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $limit = $request->query('limit', 10);
        $unreadOnly = $request->query('unread_only', false);

        $query = Notification::where('user_id', $user->id)
            ->orderByDesc('created_at');

        if ($unreadOnly) {
            $query->unread();
        }

        $notifications = $query->take($limit)->get();
        $unreadCount = Notification::where('user_id', $user->id)->unread()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markNotificationRead($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $notification = Notification::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$notification) {
            return response()->json(['message' => 'Notification not found.'], 404);
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllNotificationsRead()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
