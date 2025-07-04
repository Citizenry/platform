<?php

/**
 * StreetSignal Platform Search Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Config;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\Usecase;
use StreetSignal\Core\Usecase\Concerns\Formatter as FormatterTrait;
use StreetSignal\Core\Usecase\Concerns\Authorizer as AuthorizerTrait;
use StreetSignal\Core\Usecase\Concerns\Translator as TranslatorTrait;
use StreetSignal\Core\Concerns\FilterRecords;
use StreetSignal\Contracts\Repository\Entity\ConfigRepository;

class SearchConfig implements Usecase
{
    // Uses several traits to assign tools. Each of these traits provides a
    // setter method for the tool. For example, the AuthorizerTrait provides
    // a `setAuthorizer` method which only accepts `Authorizer` instances.
    use AuthorizerTrait,
        FormatterTrait,
        TranslatorTrait;

    // - FilterRecords for setting search parameters
    use FilterRecords;

    /**
     * @var ConfigRepository
     */
    protected $repo;

    /**
     * Inject a repository that can search for config.
     *
     * @param  ConfigRepository $repo
     * @return $this
     */
    public function setRepository(ConfigRepository $repo)
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
        // Even though this is a "search" usecase, it does not use complex parameters
        // or paging, so there is no need to inject SearchData.
        return false;
    }

    // Usecase
    public function interact()
    {
        // Fetch an empty entity...
        $entity = $this->getEntity();

        // ... verify that the entity can be searched by the current user
        $this->verifySearchAuth($entity);

        // ... get the results of the search
        $results = $this->repo->all($this->getFilter('groups'));

        // ... remove any entities that cannot be seen
        $priv = 'read';
        foreach ($results as $idx => $entity) {
            if (!$this->auth->isAllowed($entity, $priv)) {
                unset($results[$idx]);
            }
        }

        // ... and return the formatted results.
        return $this->formatter->__invoke($results);
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
