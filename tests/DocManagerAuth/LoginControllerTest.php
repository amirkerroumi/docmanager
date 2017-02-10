<?php

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
//        $this->visit('/')->seePageIs('/login');
    }

    public function testAuthenticate()
    {
        $this->visit('/login')
            ->type('amirkerroumi@gmail.com', 'email')
            ->type('Amiral', 'password')
            ->press('Login')->seePageIs('/home');
    }
}
