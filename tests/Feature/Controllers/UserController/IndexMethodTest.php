<?php


namespace Tests\Feature\Controllers\UserController;


use Tests\TestCase;

class IndexMethodTest extends TestCase
{
    public function testThatAUserCanBeRetrievedById()
    {
        /*
         * Before we retrieve a user lets quickly create one
         */
        $response = $this->json(
            'POST',
            '/api/v1/user',
            [
                'first_name' => 'Mr',
                'last_name' => 'Bob',
                'email' => 'mr.bob@example.com',
                'password' => 'secret***'
            ]
        );

        $response->assertStatus(201);

        /*
         * The response of the create user endpoint will return
         * the user in the data attribute, we shall extract
         * the id and  proceed to retrieve this new user.
         */
        $result = (array) json_decode($response->content());

        $id = $result['data']['user']['id'];

        $response = $this->json(
            'GET',
            '/api/v1/user/' . $id,
            []
        );

        $response->assertStatus(200);
    }


    public function testThatAnInvalidIdWillNotReturnAnyUser()
    {
        /*
         * Here we simulate the invalid id scenario,
         * by calling the retrieve user endpoint
         * without actually creating any user.
         */
        $id = 1;

        $response = $this->json(
            'GET',
            '/api/v1/user/' . $id,
            []
        );

        $response->assertStatus(404);
    }
}