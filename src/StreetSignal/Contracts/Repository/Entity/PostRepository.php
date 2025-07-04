<?php

/**
 * Repository for Posts
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\EntityCreate;
use StreetSignal\Contracts\EntityCreateMany;
use StreetSignal\Contracts\Repository\CreateRepository;
use StreetSignal\Contracts\Repository\SearchRepository;
use StreetSignal\Contracts\Repository\UpdateRepository;

interface PostRepository extends
    EntityCreate,
    EntityCreateMany,
    CreateRepository,
    UpdateRepository,
    SearchRepository
{
    /**
     * @param  int $id
     * @param  int $parent_id
     * @param  string $type
     * @return \StreetSignal\Contracts\Entity
     */
    public function getByIdAndParent($id, $parent_id, $type);

    /**
     * @param  string $locale
     * @param  int $parent_id
     * @param  string $type
     * @return \StreetSignal\Contracts\Entity
     */
    public function getByLocale($locale, $parent_id, $type);

    public function getTotal();
}
