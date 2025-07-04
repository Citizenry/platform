<?php
/**
 * StreetSignal Form Contact
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */
namespace StreetSignal\Core\Entity;

use StreetSignal\Core\StaticEntity;

class FormStats extends StaticEntity
{
    protected $total_responses;
    protected $total_recipients;
    protected $total_response_recipients;
    protected $total_messages_sent;
    protected $total_messages_pending;
    protected $total_by_data_source;
    // DataTransformer
    protected function getDefinition()
    {
        return [
            'total_responses'            => 'int',
            'total_response_recipients'  => 'int',
            'total_recipients'           => 'int',
            'total_messages_sent'        => 'int',
            'total_messages_pending'     => 'int',
            'total_by_data_source'       => [
                'all' => 'int',
                'sms' => 'int',
                'web' => 'int',
                'twitter' => 'int',
                'mobile' => 'int',
                'email' => 'int'
            ],
        ];
    }

    // Entity
    public function getResource()
    {
        return 'form_stats';
    }
}
