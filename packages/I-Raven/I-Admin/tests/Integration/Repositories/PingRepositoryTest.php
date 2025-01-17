<?php

namespace IRaven\IAdmin\Tests\Integration\Repositories;

use IRaven\IAdmin\Domain\Exceptions\PingWriteException;
use IRaven\IAdmin\Domain\Models\Partner;
use IRaven\IAdmin\Domain\Models\Ping;
use IRaven\IAdmin\Infra\Repositories\PingRepository;
use IRaven\IAdmin\Tests\TestCase;
use IRaven\IAdmin\Domain\Contracts\Repositories\PingRepositoryContract;

/**
 * Class PingRepositoryTest
 * @package IRaven\IAdmin\Tests\Integration\Repositories
 */
class PingRepositoryTest extends TestCase
{
    /** @var PingRepositoryContract */
    private $repository;

    public function construct(): void
    {
        Partner::first()->makeCurrent();
        $this->repository = new PingRepository();
    }

    public function destruct(): void
    {
        // TODO: Implement destruct() method.
    }

    /**
     * @test
     * @throws PingWriteException
     */
    public function it_should_crate_new_ping()
    {
        $ip = $this->faker->ipv4;

        $expected = $this->repository->pingIp($ip);

        $this->assertEquals($ip, $expected->ip);
        $this->assertDatabaseHas('pings', ['ip' => $ip], 'partner');
    }

    /**
     * @test
     */
    public function it_should_update_ping()
    {
        /** @var Ping $ping */
        $ping = Ping::factory()->create();

        $expected = $this->repository->pingIp($ping->ip);

        $this->assertEquals($ping->ip, $expected->ip);
        $this->assertDatabaseHas('pings', ['ip' => $ping->ip], 'partner');
    }
}
