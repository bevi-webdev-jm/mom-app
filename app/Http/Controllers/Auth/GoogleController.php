<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Company;
use Auth;

class GoogleController extends Controller
{

    public $company_map_arr = [
        'bevi.com.ph'           => 'BEVI',
        'beviasiapacific.com'   => 'BEVA',
        'bevmi.com'             => 'BEVM',
        'kojiesan.com'          => 'BEVI',
        'onestandpoint.com'     => 'OSP',
        'spcmicrotech.com'      => 'SPC',
        'thepbb.com'            => 'PBB',
    ];

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $email_arr = explode('@', $googleUser->email);
                $password = Hash::make(reset($email_arr).'123!');
                $domain = end($email_arr);

                $company = Company::where('name', $this->company_map_arr[$domain] ?? '')->first();

                $user = User::create([
                    'company_id' => $company->id ?? NULL,
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => $password, // Generate random password
                    'google_id' => $googleUser->id,
                ]);

                $user->assignRole('user');
            }

            Auth::login($user);

            return redirect()->route('home'); // Redirect to dashboard
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong.');
        }
    }
}
