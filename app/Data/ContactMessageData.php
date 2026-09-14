<?php

namespace App\Data;

use Illuminate\Http\Request;

class ContactMessageData extends BaseData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $subject,
        public string $message,
    ) {}

    public static function fromRequest(Request $request): self
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:3000',
        ]);

        return new self(
            name: $validated['name'],
            email: $validated['email'],
            subject: $validated['subject'],
            message: $validated['message'],
        );
    }
}
