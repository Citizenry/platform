<?php

/**
 * Unit tests for Signature Verifier
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Tests\Unit\Modules\V3\Validator\Role;

use Mockery as M;
use StreetSignal\Core\Tool\FeatureManager as Feature;
use StreetSignal\Tests\TestCase;
use Kohana\Validation\Validation;
use StreetSignal\Modules\V3\Validator\Role\Update;
use StreetSignal\Contracts\Repository\Entity\PermissionRepository;

/**
 * @backupGlobals disabled
 * @preserveGlobalState disabled
 */
class UpdateTest extends TestCase
{
    protected $permissonRepoMock;

    public function testRoleDisabled()
    {
        $features = M::mock(Feature::class);
        $features->shouldReceive('isEnabled')->with('roles')->andReturn(false);
        $this->app->instance('feature', $features);

        $validationMock = M::mock(Validation::class);
        /** @var PermissionRepository */
        $permissonRepoMock = M::mock(PermissionRepository::class);
        $validator = new Update($permissonRepoMock);
        $validationMock->expects('error')->with(
            'name',
            'rolesNotEnabled'
        );
        $validator->checkRolesEnabled($validationMock);
    }

    public function testRoleEnabled()
    {
        $features = M::mock(Feature::class);
        $features->shouldReceive('isEnabled')->with('roles')->andReturn(true);
        $this->app->instance('feature', $features);

        $validationMock = M::mock(Validation::class);
        /** @var PermissionRepository */
        $permissonRepoMock = M::mock(PermissionRepository::class);
        $validator = new Update($permissonRepoMock);
        $validationMock->shouldNotReceive('error')->with(
            'name',
            'rolesNotEnabled'
        );
        $validator->checkRolesEnabled($validationMock);
    }
}
