<?php


namespace StreetSignal\Modules\V5\Http\Resources\SavedSearch;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SavedSearchCollection extends ResourceCollection
{
    public static $wrap = 'results';

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = 'StreetSignal\Modules\V5\Http\Resources\SavedSearch\SavedSearchResource';
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'count' => $this->count(),
            'results' => $this->collection
        ];
    }

    public function count(): int
    {
        return count($this->collection);
    }
}
