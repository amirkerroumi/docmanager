<?php

namespace App\Http\Controllers\DocManagerAuth;

use App\User;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

use GuzzleHttp\Exception\ClientException;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:5|confirmed',
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('docmanagerauth.register');
    }

    /**
     * @param Request $request
     */
    protected function create(Request $request)
    {
        $formData['json'] = $request->all();
        if(isset($formData['json']['_token']))
        {
            unset($formData['json']['_token']);
        }

        try
        {
            $client = new Client();
            $response = $client->request('POST', 'http://api.docmanager.app/v1/user', $formData);
            if ($response instanceof PsrResponseInterface) {
                $response = (new HttpFoundationFactory)->createResponse($response);
            } elseif (! $response instanceof SymfonyResponse) {
                $response = new Response($response);
            } elseif ($response instanceof BinaryFileResponse) {
                $response = $response->prepare(Request::capture());
            }
            var_dump($response);
        }
        catch(ClientException $e)
        {
            $eMsg = $e->getMessage();
        }
    }
}
