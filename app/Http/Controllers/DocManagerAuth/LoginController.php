<?php

namespace App\Http\Controllers\DocManagerAuth;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


use Mockery\CountValidator\Exception;
use PhpParser\Comment\Doc;
use Validator;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

//use App\Services\DocManagerApiService;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * @param Request $request
     * @return $this
     *
     * This method enables to request an access token from the API by passing the user credentials (username, pwd)
     */
    public function authenticate(Request $request, ApiService $apiService)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails())
        {
            return redirect('login')
                ->withErrors($validator)
                ->withInput();
        }

        $email = $request->input('email');
        $pwd = $request->input('password');
        //$apiService = resolve('DocManagerApiService');
        $loginResponse = $apiService->login($email, $pwd);
        if (session()->has('access_token') && session()->has('access_token_expiration_time') && Carbon::now() < session('access_token_expiration_time'))
        {
            return redirect('/home');
        }
        else
        {
            $errorInfo = $loginResponse['message'];
            if ($errorInfo == "Invalid user credentials")
            {
                $validator->getMessageBag()->add('password', $errorInfo);
                $validator->getMessageBag()->add('email', $errorInfo);
                return redirect('/login')->withErrors($validator)->withInput();
            }
        }
    }
}
