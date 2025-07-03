<?php

/**
 * StreetSignal Platform Options Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\Usecase;
use StreetSignal\Core\Usecase\Concerns\Formatter as FormatterTrait;
use StreetSignal\Core\Usecase\Concerns\Authorizer as AuthorizerTrait;
use StreetSignal\Core\Usecase\Concerns\Translator as TranslatorTrait;
use StreetSignal\Core\Usecase\Concerns\IdentifyRecords;
use StreetSignal\Contracts\Repository\ReadRepository;

class OptionsUsecase implements Usecase
{
    // Uses several traits to assign tools. Each of these traits provides a
    // setter method for the tool. For example, the AuthorizerTrait provides
    // a `setAuthorizer` method which only accepts `Authorizer` instances.
    use AuthorizerTrait,
        FormatterTrait,
        TranslatorTrait;

    // - IdentifyRecords for setting entity lookup parameters
    use IdentifyRecords;

    /**
     * @var SearchRepository
     */
    protected $repo;

    /**
     * Inject a repository that can read entities.
     *
     * @param  ReadRepository $repo
     * @return $this
     */
    public function setRepository(ReadRepository $repo)
    {
        $this->repo = $repo;
        return $this;
    }

    // Usecase
    public function isWrite()
    {
        return false;
    }

    // Usecase
    public function isSearch()
    {
        return false;
    }

    // Usecase
    public function interact()
    {
        // Fetch an empty entity...
        $entity = $this->getEntity();

        // ... grab the privileges that are allowed for the current user
        $data = [
            'allowed_privileges' => $this->getAllowedPrivs($entity)
        ];

        // ... and return the formatted results.
        return $data;
    }

    /**
     * Get an empty entity.
     *
     * @return Entity
     */
    protected function getEntity()
    {
        return $this->repo->getEntity();
    }
}
