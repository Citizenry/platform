<?php

namespace StreetSignal\Modules\V5\Actions\Post\Queries;

use App\Bus\Query\Query;
use StreetSignal\Modules\V5\Models\Post\Post;
use Illuminate\Http\Request;
use StreetSignal\Modules\V5\DTO\PostSearchFields;
use StreetSignal\Modules\V5\Traits\OnlyParameter\QueryWithOnlyParameter;
use StreetSignal\Modules\V5\Traits\HasPaginate;
use StreetSignal\Modules\V5\Traits\HasSearchFields;

class ListPostsQuery implements Query
{
    use QueryWithOnlyParameter;
    use HasPaginate;
    use HasSearchFields;

    public static function fromRequest(Request $request): self
    {
        $query = new self();
        $query->setPaging($request);
        $query->setSearchFields(new PostSearchFields($request));
        $query->addOnlyParameteresFromRequest($request, Post::ALLOWED_FIELDS, Post::ALLOWED_RELATIONSHIPS, Post::REQUIRED_FIELDS);
        return $query;
    }
}
