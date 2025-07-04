<?php

/**
 * StreetSignal Contact Types
 *
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

interface Contact
{
    // Valid contact types
    const EMAIL    = 'email';
    const PHONE    = 'phone';
    const TWITTER  = 'twitter';
    const WHATSAPP = 'whatsapp';
}
