<?php

namespace StreetSignal\DataSource\Contracts;

/**
 * Interface for DataSource Message Direction
 *
 * @author     StreetSignal Dev Team, Emmanuel Kala <emkala(at)gmail.com>
 * @package    StreetSignal - http://ping.streetsignal.com
 * @copyright  StreetSignal - http://www.streetsignal.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License Version 3 (GPLv3)
 *
 */
interface MessageDirection
{
    const INCOMING = 'incoming';

    const OUTGOING = 'outgoing';
}
