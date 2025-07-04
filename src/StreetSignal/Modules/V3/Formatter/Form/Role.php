<?php

/**
 * StreetSignal API Formatter for Form Role
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter\Form;

use StreetSignal\Modules\V3\Formatter\API;
use StreetSignal\Core\Concerns\FormatterAuthorizerMetadata;

class Role extends API
{
    use FormatterAuthorizerMetadata;

    public function __invoke($entity)
    {
        $data = [
            'id'  => $entity->id,
            'url' => url('forms/' . $entity->form_id . '/roles/' . $entity->id),
            'form_id' => $entity->form_id,
            'role_id' => $entity->role_id,
            ];

        $data = $this->addMetadata($data, $entity);

        return $data;
    }
}
