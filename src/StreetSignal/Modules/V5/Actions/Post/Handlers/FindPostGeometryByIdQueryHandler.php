<?php

namespace StreetSignal\Modules\V5\Actions\Post\Handlers;

use App\Bus\Action;
use App\Bus\Query\Query;
use App\Bus\Query\AbstractQueryHandler;
use StreetSignal\Modules\V5\Actions\Post\Queries\FindPostGeometryByIdQuery;
use StreetSignal\Modules\V5\Repository\Post\PostRepository;
use StreetSignal\Core\Concerns\GeometryConverter;
use Symm\Gisconverter\Decoders\WKT;

class FindPostGeometryByIdQueryHandler extends AbstractQueryHandler
{
    use GeometryConverter;
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    protected function isSupported(Query $query)
    {
        if (!$query instanceof FindPostGeometryByIdQuery) {
            throw new \InvalidArgumentException('Provided action is not supported');
        }
    }

    public function __invoke(Action $action)
    {
        /**
         * @var FindPostGeometryByIdQuery $action
         */
        $this->isSupported($action);
        return $this->postRepository->getPostGeoJson($action->getId());
    }
}
