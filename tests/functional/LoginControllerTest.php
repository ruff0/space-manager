<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @tests
     */
    public function user_can_register()
    {
        $this->visit('/login');
        $this->click('Registrate');
        $this->type('foo', 'name');
        $this->type('foo@bar.com', 'email');
        $this->type('P@ssw0rd', 'password');
        $this->type('P@ssw0rd', 'password_confirmation');
        $this->press('Registrame');
        $this->seePageIs('/home');
        $this->see('Para continuar rellena tu perfil');
    }
}