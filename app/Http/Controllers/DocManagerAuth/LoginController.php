<?php

namespace App\Http\Controllers\DocManagerAuth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


use Validator;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


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

    public function authenticate(Request $request)
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

        $client = new Client();
        $httpRequest['form_params'] = [
                'grant_type' => 'password',
                'client_id' => 1,
                'client_secret' => '01buKMc1arjNvrpSBzXoLKBbt4JwLPhOaxgnyzwE',
                'username' => $email,
                'password' => $pwd
            ];
        $time = Carbon::now();
        try
        {
            $response = $client->request('POST', 'http://api.docmanager.app/oauth/token', $httpRequest);
            if ($response instanceof PsrResponseInterface) {
                $response = (new HttpFoundationFactory)->createResponse($response);
            } elseif (! $response instanceof SymfonyResponse) {
                $response = new Response($response);
            } elseif ($response instanceof BinaryFileResponse) {
                $response = $response->prepare(Request::capture());
            }
            $responseContent=json_decode($response->getContent(), true);
            $access_token = $responseContent['access_token'];
            $access_token_expiring_time = $time->addSeconds($responseContent['expires_in']);
            session(['access_token' => $access_token, 'access_token_expiring_time' => $access_token_expiring_time, 'username' => $email]);
            return redirect('/home');
        }
        catch(ClientException $e)
        {
            $eMsg = $e->getMessage();
            $res = strstr($eMsg, 'response:');
            $jsonMsg = strstr($res, '{');
            $msg = json_decode($jsonMsg, true)['message'];
            $validator->getMessageBag()->add('password', $msg);
            $validator->getMessageBag()->add('email', $msg);
            return redirect('/login')->withErrors($validator)->withInput();
        }


    }
}
