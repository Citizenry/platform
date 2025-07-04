<?php

/**
 * Search Posts in Set Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Set;

use StreetSignal\Core\Usecase\Post\SearchPost;

class SearchSetPost extends SearchPost
{
    use SetRepositoryTrait,
        VerifySetExistsTrait;

    /**
     * Get filter parameters as search data.
     *
     * Override to filter posts to just this set
     *
     * @return SearchData
     */
    protected function getSearch()
    {
        $set_id = $this->getIdentifier('set_id');
        $fields = $this->repo->getSearchFields();
        $paging = $this->getPagingFields();

        $filters = $this->getFilters(array_merge($fields, array_keys($paging)));

        // Include set_id identifier in filters to ensure
        // we only get posts from in this set
        $this->search->setFilters(array_merge($paging, $filters, ['set' => $set_id]));
        $this->search->setSortingKeys(array_keys($paging));

        return $this->search;
    }
}
