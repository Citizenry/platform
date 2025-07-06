<?php

namespace StreetSignal\Tests\Unit\Modules\V3\Repository;

use Faker;
use Ohanzee\DB;
use Mockery as M;
use StreetSignal\Tests\TestCase;
use Illuminate\Database\Connection;
use Aura\Di\Injection\Factory;
use StreetSignal\Core\Entity\Post;
use StreetSignal\Core\Entity\User;
use StreetSignal\Tests\DatabaseTransactions;
use StreetSignal\Contracts\Session;
use Illuminate\Support\Collection;
use StreetSignal\Core\Tool\SearchData;
use StreetSignal\Core\Tool\OhanzeeResolver;
use StreetSignal\Modules\V3\Repository\PostRepository;
use StreetSignal\Modules\V3\Repository\Post\ValueFactory;
use StreetSignal\Core\Tool\Permissions\PostPermissions;
use StreetSignal\Contracts\Repository\Entity\FormRepository;
use StreetSignal\Contracts\Repository\Entity\ContactRepository;
use StreetSignal\Contracts\Repository\Entity\PostLockRepository;
use StreetSignal\Contracts\Repository\Entity\FormStageRepository;
use StreetSignal\Contracts\Repository\Entity\FormAttributeRepository;

/**
 * @backupGlobals disabled
 * @preserveGlobalState disabled
 */
class PostRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        // Add some test attributes
        DB::insert('form_attributes')
            ->columns(['key', 'type', 'input', 'label'])
            ->values(['test-location', 'point', 'location', 'location'])
            ->values(['test-tags', 'tags', 'tags', 'categories'])
            ->values(['test-test', 'varchar', 'text', 'some text'])
            ->values(['test-media', 'media', 'upload', 'photos'])
            ->execute($this->database);

        DB::insert('tags')
            ->columns(['tag', 'slug', 'id'])
            ->values(['test-tag1', 'test-tag1', 99991])
            ->values(['test-tag2', 'test-tag2', 99992])
            ->values(['test-tag3-test', 'test-tag3', 99993])
            ->execute($this->database);

        DB::insert('media')
            ->columns(['o_filename', 'caption', 'id', 'mime', 'o_size'])
            ->values(['junk.png', 'Junk', 8889, 'image/png', 0])
            ->execute($this->database);
    }

    public function testCreateMany()
    {
        $faker = Faker\Factory::create();

        $repo = service('repository.post');
        
        // Inject the test's database connection directly into the repository's resolver
        $repoReflection = new \ReflectionClass($repo);
        $resolverProperty = $repoReflection->getProperty('resolver');
        $resolverProperty->setAccessible(true);
        $resolver = $resolverProperty->getValue($repo);
        
        // Use reflection to inject the test's database connection into the resolver
        $resolverReflection = new \ReflectionClass($resolver);
        $connectionProperty = $resolverReflection->getProperty('connection');
        $connectionProperty->setAccessible(true);
        $connectionProperty->setValue($resolver, $this->database);
        
        // Generate post data
        $post1 = new Post([
            'title' => $faker->sentence,
            'context' => $faker->paragraph,
            'type' => 'report',
            'status' => 'published',
            'locale' => 'en_US',
            'base_language' => 'en_US',
            'values' => [
                'test-location' => [[
                    'lat' => 1,
                    'lon' => 2
                ]],
                'test-tags' => [99991,99993],
                'test-test' => ['text'],
            ]
        ]);
        $post2 = new Post([
            'title' => $faker->sentence,
            'context' => $faker->paragraph,
            'type' => 'report',
            'status' => 'published',
            'locale' => 'en_US',
            'base_language' => 'en_US',
            'values' => [
                'test-location' => [[
                    'lat' => 2,
                    'lon' => 4
                ]],
                'test-tags' => [99992],
                'test-test' => ['text2'],
            ]
        ]);
        $post3 = new Post([
            'title' => $faker->sentence,
            'context' => $faker->paragraph,
            'type' => 'report',
            'status' => 'published',
            'locale' => 'en_US',
            'base_language' => 'en_US',
            'values' => [
                'test-location' => [[
                    'lat' => 7,
                    'lon' => 9
                ]],
                'test-tags' => [99993],
                'test-test' => ['text3'],
            ]
        ]);

        $inserted = $repo->createMany(collect([
            $post1,
            $post2,
            $post3,
        ]));

        $this->assertCount(3, $inserted);
        $this->seeInOhanzeeDatabase('posts', [
            'id' => $inserted[0],
            'title' => $post1->title,
        ]);
        $this->seeInOhanzeeDatabase('posts', [
            'id' => $inserted[1],
            'title' => $post2->title,
        ]);
        $this->seeInOhanzeeDatabase('posts', [
            'id' => $inserted[2],
            'title' => $post3->title,
        ]);

        $this->seeInOhanzeeDatabase('post_point', [
            'post_id' => $inserted[0],
            'value' => DB::expr('POINT(2, 1)')
        ]);
        $this->seeInOhanzeeDatabase('post_point', [
            'post_id' => $inserted[1],
            'value' => DB::expr('POINT(4, 2)')
        ]);
        $this->seeInOhanzeeDatabase('post_point', [
            'post_id' => $inserted[2],
            'value' => DB::expr('POINT(9, 7)')
        ]);

        $this->seeInOhanzeeDatabase('posts_tags', [
            'post_id' => $inserted[0],
            'tag_id' => 99991
        ]);
        $this->seeInOhanzeeDatabase('posts_tags', [
            'post_id' => $inserted[0],
            'tag_id' => 99993
        ]);
        $this->seeInOhanzeeDatabase('posts_tags', [
            'post_id' => $inserted[1],
            'tag_id' => 99992
        ]);
        $this->seeInOhanzeeDatabase('posts_tags', [
            'post_id' => $inserted[2],
            'tag_id' => 99993
        ]);

        $this->seeInOhanzeeDatabase('post_varchar', [
            'post_id' => $inserted[0],
            'value' => 'text'
        ]);
        $this->seeInOhanzeeDatabase('post_varchar', [
            'post_id' => $inserted[1],
            'value' => 'text2'
        ]);
        $this->seeInOhanzeeDatabase('post_varchar', [
            'post_id' => $inserted[2],
            'value' => 'text3'
        ]);
    }

    public function testCreateManyWithMedia()
    {
        $faker = Faker\Factory::create();

        $repo = service('repository.post');
        
        // Inject the test's database connection directly into the repository's resolver
        $repoReflection = new \ReflectionClass($repo);
        $resolverProperty = $repoReflection->getProperty('resolver');
        $resolverProperty->setAccessible(true);
        $resolver = $resolverProperty->getValue($repo);
        
        // Use reflection to inject the test's database connection into the resolver
        $resolverReflection = new \ReflectionClass($resolver);
        $connectionProperty = $resolverReflection->getProperty('connection');
        $connectionProperty->setAccessible(true);
        $connectionProperty->setValue($resolver, $this->database);

        // Generate post data
        $post1 = new Post([
            'title' => $faker->sentence,
            'context' => $faker->paragraph,
            'type' => 'report',
            'status' => 'published',
            'locale' => 'en_US',
            'base_language' => 'en_US',
            'values' => [
                'test-location' => [[
                    'lat' => 1,
                    'lon' => 2
                ]],
                'test-tags' => [99991,99993],
                'test-test' => ['text'],
                'test-media' => [
                    [
                        'o_filename' => 'somefile.png',
                        'caption' => 'a title',
                        'mime' => 'image/png',
                    ]
                ]
            ]
        ]);
        $post2 = new Post([
            'title' => $faker->sentence,
            'context' => $faker->paragraph,
            'type' => 'report',
            'status' => 'published',
            'locale' => 'en_US',
            'base_language' => 'en_US',
            'values' => [
                'test-location' => [[
                    'lat' => 2,
                    'lon' => 4
                ]],
                'test-tags' => [99992],
                'test-test' => ['text2'],
                'test-media' => [
                    [
                        'o_filename' => 'somefile2.png',
                        'caption' => 'a title',
                        'mime' => 'image/png',
                    ],
                    8889
                ]
            ]
        ]);

        $inserted = $repo->createMany(collect([
            $post1,
            $post2
        ]));

        $this->assertCount(2, $inserted);
        $this->seeInOhanzeeDatabase('posts', [
            'id' => $inserted[0],
            'title' => $post1->title,
        ]);
        $this->seeInOhanzeeDatabase('posts', [
            'id' => $inserted[1],
            'title' => $post2->title,
        ]);

        $this->seeCountInOhanzeeDatabase('post_media', [
            'post_id' => $inserted[0],
        ], 1);
        $this->seeCountInOhanzeeDatabase('post_media', [
            'post_id' => $inserted[1],
        ], 2);
        $this->seeInOhanzeeDatabase('post_media', [
            'post_id' => $inserted[1],
            'value' => 8889
        ]);
    }

    public function testSetSearchParamsLimitedUnprivileged()
    {
        $this->doTestSetSearchParams(0, 1, config('posts.list_max_limit'));
    }

    public function testSetSearchParamsLimitedPrivileged()
    {
        $this->doTestSetSearchParams(1, 1, config('posts.list_admin_max_limit'));
    }

    public function testSetSearchParamsNonlimitedUnprivileged()
    {
        $this->doTestSetSearchParams(0, 0);
    }

    public function testSetSearchParamsNonlimitedPrivileged()
    {
        $this->doTestSetSearchParams(1, 0);
    }

    /**
     * bool $canManagePosts
     * bool $limitPosts
     * int|null $expectedLimit
     */
    public function doTestSetSearchParams($canManagePosts, $limitPosts, $expectedLimit = null)
    {
        // we don't need to test anything but the LIMIT on the end of the sql so mock everything else in the db
        $db = M::mock(Connection::class);
        $grammar = M::mock('Illuminate\Database\Query\Grammars\Grammar');
        $processor = M::mock('Illuminate\Database\Query\Processors\Processor');
        $queryBuilder = M::mock('Illuminate\Database\Query\Builder');
        
        $db->shouldReceive('getQueryGrammar')->andReturn($grammar);
        $db->shouldReceive('getPostProcessor')->andReturn($processor);
        $db->shouldReceive('table')->andReturn($queryBuilder);
        
        $fakeLimit = 10000; // this limit should be overridden if limitPosts
        
        // Mock all the query builder methods that might be called
        $queryBuilder->shouldReceive('join')->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('leftJoin')->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('on')->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('select')->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('where')->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('whereIn')->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('orderBy')->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('limit')->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('offset')->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('groupBy')->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('compile')->with($db)->andReturn('SELECT * FROM posts LIMIT ' . ($expectedLimit ?? $fakeLimit));
        $resolver = M::mock(OhanzeeResolver::class);
        $resolver->shouldReceive('connection')->andReturn($db);
        $form_attribute_repo = M::mock(FormAttributeRepository::class);
        $form_stage_repo = M::mock(FormStageRepository::class);
        $attrs = M::mock(Collection::class);
        $attrs->shouldReceive('groupBy');
        $attrs->shouldReceive('keyBy');
        $form_repo = M::mock(FormRepository::class);
        $form_repo->shouldReceive('getAllFormStagesAttributes')->andReturn($attrs);
        $post_lock_repo = M::mock(PostLockRepository::class);
        $contact_repo = M::mock(ContactRepository::class);
        $post_value_factory = M::mock(ValueFactory::class);
        $bounding_box_factory = M::mock(Factory::class);

        $repo = new PostRepository(
            $resolver,
            $form_attribute_repo,
            $form_stage_repo,
            $form_repo,
            $post_lock_repo,
            $contact_repo,
            $post_value_factory,
            $bounding_box_factory
        );
        $user = new User();
        $session = M::mock(Session::class);
        $session->shouldReceive('getUser')->andReturn($user);
        $repo->setSession($session);

        $postPermissions = M::mock(PostPermissions::class);
        $postPermissions->shouldReceive('canUserManagePosts')->with($user)
            ->andReturn($canManagePosts)->times($limitPosts);
        $repo->setPostPermissions($postPermissions);

        $search = M::Mock(SearchData::class);
        $search->shouldReceive('getSorting')->andReturn(['limit' => $fakeLimit]);
        $search->shouldReceive('getFilter')->with('limitPosts')->andReturn($limitPosts)->once();
        $search->shouldReceive('getFilter'); // we only care about limitPosts
        // run the test method
        $query = $repo->setSearchParams($search);
        // grab the resulting SQL and pull off the LIMIT clause on the end
        $sql = $query->compile($db);
        $limitPos = strpos($sql, 'LIMIT ');
        $limit = substr($sql, $limitPos + 6);
        $expectedLimit = $expectedLimit ?? $fakeLimit;
        $this->assertEquals($expectedLimit, $limit);
    }
}
