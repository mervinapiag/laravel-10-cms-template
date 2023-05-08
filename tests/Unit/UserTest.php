<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_form()
    {

        $response = $this->get(route('auth.index'));

        $response->assertStatus(200);
    }


    public function test_login_post()
    {
        $response = $this->post(route('auth.login'),
        [
            'email' => 'mervin@gm2ail.com',
            'password' => '12345678'
        ]);

        $response->assertRedirect(route('admin.index'));
    }
}
