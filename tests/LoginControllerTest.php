<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testIndex()
    {
        $this->visit('/')->seePageIs('/login');
    }

    public function testAuthenticate()
    {
        $this->visit('/login')
            ->type('amirkerroumi@gmail.com', 'email')
            ->type('MyPwd', 'password')
            ->press('Login')->seePageIs('/home');
    }
}
