<?php

/**
 * Repository for Form
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\EntityCreate;
use StreetSignal\Contracts\EntityCreateMany;
use StreetSignal\Contracts\EntityGet;
use StreetSignal\Contracts\EntityExists;

interface FormRepository extends
    EntityGet,
    EntityExists,
    EntityCreate,
    EntityCreateMany
{
    public function isTypeHidden($form_id, $type);

    /**
     * Get all form attributes and stages for the forms matching the given ids.
     *
     * @param array $form_ids The array of form ids to filter by
     */
    public function getAllFormStagesAttributes(array $form_ids = []): \Illuminate\Support\Collection;

    public function getRolesThatCanCreatePosts($form_id);
}
