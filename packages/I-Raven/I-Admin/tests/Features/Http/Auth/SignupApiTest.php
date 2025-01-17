<?php

namespace IRaven\IAdmin\Tests\Features\Http\Auth;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use IRaven\IAdmin\Domain\Models\Admin;
use IRaven\IAdmin\Domain\Models\User;
use IRaven\IAdmin\Infra\Database\Factories\UserFactory;
use IRaven\IAdmin\Tests\TestCase;
use TiMacDonald\Log\LogFake;

/**
 * Class SignupApiTest
 * @package IRaven\IAdmin\Tests\Features\Http\Auth
 */
class SignupApiTest extends TestCase
{
    public function construct(): void
    {
    }

    public function destruct(): void
    {
        // TODO: Implement destruct() method.
    }

    /**
     * @test
     */
    public function it_should_signup()
    {
        $user = User::factory()->make();

        $response = $this->postJson('i-raven/i-admin/api/v1/auth/signup', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => UserFactory::PASSWORD,
        ]);

        $this->assertSame($response->getStatusCode(), Response::HTTP_CREATED);
        $this->assertDatabaseHas('users', ['email' => $user->email, 'name' => $user->name], 'landlord');
        $this->assertDatabaseHas('admins', ['partner_id' => 1], 'landlord');
        $this->assertEquals($user->email, $response->getData()->data->email);
        $this->assertEquals(Admin::PENDING, $response->getData()->data->rule);
    }

    /**
     * @test
     */
    public function it_should_return_error_when_can_cont_find_partner()
    {
        Log::swap(new LogFake);

        $user = User::factory()->make();
        $logs = [
            '["The name may not be greater than 255 characters."]',
        ];

        $response = $this->postJson('i-raven/i-admin/api/v1/auth/signup', [
            'name' => $this->faker->sentence(100),
            'email' => $user->email,
            'password' => UserFactory::PASSWORD,
        ]);

        $this->assertSame($response->getStatusCode(), Response::HTTP_FOUND);
        $this->assertEquals('ERR', $response->getData()->status);
        Log::assertLogged('error', function ($message, $context) use ($logs) {
            return in_array($message, $logs);
        });
    }
}
