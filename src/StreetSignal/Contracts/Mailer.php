<?php

/**
 * StreetSignal Platform Mailer Tool
 *
 * Send emails
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

interface Mailer
{
    /**
     * Send a templated email
     *
     * @param  string     $to     Destination email
     * @param  string     $type   Email type (ie. template to use)
     * @param  Array|null $params Params for populating the template
     * @return void
     */
    public function send($to, $type, array $params = null);
}
