<?php

/**
 * Repository for Contacts
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\EntityCreate;
use StreetSignal\Contracts\EntityCreateMany;
use StreetSignal\Contracts\EntityGet;
use StreetSignal\Contracts\EntityExists;
use StreetSignal\Contracts\Repository\CreateRepository;

interface ContactRepository extends
    EntityGet,
    EntityCreate,
    EntityCreateMany,
    EntityExists,
    CreateRepository
{
    /**
     * @param string  $contact
     * @param string  $type
     *
     * @return \StreetSignal\Contracts\Entity
     */
    public function getByContact($contact, $type);

    /**
     * Get all contacts that can be notified and filter by collection or saved search.
     * @param int $set_id collection or saved search id to filter by
     * @param bool|int $limit false to fetch all contacts
     * @param int $offset
     */
    public function getNotificationContacts($set_id, $limit = false, $offset = 0);
}
