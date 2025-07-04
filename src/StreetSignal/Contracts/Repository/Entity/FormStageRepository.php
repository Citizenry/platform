<?php

/**
 * Repository for Form Stages
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\EntityCreate;
use StreetSignal\Contracts\EntityGet;
use StreetSignal\Contracts\EntityExists;

interface FormStageRepository extends
    EntityGet,
    EntityExists,
    EntityCreate
{

    /**
     * @param  int $form_id
     * @return [StreetSignal\Contracts\Repository\Entity\FormStage, ...]
     */
    public function getByForm($form_id);

    /**
     * @param  int $id
     * @param  int $form_id
     * @return [StreetSignal\Contracts\Repository\Entity\FormStage, ...]
     */
    public function existsInForm($id, $form_id);

    /**
     * Get required stages for form
     *
     * @param  int $form_id
     * @return [StreetSignal\Contracts\Repository\Entity\FormAttribute, ...]
     */
    public function getRequired($form_id);

    /**
     * Get 'post' type stage for form
     *
     * @param  int $form_id
     * @return \StreetSignal\Contracts\Entity
     */
    public function getPostStage($form_id);
}
