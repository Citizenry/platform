<?php

/**
 * StreetSignal Password Authenticator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool\Authenticator;

use StreetSignal\Contracts\PasswordAuthenticator;
use StreetSignal\Core\Exception\AuthenticatorException;

class Password implements PasswordAuthenticator
{
    public function checkPassword($plaintext, $hash)
    {
        if (!password_verify($plaintext, $hash)) {
            throw new AuthenticatorException("Password does not match this account");
        }
        return true;
    }
}
