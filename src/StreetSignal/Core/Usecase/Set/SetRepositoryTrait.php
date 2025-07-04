<?php

/**
 * Set Repository Entity Trait
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Set;

use StreetSignal\Contracts\Repository\Entity\SetRepository;

trait SetRepositoryTrait
{
    protected $setRepo;

    public function setSetRepository(SetRepository $setRepo)
    {
        $this->setRepo = $setRepo;
        return $this;
    }

    public function getSetRepository()
    {
        return $this->setRepo;
    }
}
