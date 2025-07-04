<?php

namespace StreetSignal\DataSource\Contracts;

/**
 * Interface for DataSource Message Types
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    DataSource
 * @copyright  2013 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License Version 3 (GPLv3)
 *
 */
interface MessageType
{
    const SMS = 'sms';
    const TWITTER = 'twitter';
    const IVR = 'ivr';
    const EMAIL = 'email';
}
