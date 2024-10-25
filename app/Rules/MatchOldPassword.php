<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class MatchOldPassword implements Rule
{
    public function passes($attribute, $value) {
        $currentUser = auth()->user();
        if (Hash::check($value, $currentUser->password)) {
            return true;
        } else {
            return false;
        }
    }

    public function message()
    {
        return 'Password lama yang dimasukkan, tidak sesuai / tidak sama dengan password lama saat ini.';
    }
}
