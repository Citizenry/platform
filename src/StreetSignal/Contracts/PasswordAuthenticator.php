<?php

/**
 * StreetSignal Platform Password Authenticator Tool
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

interface PasswordAuthenticator
{
    /**
     * @param  string password in plain text
     * @param  string stored password hash
     * @return boolean
     * @throws \StreetSignal\Core\Exception\AuthenticatorException
     */
    public function checkPassword($plaintext, $hash);
}
