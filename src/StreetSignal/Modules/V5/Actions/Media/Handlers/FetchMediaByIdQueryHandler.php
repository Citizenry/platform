<?php

namespace StreetSignal\Modules\V5\Actions\Media\Handlers;

use App\Bus\Query\AbstractQueryHandler;
use App\Bus\Query\Query;
use StreetSignal\Modules\V5\Actions\Media\Queries\FetchMediaByIdQuery;
use StreetSignal\Modules\V5\Repository\Media\MediaRepository;

class FetchMediaByIdQueryHandler extends AbstractQueryHandler
{

    private $media_repository;

    public function __construct(MediaRepository $media_repository)
    {
        $this->media_repository = $media_repository;
    }

    protected function isSupported(Query $query)
    {
        assert(
            get_class($query) === FetchMediaByIdQuery::class,
            'Provided query is not supported'
        );
    }

    /**
     * @param FetchMediaByIdQuery $query
     * @return array
     */
    public function __invoke($query) //: array
    {
        $this->isSupported($query);
        return $this->media_repository->findById($query->getId());
    }
}
