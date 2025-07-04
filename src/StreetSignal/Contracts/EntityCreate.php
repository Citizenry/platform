<?php

/**
 * Repository for Creating Entities
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html
 *             GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

interface EntityCreate
{
    /**
     * Creates a new record and returns the created id.
     * @return mixed
     */
    public function create(Entity $entity);
}
