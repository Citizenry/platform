<?php

namespace StreetSignal\Tests\Unit\Modules\V3\Repository;

use StreetSignal\Modules\V3\Repository\UserRepository;
use StreetSignal\Core\Entity\User;
use StreetSignal\Tests\TestCase;
use StreetSignal\Tests\DatabaseTransactions;
use Mockery as M;
use Faker;

/**
 * @backupGlobals disabled
 * @preserveGlobalState disabled
 */
class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetResetToken()
    {
        $db = M::mock(\Illuminate\Database\Connection::class);
        $resolver = M::mock(\StreetSignal\Core\Tool\OhanzeeResolver::class);
        $resolver->shouldReceive('connection')->andReturn($db);

        $repo = new UserRepository($resolver);
        $user = new User(['id' => 1]);

        // Mock Laravel's query builder chain
        $queryBuilder = M::mock(\Illuminate\Database\Query\Builder::class);
        $db->shouldReceive('table')->with('user_reset_tokens')->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('insert')->andReturn(true);

        $token = $repo->getResetToken($user);

        $this->assertIsString($token);
    }

    public function testCreateMany()
    {
        $faker = Faker\Factory::create();

        // Generate user data
        $user1 = new User([
            'email' => $faker->email,
            'realname' => $faker->name,
            'role' => 'user'
        ]);
        $user2 = new User([
            'email' => $faker->email,
            'realname' => $faker->name,
            'role' => 'user',
            'contacts' => [
                ['contact' => 'ushahidi', 'type' => 'twitter'],
            ]
        ]);
        $user3 = new User([
            'email' => $faker->email,
            'realname' => $faker->name,
            'password' => $faker->password,
            'role' => 'user',
            'contacts' => [
                ['contact' => 'ushbot', 'type' => 'twitter', 'can_notify' => 0],
                ['contact' => '12345678', 'type' => 'phone', 'can_notify' => 1],
            ]
        ]);

        $repo = service('repository.user');
        $inserted = $repo->createMany(collect([
            $user1,
            $user2,
            $user3,
        ]));

        $this->assertCount(3, $inserted);
        $this->seeInOhanzeeDatabase('users', [
            'id' => $inserted[0],
            'email' => $user1->email,
            'realname' => $user1->realname
        ]);
        $this->seeInOhanzeeDatabase('users', [
            'id' => $inserted[1],
            'email' => $user2->email,
            'realname' => $user2->realname
        ]);
        $this->seeInOhanzeeDatabase('users', [
            'id' => $inserted[2],
            'email' => $user3->email,
            'realname' => $user3->realname,
        ]);

        // Ensure unhashed password isn't saved
        $this->notSeeInOhanzeeDatabase('users', [
            'email' => $user3->email,
            'password' => $user3->password,
        ]);

        $this->seeInOhanzeeDatabase('contacts', [
            'user_id' => $inserted[1],
            'contact' => 'ushahidi',
            'can_notify' => 0,
            'type' => 'twitter',
        ]);
        $this->seeInOhanzeeDatabase('contacts', [
            'user_id' => $inserted[2],
            'contact' => '12345678',
            'can_notify' => 1,
            'type' => 'phone',
        ]);
        $this->seeInOhanzeeDatabase('contacts', [
            'user_id' => $inserted[2],
            'contact' => 'ushbot',
            'can_notify' => 0,
            'type' => 'twitter',
        ]);
    }
}
