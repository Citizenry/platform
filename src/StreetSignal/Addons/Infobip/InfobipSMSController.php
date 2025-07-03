<?php

namespace StreetSignal\Addons\Infobip;

/**
 * InfobipSMS Callback controller
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    Addons\Infobip
 * @copyright  2023 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

use Illuminate\Http\Request;
use StreetSignal\Contracts\Contact;
use StreetSignal\DataSource\Contracts\MessageType;
use StreetSignal\DataSource\DataSourceController;

class InfobipSMSController extends DataSourceController
{
    protected $source = 'infobip';

    public function handleRequest(Request $request)
    {
        $results = collect($request->input('results'));

        $results->each(function ($result) {
            $data = [
                'type' => MessageType::SMS,
                'from' => $result['from'],
                'contact_type' => Contact::PHONE,
                'message' => $result['text'],
                'to' => $result['to'],
                'title' => null,
                'datetime' => $result['receivedAt'] ?? null,
                'data_source_message_id' => $result['messageId'],
                'data_source' => 'InfobipSMS',
                'additional_data' => [
                ]
            ];

            $this->save($data);
        });

        return response()->json(['status' => 'ok']);
    }
}
