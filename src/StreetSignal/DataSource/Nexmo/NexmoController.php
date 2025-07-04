<?php

namespace StreetSignal\DataSource\Nexmo;

/**
 * Base class for all Data Providers
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\DataSource
 * @copyright  2013 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

use StreetSignal\DataSource\DataSourceController;
use StreetSignal\Contracts\Contact;
use StreetSignal\DataSource\Contracts\MessageType;
use Illuminate\Http\Request;

class NexmoController extends DataSourceController
{
    protected $source = 'nexmo';

    public function handleRequest(Request $request)
    {
        try {
            $message = \Vonage\Message\InboundMessage::createFromGlobals();
            if (!$message->isValid() || !$message->getBody() || !$message->getFrom()) {
                abort(400, "Invalid message");
            }
        } catch (\Throwable $th) {
            abort(400, "Invalid message");
        }

        // Remove Non-Numeric characters because that's what the DB has
        $to = preg_replace("/[^0-9,+.]/", "", $message->getTo());
        $from  = preg_replace("/[^0-9,+.]/", "", $message->getFrom());

        $this->save([
            'type' => MessageType::SMS,
            'from' => $from,
            'contact_type' => Contact::PHONE,
            'message' => $message->getBody(),
            'to' => $to,
            'title' => null,
            'data_source_message_id' => $message->getMessageId(),
            'data_source' => 'nexmo'
        ]);

        // Then return success
        return [
            'success' => true
        ];
    }
}
