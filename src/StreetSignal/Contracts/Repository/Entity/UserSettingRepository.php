<?php

/**
 * Repository for User Setting
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2018 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\EntityGet;
use StreetSignal\Contracts\EntityExists;

interface UserSettingRepository extends
    EntityGet,
    EntityExists
{

    /**
     * @param  int $form_id
     *
     * @return [StreetSignal\Contracts\Repository\Entity\UserSetting, ...]
     */
    public function getByUser($user_id);
}
