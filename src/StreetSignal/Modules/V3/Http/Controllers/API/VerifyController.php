<?php

/**
 * StreetSignal REST Base Controller
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @copyright  2013 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Http\Controllers\API;

use Illuminate\Http\Response;
use App\PlatformVerifier\DebugMode;
use StreetSignal\Modules\V3\Http\Controllers\RESTController;

class VerifyController extends RESTController
{
    protected function getResource()
    {
        return 'verifier';
    }

    /**
     * @var array List of HTTP methods which may be cached
     */
    protected $cacheableMethods = [];

    /**
     * Get current api version
     */
    public static function version()
    {
        return self::$version;
    }

    public function db()
    {
        if (! DebugMode::isEnabled()) {
            return (new Response(null, 204))
                    ->header('X-StreetSignal-Platform-Install-Debug-Mode', 'off');
        }

        $output = new \App\PlatformVerifier\Database();

        return $output->verifyRequirements(false);
    }

    public function conf()
    {
        if (! DebugMode::isEnabled()) {
            return (new Response(null, 204))
                    ->header('X-StreetSignal-Platform-Install-Debug-Mode', 'off');
        }

        $output = new \App\PlatformVerifier\Env();

        return $output->verifyRequirements(false);
    }
}
