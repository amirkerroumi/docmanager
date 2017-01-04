<?php
/**
 * Created by PhpStorm.
 * User: a_kerroumi
 * Date: 03/01/2017
 * Time: 10:59
 */

namespace App\Services;

interface ApiService
{
    public function __call($name, $arguments);
    public function login($email, $password);
}