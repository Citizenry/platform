<?php

/**
 * Repository for Form Attributes
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html
 *             GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\EntityGet;
use StreetSignal\Contracts\EntityCreate;
use StreetSignal\Contracts\EntityExists;
use StreetSignal\Contracts\EntityCreateMany;

interface FormAttributeRepository extends
    EntityGet,
    EntityExists,
    EntityCreate,
    EntityCreateMany
{
    /**
     * @param  string $key
     * @param  int    $form_id
     * @param  boolean $include_no_form  Include attributes with null form_id
     * @return \StreetSignal\Contracts\Entity
     */
    public function getByKey($key, $form_id = null, $include_no_form = false);

    /**
     * @param  int $form_id
     * @return [StreetSignal\Contracts\Repository\Entity\FormAttribute, ...]
     */
    public function getByForm($form_id);

    /**
     * @param  int $form_id
     * @return [StreetSignal\Contracts\Repository\Entity\FormAttribute, ...]
     */
    public function getFirstNonDefaultByForm($form_id);

    /**
     * @return [StreetSignal\Contracts\Repository\Entity\FormAttribute, ...]
     */
    public function getAll();

    /**
     * @param  int $stage_id
     * @return [StreetSignal\Contracts\Repository\Entity\FormAttribute, ...]
     */
    public function getRequired($stage_id);

    /**
     * @param  string  $key
     * @return boolean
     */
    public function isKeyAvailable($key);

    /**
     * @param  array $include_attributes
     * @return \StreetSignal\Core\Entity\FormAttribute[]
     */
    public function getExportAttributes(array $include_attributes = null);

    /**
     * @param int $form_id
     * @return Entity
     */
    public function getNextByFormAttribute($last_attribute_id);
}
