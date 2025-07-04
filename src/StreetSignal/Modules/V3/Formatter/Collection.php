<?php

/**
 * StreetSignal Collection Formatter
 *
 * Implements URL handling for paging parameters.
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter;

use StreetSignal\Contracts\Formatter;
use StreetSignal\Contracts\CollectionFormatter;
use StreetSignal\Core\Exception\FormatterException;

class Collection implements CollectionFormatter
{
    protected $formatter;

    /**
     * @var \StreetSignal\Core\Tool\SearchData
     */
    protected $search;

    /**
     * @var integer
     */
    protected $total;

    /**
     * Collection formatter recursively invokes an entity-specific formatter.
     *
     * @param \StreetSignal\Contracts\Formatter $formatter
     */
    public function __construct(Formatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * Store paging parameters.
     *
     * @param \StreetSignal\Core\Tool\SearchData $search
     *
     */
    public function setSearch($search, int $total = null)
    {
        $this->search = $search;
        $this->total  = $total;
        return $this;
    }

    // Formatter
    public function __invoke($entities)
    {
        if (!is_array($entities)) {
            throw new FormatterException('Collection formatter requries an array of entities');
        }

        $results = [];
        foreach ($entities as $entity) {
            $results[] = $this->formatter->__invoke($entity);
        }

        $output = [
            'count'   => count($results),
            'results' => $results,
        ];

        if ($this->search) {
            $output += $this->getPaging();
        }

        return $output;
    }

    /**
     * Collections are always paged, which requires pages metadata to be added
     * to the results.
     *
     * @return array
     */
    public function getPaging()
    {
        // Get paging parameters, ensuring all values are set
        $params = $this->search->getSorting(true);

        $prev_params = $next_params = $params;
        $next_params['offset'] = $params['offset'] + $params['limit'];
        $prev_params['offset'] = $params['offset'] - $params['limit'];
        $prev_params['offset'] = $prev_params['offset'] > 0 ? $prev_params['offset'] : 0;

        // @todo inject this
        $request = app('request');

        $curr = url($request->path()) . '?' . http_build_query($params);
        $next = url($request->path()) . '?' . http_build_query($next_params);
        $prev = url($request->path()) . '?' . http_build_query($prev_params);

        return [
            'limit'       => $params['limit'],
            'offset'      => $params['offset'],
            'order'       => $params['order'],
            'orderby'     => $params['orderby'],
            'curr'        => $curr,
            'next'        => $next,
            'prev'        => $prev,
            'total_count' => $this->total
        ];
    }
}
