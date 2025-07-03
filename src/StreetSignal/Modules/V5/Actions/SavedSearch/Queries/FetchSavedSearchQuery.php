<?php

namespace StreetSignal\Modules\V5\Actions\SavedSearch\Queries;

use App\Bus\Query\Query;
use StreetSignal\Modules\V5\DTO\SavedSearchSearchFields;
use StreetSignal\Modules\V5\Traits\OnlyParameter\QueryWithOnlyParameter;
use StreetSignal\Modules\V5\Traits\HasPaginate;
use StreetSignal\Modules\V5\Traits\HasSearchFields;
use Illuminate\Http\Request;
use StreetSignal\Modules\V5\Models\Set;

class FetchSavedSearchQuery implements Query
{
    use QueryWithOnlyParameter;
    use HasPaginate;
    use HasSearchFields;

    const DEFAULT_LIMIT = 0;
    const DEFAULT_ORDER = "ASC";
    const DEFAULT_SORT_BY = "id";

    public static function fromRequest(Request $request): self
    {
        $query = new self();
        $query->setPaging($request, self::DEFAULT_SORT_BY, self::DEFAULT_ORDER, self::DEFAULT_LIMIT);
        $query->setSearchFields(new SavedSearchSearchFields($request));
        $excluded_relations = ['posts'];
        $query->addOnlyParameteresFromRequest($request, Set::ALLOWED_FIELDS, Set::ALLOWED_RELATIONSHIPS, Set::REQUIRED_FIELDS, $excluded_relations);
        return $query;
    }
}
