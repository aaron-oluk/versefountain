<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home(): View
    {
        return view('index');
    }

    /**
     * Display the refund and cancellation policies page.
     */
    public function refundPolicies(): View
    {
        return view('refund-cancellation-policies');
    }
}
