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


class DocManagerApiService implements ApiService
{
    protected $client;

    protected $endPoint;
    protected $apiVersion;

    protected $clientId;
    protected $clientSecret;

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
    public function __call($name, $arguments)
    {
        $method = strtoupper($name);
        if(in_array($method, ['GET', 'POST', 'PUT', 'DELETE']))
        {
            $uri = $this->endPoint.'/'.$this->apiVersion.$arguments[0];
            $params = isset($arguments[1]) ? $arguments[1] : [];
            $response = $this->handleApiResponse($this->client->request($method, $uri, $params));
            return $response;
        }
    }

    /**
     * @param $email
     * @param $password
     */
    public function login($email, $password)
    {
        $params['form_params'] = [
            'grant_type' => 'password',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => $email,
            'password' => $password
        ];
        $responseData = $this->post('/oauth/token', $params);
        $access_token = $responseData['access_token'];
        $access_token_expiration_time = Carbon::createFromTimestamp($responseData['expires_at']);
        session(['access_token' => $access_token, '$access_token_expiration_time' => $access_token_expiration_time, 'username' => $email]);
        return true;
    }
}