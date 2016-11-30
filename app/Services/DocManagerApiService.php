<?php
/**
 * Created by PhpStorm.
 * User: a_kerroumi
 * Date: 29/11/2016
 * Time: 16:26
 */

namespace App\Services;

use GuzzleHttp\Client;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocManagerApiService
{
    protected $client;

    protected $endPoint;
    protected $apiVersion;

    protected $clientId;
    protected $clientSecret;

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
            $response = $this->client->request($method, $uri, $params);
            if ($response instanceof PsrResponseInterface)
            {
                $response = (new HttpFoundationFactory)->createResponse($response);
            }
            elseif (! $response instanceof SymfonyResponse)
            {
                $response = new Response($response);
            }
            elseif ($response instanceof BinaryFileResponse)
            {
                $response = $response->prepare(Request::capture());
            }
            $response = json_decode($response->getContent(), true);
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
        $response = $this->post('/oauth/token', $params);
        return $response;
    }
}