<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $siteSetting = SiteSetting::current()->loadMissing('media');
        return view('frontend.pages.contact.contact', compact('siteSetting'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'name'    => ['required', 'string', 'max:150'],
                'phone'   => ['required', 'string', 'max:50', 'regex:/^[0-9+()\-\s]+$/'],
                'email'   => ['required', 'email:rfc', 'max:190'],
                'message' => ['required', 'string', 'max:5000'],
            ],
            ['phone.regex' => 'Please enter a valid phone number.']
        );

        ContactMessage::create([
            'name'    => $validated['name'],
            'phone'   => $validated['phone'],
            'email'   => strtolower($validated['email']),
            'subject' => 'Website Contact Form',
            'message' => $validated['message'],
            'status'  => 'new',
        ]);

        return redirect()
            ->route('contact.index')
            ->with(
                'contact_success',
                'Thank you. Your message has been sent successfully.'
            );
    }
}
