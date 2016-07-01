<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * @tests
	 */
	public function userCanRegister()
	{
		$this->registerUser();
	}

	/**
	 * @test
	 */
	public function registerGeneratesCorrectProfile()
	{
		$this->registerUser();
		$this->fillProfile();
		$this->seeInDatabase('profiles', [
			'name' => 'Test',
			'lastname' => 'User'
		]);


	}

	/**
	 * @test
	 */
	public function registerAssignsCorrectRoleToUser()
	{
		$this->registerUser();
		$this->fillProfile();

		$user = \App\User\User::latest()->first();
		$role = \App\Auth\Roles\Models\Role::where('name', 'member')->first();

		$this->seeInDatabase('role_user', [
			'user_id' => $user->id,
			'role_id' => $role->id
		]);


	}

	/**
	 * Registers a user to the application
	 */
	protected function registerUser()
	{
		$this->visit('/login');
		$this->click('register');
		$this->type('testuser', 'name');
		$this->type('test@user.com', 'email');
		$this->type('Cuadr1pedo', 'password');
		$this->type('Cuadr1pedo', 'password_confirmation');
		$this->check('conditions');
		$this->press('register');
		$this->seePageIs('/home');
		$this->see('Completa tu perfil');
	}

	/**
	 * Fills in the user profile
	 */
	protected function fillProfile()
	{
		$this->seePageIs('/home');
		$this->type('Test', 'name');
		$this->type('User', 'lastname');
		$this->type('0000000K', 'identity');
		$this->type('666666666', 'mobile');
		$this->type('966666666', 'phone');
		$this->type('c/ Test', 'address_line1');
		$this->type('1ª A', 'address_line2');
		$this->type('Test', 'city');
		$this->type('Test', 'state');
		$this->type('00000', 'zip');
		$this->type('Empresa Test', 'company_name');
		$this->type('B00000000C', 'company_identity');
		$this->press('save');

		$this->seePageIs('/home');
		$this->see('¿QUÉ QUIERES HACER?');
	}
}