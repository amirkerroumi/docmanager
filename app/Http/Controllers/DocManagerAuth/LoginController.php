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

        if ($validator->fails()) {
            return redirect('login')
                ->withErrors($validator)
                ->withInput();
        }

        $email = $request->input('email');
        $pwd = $request->input('password');
        //$apiService = resolve('DocManagerApiService');
        $login = $apiService->login($email, $pwd);
        if($login)
        {
            return redirect('/home');
        }

//        $client = new Client();
//        $postData['form_params'] = [
//                'grant_type' => 'password',
//                'client_id' => 1,
//                'client_secret' => '01buKMc1arjNvrpSBzXoLKBbt4JwLPhOaxgnyzwE',
//                'username' => $email,
//                'password' => $pwd
//            ];
//        $time = Carbon::now();
//        $response = $client->request('POST', 'http://api.docmanager.app/v1/oauth/token', $postData);
//        if ($response instanceof PsrResponseInterface)
//        {
//            $response = (new HttpFoundationFactory)->createResponse($response);
//        }
//        elseif (! $response instanceof SymfonyResponse)
//        {
//            $response = new Response($response);
//        }
//        elseif ($response instanceof BinaryFileResponse)
//        {
//            $response = $response->prepare(Request::capture());
//        }

//        $responseContent=json_decode($response->getContent(), true);
//        if($responseContent['success'])
//        {
//            $responseData = $responseContent['data'];
//            $access_token = $responseData['access_token'];
//            $access_token_expiration_time = Carbon::createFromTimestamp($responseData['expires_at']);
//
//            session(['access_token' => $access_token, '$access_token_expiration_time' => $access_token_expiration_time, 'username' => $email]);
//            return redirect('/home');
//        }
//        else
//        {
//            $errorInfo = $responseContent['message'];
//            if($errorInfo == "Invalid user credentials")
//            {
//                $validator->getMessageBag()->add('password', $errorInfo);
//                $validator->getMessageBag()->add('email', $errorInfo);
//                return redirect('/login')->withErrors($validator)->withInput();
//            }
//        }

    }
}
