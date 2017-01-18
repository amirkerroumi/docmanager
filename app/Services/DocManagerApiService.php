<?php
/**
 * Created by PhpStorm.
 * User: a_kerroumi
 * Date: 29/11/2016
 * Time: 16:26
 */

namespace App\Services;

use App\Exceptions\DocManagerApiExceptionHandler;
use GuzzleHttp\Client;

use Carbon\Carbon;

/*
 * This Service class enables to interact with the "docmanager_api" API
 */
class DocManagerApiService implements ApiService
{
    protected $client;

    protected $endPoint;
    protected $apiVersion;

    protected $clientId;
    protected $clientSecret;

    //Trait enabling to handle errors returned by the "docmanager_api" API
    use DocManagerApiExceptionHandler;

    /**
     * DocManagerApiService constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->endPoint = env('API_ENDPOINT', 'http://api.docmanager.app');
        $this->apiVersion = env('API_VERSION', 'v1');
        $this->clientId = env('CLIENT_ID', '');
        $this->clientSecret = env('CLIENT_SECRET', '');
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this|Response|mixed|SymfonyRespons
     */
    /*
     * This function handle GET, POST, PUT and DELETE http requests to the API
     */
    public function __call($name, $arguments)
    {
        $method = strtoupper($name);
        if(in_array($method, ['GET', 'POST', 'PUT', 'DELETE']))
        {
            $uri = $this->endPoint.'/'.$this->apiVersion.$arguments[0];
            $params = isset($arguments[1]) ? $arguments[1] : [];
            /*
             * handleApiResponse() is defined in DocManagerApiExceptionHandler trait
             * and it handles errors returned by the API
             */
            $response = $this->handleApiResponse($this->client->request($method, $uri, $params));
            return $response;
        }
    }

    /**
     * @param $email
     * @param $password
     */
    /*
     * This class enables a user to login to the docmanager_api.
     * If login is successful, the API will provide an access_token and an expiration time for it.
     * The access_token and its expiration time are stored in session variables.
     */
    public function login($email, $password)
    {
        $params['form_params'] = [
            'grant_type' => 'password',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'email' => $email,
            'password' => $password
        ];
        $response = $this->post('/oauth/token', $params);
        if($response['success'])
        {
            $responseData = $response['data'];
            $access_token = $responseData['access_token'];
            $access_token_expiration_time = Carbon::createFromTimestamp($responseData['expires_at']);
            session(['access_token' => $access_token, 'access_token_expiration_time' => $access_token_expiration_time, 'email' => $email]);
        }
        return $response;
    }

    public function register($userData)
    {
        $response = $this->post('/user', $userData);
        return $response;
    }

    public function resetPassword($email)
    {
        $params['form_params'] = ['email' => $email];
        $response = $this->post('/password/email', $params);
        return $response;
    }
}