<?php

/**
 * Repository for Post Lock
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2017 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\EntityGet;

interface PostLockRepository extends EntityGet
{
    public function releaseLock($entity_id);

    public function releaseLockByLockId($lock_id);

    public function isActive($entity_id);

    public function getPostLock($entity_id);

    public function postIsLocked($entity_id);
}
