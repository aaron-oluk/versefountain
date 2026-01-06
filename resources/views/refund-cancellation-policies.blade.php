@extends('layouts.app')

@section('title', 'Refund and Cancellation Policies - VerseFountain')

@section('content')
    <div class="min-h-screen">
        <div class="max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <a href="/" class="inline-flex items-center text-gray-600 hover:text-gray-900 text-sm font-normal mr-4">
                        <i class="bx bx-arrow-back text-base mr-1"></i>
                        Back to Home
                    </a>
                </div>
                <h1 class="text-3xl sm:text-4xl font-semibold text-gray-900 mb-2">Refund and Cancellation Policies</h1>
                <p class="text-base text-gray-600 leading-relaxed">Please review our policies regarding refunds and cancellations for event tickets and subscriptions.</p>
                <p class="text-sm text-gray-500 mt-2">Last updated: {{ now()->format('F j, Y') }}</p>
            </div>

            <!-- Refund Policy Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 sm:p-8 mb-6">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="bx bx-money text-2xl text-blue-600"></i>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-900">Refund Policy</h2>
                </div>

                <div class="space-y-6">
                    <!-- Eligibility -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Eligibility for Refunds</h3>
                        <p class="text-sm text-gray-700 leading-relaxed mb-3">
                            Refunds are available for event ticket purchases under the following conditions:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-sm text-gray-700 ml-4">
                            <li>Refund requests must be submitted at least 7 days before the event date</li>
                            <li>The event must not have been cancelled or rescheduled by the organizer</li>
                            <li>The ticket must not have been used or transferred to another user</li>
                            <li>Refund requests must be made through your account dashboard or by contacting support</li>
                        </ul>
                    </div>

                    <!-- Timeframes -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Refund Timeframes</h3>
                        <div class="bg-gray-50 rounded-lg p-4 mb-3">
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start">
                                    <i class="bx bx-check-circle text-blue-600 mr-2 mt-0.5"></i>
                                    <span><strong>30+ days before event:</strong> Full refund (100%)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="bx bx-check-circle text-blue-600 mr-2 mt-0.5"></i>
                                    <span><strong>7-29 days before event:</strong> Partial refund (50%)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="bx bx-x-circle text-gray-400 mr-2 mt-0.5"></i>
                                    <span><strong>Less than 7 days before event:</strong> No refund available</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Refund Process -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">How to Request a Refund</h3>
                        <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700 ml-4">
                            <li>Log in to your VerseFountain account</li>
                            <li>Navigate to your Tickets page</li>
                            <li>Select the ticket you wish to refund</li>
                            <li>Click "Request Refund" and provide a reason</li>
                            <li>Submit your request for review</li>
                        </ol>
                        <p class="text-sm text-gray-600 mt-3">
                            Alternatively, you can contact our support team directly with your ticket number and order details.
                        </p>
                    </div>

                    <!-- Non-Refundable Items -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Non-Refundable Items</h3>
                        <p class="text-sm text-gray-700 leading-relaxed mb-2">
                            The following items are not eligible for refunds:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-sm text-gray-700 ml-4">
                            <li>Digital downloads and instant access content</li>
                            <li>Event tickets purchased less than 7 days before the event</li>
                            <li>Tickets for events that have already occurred</li>
                            <li>Processing fees (if applicable)</li>
                        </ul>
                    </div>

                    <!-- Processing Times -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Refund Processing Times</h3>
                        <p class="text-sm text-gray-700 leading-relaxed mb-2">
                            Once your refund request is approved:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-sm text-gray-700 ml-4">
                            <li>Refunds are typically processed within 5-10 business days</li>
                            <li>Refunds will be issued to the original payment method used</li>
                            <li>You will receive an email confirmation once the refund has been processed</li>
                            <li>Bank processing times may vary (typically 3-5 additional business days)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Cancellation Policy Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 sm:p-8 mb-6">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="bx bx-x-circle text-2xl text-blue-600"></i>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-900">Cancellation Policy</h2>
                </div>

                <div class="space-y-6">
                    <!-- Subscription Cancellation -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Subscription Cancellation</h3>
                        <p class="text-sm text-gray-700 leading-relaxed mb-3">
                            You may cancel your VerseFountain Pro subscription at any time. Cancellations take effect at the end of your current billing period.
                        </p>
                        <div class="bg-blue-50 border-l-4 border-blue-600 p-4 mb-3">
                            <p class="text-sm text-blue-900">
                                <strong>Important:</strong> Cancelling your subscription will not provide an immediate refund. You will retain access to all premium features until the end of your current billing period.
                            </p>
                        </div>
                    </div>

                    <!-- How to Cancel -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">How to Cancel Your Subscription</h3>
                        <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700 ml-4">
                            <li>Log in to your VerseFountain account</li>
                            <li>Navigate to your Profile or Subscription settings</li>
                            <li>Click on "Manage Subscription"</li>
                            <li>Select "Cancel Subscription"</li>
                            <li>Confirm your cancellation and provide optional feedback</li>
                        </ol>
                    </div>

                    <!-- Refund Eligibility -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Refund Eligibility for Subscriptions</h3>
                        <p class="text-sm text-gray-700 leading-relaxed mb-3">
                            Subscription refunds are available under the following circumstances:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-sm text-gray-700 ml-4">
                            <li><strong>Within 7 days of purchase:</strong> Full refund available for new subscriptions</li>
                            <li><strong>Billing error:</strong> Full refund if you were charged incorrectly</li>
                            <li><strong>Service unavailability:</strong> Prorated refund if service was unavailable for extended periods</li>
                        </ul>
                        <p class="text-sm text-gray-600 mt-3">
                            Refunds are not available for subscriptions cancelled after the 7-day window, except in cases of billing errors or service unavailability.
                        </p>
                    </div>

                    <!-- Prorated Refunds -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Prorated Refunds</h3>
                        <p class="text-sm text-gray-700 leading-relaxed mb-2">
                            In cases where a prorated refund is applicable:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-sm text-gray-700 ml-4">
                            <li>Refunds are calculated based on the remaining days in your billing period</li>
                            <li>Processing fees (if any) are not refundable</li>
                            <li>Refunds are processed within 5-10 business days</li>
                        </ul>
                    </div>

                    <!-- Cancellation Effective Dates -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Cancellation Effective Dates</h3>
                        <p class="text-sm text-gray-700 leading-relaxed mb-2">
                            When you cancel your subscription:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-sm text-gray-700 ml-4">
                            <li>Your subscription remains active until the end of the current billing period</li>
                            <li>You will continue to have access to all premium features until that date</li>
                            <li>No further charges will be made after the cancellation date</li>
                            <li>You will receive an email confirmation with your cancellation date</li>
                        </ul>
                    </div>

                    <!-- Reactivation -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Reactivation Options</h3>
                        <p class="text-sm text-gray-700 leading-relaxed mb-2">
                            If you change your mind, you can reactivate your subscription:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-sm text-gray-700 ml-4">
                            <li>Reactivate at any time before your subscription period ends</li>
                            <li>No additional charges until your next billing cycle</li>
                            <li>All your previous settings and preferences will be restored</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 sm:p-8 mb-6">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="bx bx-support text-2xl text-blue-600"></i>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-900">Contact Us</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Need Help with Refunds or Cancellations?</h3>
                        <p class="text-sm text-gray-700 leading-relaxed mb-4">
                            If you have questions about refunds or cancellations, or need assistance with a request, please contact our support team.
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-3 text-sm">Required Information for Requests</h4>
                        <p class="text-sm text-gray-700 leading-relaxed mb-2">
                            When contacting support, please include:
                        </p>
                        <ul class="list-disc list-inside space-y-1 text-sm text-gray-700 ml-4">
                            <li>Your account email address</li>
                            <li>Order number or ticket ID</li>
                            <li>Date of purchase</li>
                            <li>Reason for refund/cancellation request</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2 text-sm">Support Channels</h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-center">
                                <i class="bx bx-envelope text-blue-600 mr-2"></i>
                                <span>Email: support@versefountain.com</span>
                            </li>
                            <li class="flex items-center">
                                <i class="bx bx-time text-blue-600 mr-2"></i>
                                <span>Response time: Within 24-48 hours</span>
                            </li>
                            <li class="flex items-center">
                                <i class="bx bx-calendar text-blue-600 mr-2"></i>
                                <span>Business hours: Monday - Friday, 9 AM - 5 PM EST</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Dispute Resolution Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 sm:p-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="bx bx-shield text-2xl text-blue-600"></i>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-900">Dispute Resolution</h2>
                </div>

                <div class="space-y-4">
                    <p class="text-sm text-gray-700 leading-relaxed">
                        If you are not satisfied with the resolution of your refund or cancellation request, you may:
                    </p>
                    <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700 ml-4">
                        <li>Request a review by our management team by emailing support@versefountain.com</li>
                        <li>Provide additional documentation or information to support your case</li>
                        <li>Allow up to 5 business days for a management review response</li>
                    </ol>
                    <p class="text-sm text-gray-600 mt-4">
                        We are committed to fair and transparent resolution of all disputes. All decisions are made in accordance with our terms of service and applicable consumer protection laws.
                    </p>
                </div>
            </div>

            <!-- Back to Home Link -->
            <div class="mt-8 text-center">
                <a href="/" class="inline-flex items-center text-blue-600 hover:text-blue-700 text-sm font-medium">
                    <i class="bx bx-arrow-back mr-2"></i>
                    Return to Home
                </a>
            </div>
        </div>
    </div>
@endsection

