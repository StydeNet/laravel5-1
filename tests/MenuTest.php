<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MenuTest extends TestCase
{
    use DatabaseMigrations;

    public function testAccountLink()
    {
        // Guest users
        $this->visit('/')->dontSee('Account');

        // Create a user
        $user = factory(App\User::class)->create([
            'name'  => 'Duilio',
            'email' => 'admin@styde.net',
            'role'  => 'admin',
            'password' => bcrypt('admin'),
        ]);

        $this->actingAs($user)
            ->visit('/')
            ->see('Account');

        $this->click('Account')
            ->seePageIs('account')
            ->see('My account');
    }

}