<?php

namespace StreetSignal\Addons\Mteja;

/**
 * AfricasTalking Data Provider
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    Addons\Mteja
 * @copyright  2022 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License Version 3 (GPLv3)
 */

use Illuminate\Routing\Router;
use StreetSignal\DataSource\Contracts\MessageType;
use StreetSignal\DataSource\Contracts\MessageStatus;
use StreetSignal\Addons\Mteja\ShortMessageController;
use StreetSignal\DataSource\Concerns\MapsInboundFields;
use StreetSignal\DataSource\Contracts\CallbackDataSource;
use StreetSignal\DataSource\Contracts\OutgoingDataSource;

class MtejaSource implements CallbackDataSource, OutgoingDataSource
{
    use MapsInboundFields;

    protected $config;

    /**
     * Constructor function for DataSource
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function getName()
    {
        return 'Mteja';
    }

    public function getId()
    {
        return strtolower($this->getName());
    }

    public function getServices()
    {
        return [MessageType::SMS];
    }

    public function getOptions()
    {
        return [
            'app_id' => [
                'label' => 'APP ID',
                'input' => 'text',
                'description' => 'The APP Id',
                'rules' => ['required']
            ],
            'api_key' => [
                'label' => 'API Key',
                'input' => 'text',
                'description' => 'The API key',
                'rules' => ['required']
            ],
            'short_code' => [
                'label' => 'SMS Short code',
                'input' => 'text',
                'description' => 'The short code for sms channel',
                'rules' => ['required']
            ],
        ];
    }

    public function getInboundFields()
    {
        return [
            'Message' => 'text'
        ];
    }

    public function isUserConfigurable()
    {
        return true;
    }

    public function send($to, $message, $title = "", $contact_type = null, $message_type = null, $metadata = [])
    {
        $appId = $this->config['app_id'];
        $apiKey = $this->config['api_key'];

        switch ($message_type) {
            case MessageType::SMS:
                $response = $this->broadcastViaSms($appId, $apiKey, [
                    'referenceId' => null,
                    'to' => $to,
                    'from' => $this->config['short_code'],
                    'text' => $message
                ]);
                $data = [MessageStatus::SENT, $response['requestId'] ?? false];
                break;
            case MessageType::IVR:
                $data = [MessageStatus::UNKNOWN, false]; // An IVR Prompt with a question to ask a question
            default:
                $data = [MessageStatus::FAILED, false];
                break;
        }

        return $data;
    }

    public static function registerRoutes(Router $router)
    {
        $router->post('sms/mteja', ShortMessageController::class . '@handleRequest');
    }

    protected function broadcastViaSms($appId, $apiKey, $payload)
    {
        $response = (new MtejaService)->request('POST', 'sms', [
            'json' => $payload,
            'headers' => [
                'X-API-Key' => $apiKey,
                'X-APP-ID' => $appId,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);

        return $response;
    }
}
