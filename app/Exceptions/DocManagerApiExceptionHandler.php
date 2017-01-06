<?php
/**
 * Created by PhpStorm.
 * User: a_kerroumi
 * Date: 30/11/2016
 * Time: 10:46
 */

namespace App\Exceptions;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

trait DocManagerApiExceptionHandler
{
    public function handleApiResponse($response)
    {
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
        if($response['success'] || $response['error_type'] == 'docmanager_user_error')
        {
            return $response;
        }
        else
        {
            $this->displayErrorPage($response);
        }
    }

    public function displayErrorPage($response)
    {
        $errorData = [];
        $debug = env('APP_DEBUG');
        if($debug)
        {
            if($response['error_type'] == 'docmanager_api_error')
            {
                $errorData['code'] = $response['code'];
                $errorData['status'] = $response['status'];
                $errorData['hint'] = $response['hint'];
                $errorData['message'] = "Error message from API - " . $response['hint'];
            }
            else if($response['error_type'] == 'php_error')
            {
                $errorData['status'] = $response['status'];
                $errorData['message'] = "Error message from API - " . $response['message'];
                $errorData['error_file'] = $response['error_file'];
                $errorData['error_line'] = $response['error_line'];
                $errorData['error_trace_string'] = $response['error_trace_string'];
            }
        }
        $errorData = json_encode($errorData, true);
        switch($status = $response['status'])
        {
            //Bad Request
            case ($status / 100 == 4):
                //Unauthorized (Authentication or permission pb)
                if(in_array($status, [401, 403]))
                {

                }
                else
                {
                    abort(404, $errorData);
                }
                break;
            //Server Error
            case ($status / 100 == 5):
                //Service Unavailable
                if($status == 503)
                {

                }
                break;
            default:
                //404
                abort(404, $errorData);
                return 0;
        }
    }
}