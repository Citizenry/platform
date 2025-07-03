<?php

/**
 * Repository for Message
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Core
 * @copyright  2022 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\EntityCreate;
use StreetSignal\Contracts\EntityCreateMany;
use StreetSignal\Contracts\EntityGet;
use StreetSignal\Contracts\EntityExists;
use StreetSignal\Contracts\Repository\CreateRepository;
use StreetSignal\Contracts\Repository\UpdateRepository;

interface MessageRepository extends
    EntityGet,
    EntityExists,
    EntityCreate,
    EntityCreateMany,
    CreateRepository,
    UpdateRepository
{

    /**
     * Load pending message by data provider
     *
     * @param  String $status
     * @param  String $data_source
     * @param  integer $limit
     * @return [Message, ...]
     */
    public function getPendingMessages($data_source, $limit);

    /**
     * Load pending message by type
     *
     * @param  String $status
     * @param  String $data_source
     * @param  integer $limit
     * @return [Message, ...]
     */
    public function getPendingMessagesByType($type, $limit);

    /**
     * Check whether a notification message has been sent to a contact
     *
     * @param int $post_id
     * @param int $contact_id
     * @return bool
     */
    public function notificationMessageExists($post_id, $contact_id);

    /**
     * Get number of messages sent by the given contact
     * @return int
     */
    public function getTotalMessagesFromContact($contact_id);

    /**
     * Update message status
     * @param  int    $id
     * @param  string $status
     * @param  string $data_source_message_id
     * @return null
     */
    public function updateMessageStatus($id, $status, $data_source_message_id = null);

    /**
     * Get most recent message UID
     * @param  string $data_source
     * @return string
     */
    public function getLastUID($data_source);
}
