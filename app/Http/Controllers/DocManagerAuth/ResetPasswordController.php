<?php

namespace App\Http\Controllers\DocManagerAuth;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendEmail(Request $request, ApiService $apiService)
    {
        //Form validator
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|',
        ]);

        //If form validation fails, errors are returned to the form and displayed
        if ($validator->fails())
        {
            return redirect('/password/reset')
                ->withErrors($validator)
                ->withInput();
        }

        $email = $request->input('email');
        $response = $apiService->resetPassword($email);
        if ($response['success'])
        {
            return redirect('/password/reset')->with('reset_email_sent', true);
            //return "You will receive an email with instructions on how to reset your password.";
        }
        //If login to the api fails, errors are returned to the form and displayed
        else
        {
            return redirect('/password/reset')->withErrors($response['user_messages'])->withInput();
        }
    }
}
