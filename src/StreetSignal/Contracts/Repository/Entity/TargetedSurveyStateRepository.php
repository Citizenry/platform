<?php

/**
 * Repository for TargetedSurveyState
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
use StreetSignal\Contracts\Repository\UpdateRepository;

interface TargetedSurveyStateRepository extends
    EntityGet,
    EntityExists,
    UpdateRepository
{

    /**
     * @param string  $contact
     * @return boolean
     */
    public function getActiveByContactId($contact_id);

    /**
     * @param string  $contact
     * @return boolean
     */
    public function isContactInActiveTargetedSurveyAndReceivedMessage($contact);
}
