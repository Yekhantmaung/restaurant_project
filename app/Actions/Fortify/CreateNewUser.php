<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'phone' => ['required', 'string', 'max:255'],      // <-- Phone အတွက် Validation တိုးထားပါတယ်
            'address' => ['required', 'string', 'max:255'],    // <-- Address အတွက် Validation တိုးထားပါတယ်
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => $input['phone'],                        // <-- Form ကပါလာတဲ့ phone ကို သိမ်းဆည်းခြင်း
            'address' => $input['address'],                    // <-- Form ကပါလာတဲ့ address ကို သိမ်းဆည်းခြင်း
        ]);
    }
}