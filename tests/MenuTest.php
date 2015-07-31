<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MenuTest extends TestCase
{
    use DatabaseTransactions;

    public function testAccountLink()
    {
        // Guest users
        $this->visit('/')->dontSee('Account');

        $user = $this->createUser();

        $this->actingAs($user)
            ->visit('/')
            ->see('Account');

        $this->click('Account')
            ->seePageIs('account')
            ->see('My account');
    }

}