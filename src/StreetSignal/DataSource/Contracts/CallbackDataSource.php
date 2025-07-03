<?php

namespace StreetSignal\DataSource\Contracts;

use Illuminate\Routing\Router;

/**
 * Data Source interface for data source that communicate via callbacks
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    DataSource
 * @copyright  2013 StreetSignal
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License Version 3 (GPLv3)
 */
interface CallbackDataSource extends DataSource
{

    /**
     * @param \Illuminate\Routing\Router $router
     * @return void
     */
    public static function registerRoutes(Router $router);
}
