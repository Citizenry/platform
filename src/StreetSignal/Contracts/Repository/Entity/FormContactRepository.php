<?php

/**
 * Repository for Form Contacts
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\EntityGet;
use StreetSignal\Contracts\EntityExists;

interface FormContactRepository extends
    EntityGet,
    EntityExists
{

    /**
     * @param  int $form_id
     * @return [StreetSignal\Contracts\Repository\Entity\FormContact, ...]
     */
    public function getByForm($form_id);

    /**
     * @param  int $contact_id
     * @param  int $form_id
     * @return [StreetSignal\Contracts\Repository\Entity\FormContact, ...]
     */
    public function existsInFormContact($contact_id, $form_id);

    /**
     * @param  [StreetSignal\Contracts\Repository\Entity\FormContact, ...]  $entities
     * @return [StreetSignal\Contracts\Repository\Entity\FormContact, ...]
     */
    public function updateCollection(array $entities);
}
