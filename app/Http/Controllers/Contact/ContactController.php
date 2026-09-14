<?php

namespace App\Http\Controllers\Contact;

use App\Data\ContactMessageData;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    /**
     * Show the contact page.
     */
    public function index(): Response
    {
        return Inertia::render('Contact', [
            'contactInfo' => [
                'address' => "Mikocheni Light Industrial Area\nP.O. Box 4374 Dar es Salaam, Tanzania",
                'addressLine1' => 'Mikocheni Light Industrial Area',
                'addressLine2' => 'P.O. Box 4374 Dar es Salaam, Tanzania',
                'phone' => '+255 22 277 5914/6',
                'phoneHours' => 'Mon to Fri 9am to 6pm',
                'email' => 'info@eatv.tv',
                'emailMessage' => 'Send us your query anytime!',
            ],
            'status' => session('status'),
            'success' => session('success'),
        ]);
    }

    /**
     * Store contact message.
     */
    public function store(Request $request): RedirectResponse
    {
        $messageData = ContactMessageData::fromRequest($request);

        // Process messageData (e.g. log / notify / store)

        return redirect()->back()->with('success', 'Your message has been received! Our support team will respond shortly.');
    }
}
