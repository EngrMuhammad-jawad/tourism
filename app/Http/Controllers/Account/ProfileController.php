<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ProfileUpdateRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the customer's account page (profile + password forms).
     */
    public function edit(Request $request): View
    {
        return view('account.edit', [
            'user' => $request->user()->load('profile'),
        ]);
    }

    /**
     * Update name/email/phone plus the one-to-one profile record.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->safe()->only(['name', 'email', 'phone']));

        // A changed email address must be re-verified.
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $user->profile()->updateOrCreate([], $request->safe()->only([
            'address', 'city', 'country', 'passport_no', 'date_of_birth',
        ]));

        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return back()->with('status', 'profile-updated');
    }
}
