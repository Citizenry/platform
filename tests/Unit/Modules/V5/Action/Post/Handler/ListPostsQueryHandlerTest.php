<?php

namespace Tests\Unit\Modules\V5\Action\Post\Handler;

use App\Bus\Query\Query;
use Illuminate\Pagination\LengthAwarePaginator;
use StreetSignal\Modules\V5\Actions\Post\Handlers\ListPostsQueryHandler;
use StreetSignal\Modules\V5\Actions\Post\Queries\ListPostsQuery;
use StreetSignal\Modules\V5\Models\Post\Post;
use StreetSignal\Modules\V5\Repository\Post\PostRepository;
use StreetSignal\Tests\TestCase;

class ListPostsQueryHandlerTest extends TestCase
{
    public function testShouldReturnPaginatedResult(): void
    {
        // $post =  Post::factory()->create();
        // $postRepository = $this->createMock(PostRepository::class);
        // $postRepository->method('paginate')->willReturn(new LengthAwarePaginator([$post], 1, 1));
        // $query = ListPostsQuery::fromArray([
        //     'limit' => 1,
        // ]);
        // $handler = new ListPostsQueryHandler($postRepository);
        // $result = $handler($query);
        // $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        // $this->assertEquals($result->count(), 1);
        // $this->assertInstanceOf(Post::class, $result->first());
        // $this->assertEquals($result->first()->id, $post->id);
    }

    public function testShouldThrowOnProvidingIncorrectQuery(): void
    {
        // $postRepository = $this->createMock(PostRepository::class);
        // $this->expectException(\InvalidArgumentException::class);
        // $handler = new ListPostsQueryHandler($postRepository);
        // $handler($this->createMock(Query::class));
    }
}
