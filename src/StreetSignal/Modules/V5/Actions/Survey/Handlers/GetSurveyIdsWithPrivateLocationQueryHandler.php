<?php

namespace StreetSignal\Modules\V5\Actions\Survey\Handlers;

use StreetSignal\Modules\V5\Actions\V5QueryHandler;
use App\Bus\Query\Query;
use StreetSignal\Modules\V5\Actions\Survey\Queries\GetSurveyIdsWithPrivateLocationQuery;
use StreetSignal\Modules\V5\Repository\Survey\SurveyRepository;
use StreetSignal\Modules\V5\Models\Survey;
use App\Bus\Query\QueryBus;

class GetSurveyIdsWithPrivateLocationQueryHandler extends V5QueryHandler
{

    private $survey_repository;

    public function __construct(SurveyRepository $survey_repository)
    {
        $this->survey_repository = $survey_repository;
    }

    protected function isSupported(Query $query)
    {
        assert(
            get_class($query) === GetSurveyIdsWithPrivateLocationQuery::class,
            'Provided query is not supported'
        );
    }


    /**
     * @param GetSurveyIdsWithPrivateLocationQuery $query
     * @return Survey
     */
    public function __invoke($query) //: array
    {
        $this->isSupported($query);
        return $this->survey_repository->getSurveysIdsWithPrivateLocation();
    }
}
