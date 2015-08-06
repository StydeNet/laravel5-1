<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class EditProfileTest extends TestCase
{

    use DatabaseTransactions;

    public function testEditProfile()
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->visit('account')
            ->click('Edit profile')
            ->seePageIs('account/edit-profile')
            ->seeInField('name', 'Duilio')
            ->type('Silence', 'name')
            ->press('Update profile')
            ->seePageIs('account')
            ->see('Your profile has been updated')
            ->seeInDatabase('users', [
                'email' => $user->email,
                'name'  => 'Silence'
            ]);
    }

}