<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function showStep1Form()
    {
        return view('auth.register-step1');
    }

    public function postStep1(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $request->session()->put('registration_data', $validated);

        return redirect()->route('register.step2');
    }

    public function showStep2Form(Request $request)
    {
        if (!$request->session()->has('registration_data')) {
            return redirect()->route('register');
        }

        return view('auth.register-step2');
    }

    public function postStep2(Request $request)
    {
        $validated = $request->validate([
            'current_weight' => ['required', 'numeric', 'min:1'],
            'weight_goal' => ['required', 'numeric', 'min:1'],
        ]);

        $registrationData = $request->session()->get('registration_data');
        $finalData = array_merge($registrationData, $validated);

        DB::transaction(function () use ($finalData) {
            $user = User::create([
                'name' => $finalData['name'],
                'email' => $finalData['email'],
                'password' => Hash::make($finalData['password']),
            ]);

            WeightTarget::create([
                'user_id' => $user->id,
                'target_weight' => $finalData['weight_goal'],
            ]);

            WeightLog::create([
                'user_id' => $user->id,
                'date' => now()->toDateString(),
                'weight' => $finalData['current_weight'],
                'calories' => 0,
            ]);

            Auth::login($user);
            session()->forget('registration_data');
        });

        return redirect()->route('admin');
    }
}

