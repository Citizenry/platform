<?php

/**
 * StreetSignal Set Validator
 *
 * @author    StreetSignal Team <team@streetsignal.com>
 * @package   StreetSignal\Application
 * @copyright 2014 Ushahidi
 * @license   https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\HXL\Metadata;

use StreetSignal\Modules\V3\Validator\LegacyValidator;
use StreetSignal\Contracts\Repository\Entity\UserRepository;
use StreetSignal\Contracts\Repository\Entity\HXLLicenseRepository;
use StreetSignal\Contracts\Repository\Entity\HXLMetadataRepository;

class Create extends LegacyValidator
{
    protected $default_error_source = 'hxl_metadata';

    protected $repo;
    protected $user_repo;
    protected $license_repo;

    public function __construct(
        HXLMetadataRepository $repo,
        UserRepository $user_repo,
        HXLLicenseRepository $license_repo
    ) {
        $this->repo = $repo;
        $this->user_repo = $user_repo;
        $this->license_repo = $license_repo;
    }
    /**
     * @return array|\StreetSignal\Core\Tool\ArrayValidation
     */
    protected function getRules()
    {
        return array_merge([
            'private' => [
                [[$this, 'notEmptyBool'], [':value', ':validation']],
            ],
            'dataset_title' => [
                ['not_empty'],
                ['min_length', [':value', 2]],
                ['max_length', [':value', 255]],
                ['regex', [':value', self::REGEX_STANDARD_TEXT]], // alpha, number, punctuation, space
            ],
            'organisation_id' => [
                ['not_empty'],
                ['min_length', [':value', 1]],
                ['max_length', [':value', 255]],
                ['regex', [':value', self::REGEX_STANDARD_TEXT]], // alpha, number, punctuation, space
            ],
            'organisation_name' => [
                ['not_empty'],
                ['min_length', [':value', 1]],
                ['max_length', [':value', 255]],
                ['regex', [':value', self::REGEX_STANDARD_TEXT]], // alpha, number, punctuation, space
            ],
            'source' => [
                ['not_empty'],
                ['min_length', [':value', 2]],
                ['max_length', [':value', 255]],
                ['regex', [':value', self::REGEX_STANDARD_TEXT]], // alpha, number, punctuation, space
            ]
        ], $this->getForeignKeyRules());
    }

    public function notEmptyBool($value, $validation)
    {
        if ($value === null) {
            $validation->error('private', 'privateShouldNotBeEmpty');
        }
        return true;
    }
    /**
     * Get rules for references to other tables
     * @return array
     */
    private function getForeignKeyRules()
    {
        return [
            'license_id' => [
                [[$this->license_repo, 'exists'], [':value']],
            ],
            'user_id' => [
                [[$this->user_repo, 'exists'], [':value']],
            ]
        ];
    }
}
