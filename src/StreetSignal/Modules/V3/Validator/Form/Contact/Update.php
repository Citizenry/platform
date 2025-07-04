<?php

/**
 * StreetSignal Form Contact Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Form\Contact;

use StreetSignal\Modules\V3\Validator\LegacyValidator;
use StreetSignal\Contracts\Repository\Entity\FormRepository;
use StreetSignal\Contracts\Repository\Entity\ContactRepository;
use StreetSignal\Contracts\Repository\Entity\FormContactRepository;

class Update extends LegacyValidator
{
    protected $default_error_source = 'form_contact';
    protected $form_repo;
    protected $contact_repo;
    protected $form_contact_repo;

    public function setFormContactRepo(FormContactRepository $form_contact_repo)
    {
        $this->form_contact_repo = $form_contact_repo;
    }

    public function setFormRepo(FormRepository $form_repo)
    {
        $this->form_repo = $form_repo;
    }

    public function setContactRepo(ContactRepository $contact_repo)
    {
        $this->contact_repo = $contact_repo;
    }

    protected function getRules()
    {
        return [
            'form_id' => [
                ['digit'],
                [[$this->form_repo, 'exists'], [':value']],
            ],
            'country_code' => [
                ['not_empty'],
            ],
        ];
    }
}
