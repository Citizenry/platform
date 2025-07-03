<?php

namespace Tests\Unit\Modules\V5\Action\Post\Handler;

use App\Bus\Query\Query;
use StreetSignal\Modules\V5\Actions\Post\Handlers\FindPostByIdQueryHandler;
use StreetSignal\Modules\V5\Actions\Post\Queries\FindPostByIdQuery;
use StreetSignal\Modules\V5\Models\Post\Post;
use StreetSignal\Modules\V5\Repository\Post\PostRepository;
use StreetSignal\Tests\TestCase;

class FindPostByIdQueryHandlerTest extends TestCase
{
    public function testSuccessfullyFindingPost(): void
    {
        // Given
        // $postModel = Post::factory()->create();
        // $postRepository = $this->createMock(PostRepository::class);
        // $postRepository->method('findById')->willReturn($postModel);

        // // When
        // $handler = new FindPostByIdQueryHandler($postRepository);
        // $post = $handler(new FindPostByIdQuery(1));

        // // Then
        // $this->assertInstanceOf(Post::class, $post);
        // $this->assertEquals($post->id, $postModel->id);
    }

    public function testThrowingOnProvidingIncorrectQuery(): void
    {
        // Should
        // $this->expectException(\InvalidArgumentException::class);

        // // Given
        // $postRepository = $this->createMock(PostRepository::class);

        // // When
        // $handler = new FindPostByIdQueryHandler($postRepository);
        // $handler($this->createMock(Query::class));
    }
}
