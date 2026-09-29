<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:newsletter_subscribers,email'],
        ], [
            'email.unique' => 'Email ini sudah terdaftar sebagai subscriber.',
        ]);

        NewsletterSubscriber::create($validated);

        return back()->with('newsletter_success', 'Terima kasih! Anda berhasil berlangganan.');
    }
}
