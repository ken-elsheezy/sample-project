<?php


namespace Tests\Feature\Controllers\UserController;


use App\Models\User;
use Tests\TestCase;

class CreateMethodTest extends TestCase
{

    public function testThatAUserCanBeCreatedSuccessfully()
    {
        /*
         * Before making request,
         * lets quickly check that users do not exist.
         */
        $users = User::all();

        $this->assertCount(0, $users);

        /*
         * No we make a request to the Create User
         * endpoint with the request payload below.
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
         * Checking the payload to ensure that the
         * response content is exactly what we expect.
         */
        $result = json_decode($response->content());

        $this->assertArrayHasKey('user', $result['data']);

        /*
         * We verify that the User Mr BoB
         * now exists in our database.
         */
        $users = User::where('email', 'mr.bob@example.com')->get();

        $this->assertCount(1, $users);
    }


    public function testThatAUserCannotCreateAnAccountIfTheUserSuppliesAnEmailThatAlreadyExists()
    {
        /*
         * We quickly simulate that a new User
         * signs up with email mr.bob@example.com
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
         * Now we simulate that another User or Mr Bob
         * attempts to sign up again with the same email.
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

        /*
         * As expected, during email validation we check
         * to see if email already exists in the database
         *  and in this case the request fails as expected.
         */
        $response->assertStatus(400);
    }
}