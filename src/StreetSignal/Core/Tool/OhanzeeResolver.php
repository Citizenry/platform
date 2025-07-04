<?php

/**
 * StreetSignal Platform DB resolver
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool;

use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class OhanzeeResolver
{
    /**
     * @var Connection
     */
    protected $currentConnection;

    /**
     * @var string
     */
    protected $currentConnectionName = 'default';

    public function useDefaultConnection()
    {
        $this->currentConnectionName = 'default';
        $this->currentConnection = DB::connection('default');
    }

    public function setConnection($name, $config)
    {
        // Create a new database connection configuration
        $connectionConfig = [
            'driver' => 'mysql',
            'host' => $config['host'],
            'port' => $config['port'] ?? 3306,
            'database' => $config['database'],
            'username' => $config['username'],
            'password' => $config['password'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ];

        // Add the connection to Laravel's database manager
        Config::set("database.connections.{$name}", $connectionConfig);
        
        // Purge any existing connection with this name
        DB::purge($name);
        
        // Set as current connection
        $this->currentConnectionName = $name;
        $this->currentConnection = DB::connection($name);
    }

    public function connection()
    {
        if (!$this->currentConnection) {
            // Default to the default Laravel connection
            $this->currentConnection = DB::connection();
            $this->currentConnectionName = 'default';
        }

        return $this->currentConnection;
    }

    /**
     * Get the current connection name
     *
     * @return string
     */
    public function getConnectionName()
    {
        return $this->currentConnectionName;
    }
}
