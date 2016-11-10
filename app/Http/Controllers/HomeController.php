<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

use App\Http\Requests;

use GuzzleHttp\Client;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class HomeController extends Controller
{
    //
    public function index(Request $request)
    {
        $client = new Client();

        $content = "No content";
        try
        {
            $headers = ['headers' => ['Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . $request->session()->get('access_token') ]];
            $response = $client->request('GET', 'http://api.docmanager.app/v1/helloWorld', $headers);
            if ($response instanceof PsrResponseInterface) {
                $response = (new HttpFoundationFactory)->createResponse($response);
            } elseif (! $response instanceof SymfonyResponse) {
                $response = new Response($response);
            } elseif ($response instanceof BinaryFileResponse) {
                $response = $response->prepare(Request::capture());
            }
            $content = $response->getContent();
        }
        catch(ClientException $e)
        {
            $eMsg = $e->getMessage();
            $eRes = strstr($eMsg, 'response:');
            $jsonMsg = strstr($eRes, ':');
            $res = substr($jsonMsg, 1, strlen($jsonMsg));

            $msg = $this->isJSON($res) ? json_decode($res, true) : str_replace("\n","",$res);
            $content = "Error: " . $msg;
        }

        return "Welcome Home " . $request->session()->get('username') . " ! " . $content;
    }

    function isJSON($string)
    {
        return is_string($string) && is_object(json_decode($string)) ? true : false;
    }
}
