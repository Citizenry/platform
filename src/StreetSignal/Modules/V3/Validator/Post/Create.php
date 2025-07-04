<?php

/**
 * StreetSignal Post Create Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Post;


use StreetSignal\Core\Facade\Feature;
use StreetSignal\Contracts\Permission;
use StreetSignal\Core\Concerns\AdminAccess;
use StreetSignal\Core\Concerns\UserContext;
use StreetSignal\Modules\V3\Validator\LegacyValidator;
use StreetSignal\Core\Concerns\Acl as AccessControlList;
use StreetSignal\Contracts\Repository\Entity\FormRepository;
use StreetSignal\Contracts\Repository\Entity\RoleRepository;
use StreetSignal\Contracts\Repository\Entity\UserRepository;
use StreetSignal\Contracts\Repository\Entity\PostLockRepository;
use StreetSignal\Contracts\Repository\Entity\FormStageRepository;
use StreetSignal\Contracts\Repository\Usecase\UpdatePostRepository;
use StreetSignal\Contracts\Repository\Entity\FormAttributeRepository;
use StreetSignal\Contracts\Repository\Usecase\UpdatePostTagRepository;
use StreetSignal\Modules\V3\Repository\Post\ValueFactory as PostValueFactory;

class Create extends LegacyValidator
{
    use UserContext;

    // Provides `acl`
    use AccessControlList;

    // Checks if user is Admin
    use AdminAccess;

    protected $repo;
    protected $attribute_repo;
    protected $stage_repo;
    protected $tag_repo;
    protected $post_lock_repo;
    protected $user_repo;
    protected $post_value_factory;
    protected $post_value_validator_factory;

    protected $default_error_source = 'post';

    public function __construct(
        UpdatePostRepository $repo,
        FormAttributeRepository $attribute_repo,
        FormStageRepository $stage_repo,
        UpdatePostTagRepository $tag_repo,
        UserRepository $user_repo,
        FormRepository $form_repo,
        RoleRepository $role_repo,
        PostLockRepository $post_lock_repo,
        PostValueFactory $post_value_factory,
        ValueFactory $post_value_validator_factory
    ) {

        $this->repo = $repo;
        $this->attribute_repo = $attribute_repo;
        $this->stage_repo = $stage_repo;
        $this->tag_repo = $tag_repo;
        $this->user_repo = $user_repo;
        $this->form_repo = $form_repo;
        $this->role_repo = $role_repo;
        $this->post_lock_repo = $post_lock_repo;
        $this->post_value_factory = $post_value_factory;
        $this->post_value_validator_factory = $post_value_validator_factory;
    }

    protected function getRules()
    {
        // Hack to avoid Kohana Validation trying to convert post_date into a string
        $fullData = $this->validation_engine->getFullData();
        if ($fullData['post_date']) {
            $fullData['post_date'] = $fullData['post_date']->format('Y-m-d H:i:s');
            $this->validation_engine->setFullData($fullData);
        }
        // End hack

        $parent_id = $this->validation_engine->getFullData('parent_id');
        $type = $this->validation_engine->getFullData('type');

        return [
            'title' => [
                ['max_length', [':value', 255]],
            ],
            'slug' => [
                ['min_length', [':value', 2]],
                ['max_length', [':value', 150]],
                ['alpha_dash', [':value', true]],
                [[$this->repo, 'isSlugAvailable'], [':value']],
            ],
            'locale' => [
                ['max_length', [':value', 5]],
                ['alpha_dash', [':value', true]],
                // @todo check locale is valid
                // @todo if the translation exists and we're performing an Update,
                //       passing locale should not throw an error
                [[$this->repo, 'doesTranslationExist'], [
                    ':value', $parent_id, $type
                ]],
            ],
            'form_id' => [
                ['numeric'],
                [[$this->form_repo, 'exists'], [':value']],
            ],
            'values' => [
                [[$this, 'checkValues'], [':value', ':fulldata']],
                [[$this, 'checkRequiredPostAttributes'], [':value', ':fulldata']],
                [[$this, 'checkRequiredTaskAttributes'], [':value', ':fulldata']],
            ],
            'post_date' => [
                [[$this, 'validDate'], [':value']],
            ],
            'tags' => [
                [[$this, 'checkTags'], [':value']],
            ],
            'user_id' => [
                [[$this->user_repo, 'exists'], [':value']],
                [[$this, 'onlyAuthorOrUserSet'], [':value', ':fulldata']],
            ],
            'author_email' => [
                ['email'],
            ],
            'author_realname' => [
                ['max_length', [':value', 150]],
            ],
            'status' => [
                ['in_array', [':value', [
                    'published',
                    'draft',
                    'archived'
                ]]],
                [[$this, 'checkApprovalRequired'], [':value', ':fulldata']],
                [[$this, 'checkPublishedLimit'], [':value']]
            ],
            'type' => [
                ['in_array', [':value', [
                    'report',
                    'revision',
                    'translation'
                ]]],
            ],
            'published_to' => [
                [[$this->role_repo, 'exists'], [':value']],
            ],
            'completed_stages' => [
                [[$this, 'checkStageInForm'], [':value', ':fulldata']],
                [[$this, 'checkRequiredStages'], [':fulldata']]
            ]
        ];
    }

    public function checkPublishedLimit($status)
    {
        $limit = Feature::getLimit('posts');
        if ($limit !== INF && $status == 'published') {
            $total_published = $this->repo->getPublishedTotal();

            if ($total_published >= $limit) {
                $this->validation_engine->error('status', 'publishedPostsLimitReached');
                return false;
            }
        }
        return true;
    }

    public function checkApprovalRequired($status, $fullData)
    {
        // Status hasn't changed, moving on
        if (!$status) {
            return true;
        }

        if ($status === 'draft' && !isset($fullData['id'])) {
            return true;
        }

        $user = $this->getUser();
        // Do we have permission to publish this post?
        $userCanChangeStatus =
            ($this->isUserAdmin($user) or $this->acl->hasPermission($user, Permission::MANAGE_POSTS));
        // .. if yes, any status is ok.
        if ($userCanChangeStatus) {
            return true;
        }

        $requireApproval = $this->repo->doesPostRequireApproval($fullData['form_id']);

        // Are we trying to change publish a post that requires approval?
        if ($requireApproval && $status !== 'draft') {
            $this->validation_engine->error('status', 'postNeedsApprovalBeforePublishing');
            return false;
        // Are we trying to unpublish or archive an auto-approved post?
        } elseif (!$requireApproval && $status !== 'published') {
            $this->validation_engine->error('status', 'postCanOnlyBeUnpublishedByAdmin');
            return false;
        }

        return true;
    }

    public function checkTags($tags)
    {
        if (!$tags) {
            return true;
        }

        foreach ($tags as $key => $tag) {
            if (is_array($tag)) {
                $tag = $tag['id'];
            }

            if (! $this->tag_repo->doesTagExist($tag)) {
                $this->validation_engine->error('tags', 'tagDoesNotExist', [$tag]);
                return false;
            }
        }
        return true;
    }

    public function checkValues($attributes, $fullData)
    {

        $attributes = !empty($fullData['values']) ? $fullData['values'] : [];
        if (!$attributes) {
            return true;
        }

        $post_id = ! empty($fullData['id']) ? $fullData['id'] : 0;

        foreach ($attributes as $key => $values) {
            // Check attribute exists
            $attribute = $this->attribute_repo->getByKey($key, $fullData['form_id'], true);
            if (! $attribute->id) {
                $this->validation_engine->error('values', 'attributeDoesNotExist', [$key]);
                return false;
            }

            // Are there multiple values? Are they greater than cardinality limit?
            if (count($values) > $attribute->cardinality and $attribute->cardinality != 0) {
                $this->validation_engine->error('values', 'tooManyValues', [
                    $attribute->label,
                    $attribute->cardinality
                ]);
                return false;
            }

            // Run checks on individual values type specific validation
            if ($validator = $this->post_value_validator_factory->getValidator($attribute->type)) {
                // Pass attribute config to the validator
                $validator->setConfig($attribute->config);

                if (!is_array($values)) {
                    $this->validation_engine->error('values', 'notAnArray', [$attribute->label]);
                    return false;
                } elseif ($error = $validator->check($values)) {
                    $this->validation_engine->error('values', $error, [$attribute->label, $values]);
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Check completed stages actually exist in form
     *
     * @param  Validation $validation
     * @param  Array      $attributes
     * @param  Array      $fullData
     */
    public function checkStageInForm($completed_stages, $fullData)
    {
        if (!$completed_stages) {
            return true;
        }

        foreach ($completed_stages as $stage_id) {
            // Check stage exists in form
            if (! $this->stage_repo->existsInForm($stage_id, $fullData['form_id'])) {
                $this->validation_engine->error('completed_stages', 'stageDoesNotExist', [$stage_id]);
                return false;
            }
        }
        return true;
    }

    /**
     * Check required stages are completed before publishing
     *
     * @param  Validation $validation
     * @param  Array      $attributes
     * @param  Array      $fullData
     */
    public function checkRequiredStages($fullData)
    {
        $completed_stages = !empty($fullData['completed_stages']) ? $fullData['completed_stages'] : [];

        // If post is being published
        if ($fullData['status'] === 'published') {
            // Load the required stages
            $required_stages = $this->stage_repo->getRequired($fullData['form_id']);
            foreach ($required_stages as $stage) {
                // Check the required stages have been completed
                if (! in_array($stage->id, $completed_stages)) {
                    // If its not completed, add a validation error
                    $this->validation_engine->error('completed_stages', 'stageRequired', [$stage->label]);
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Check required attributes are completed before completing stages
     *
     * @param  Validation $validation
     * @param  Array      $attributes
     * @param  Array      $fullData
     */
    public function checkRequiredPostAttributes($attributes, $fullData)
    {
        // Get the post stage
        $stage = $this->stage_repo->getPostStage($fullData['form_id']);

        // Load the required attributes
        $required_attributes = $this->attribute_repo->getRequired($stage->id);

        foreach ($required_attributes as $attr) {
            // Post has two special required attributes Title and Desription
            // these are checked separately and skipped here.
            // TODO: Refactor Title and Description to be handled as Post Values
            if (!in_array($attr->type, ['title', 'description']) && !array_key_exists($attr->key, $attributes)) {
                // If a required attribute isn't completed, throw an error
                $this->validation_engine->error('values', 'postAttributeRequired', [$attr->label, $stage->label]);
                return false;
            }
        }
        return true;
    }

    /**
     * Check required attributes are completed before completing stages
     *
     * @param  Validation $validation
     * @param  Array      $attributes
     * @param  Array      $fullData
     */
    public function checkRequiredTaskAttributes($attributes, $fullData)
    {
        if (empty($fullData['completed_stages'])) {
            return true;
        }

        // If a stage is being marked completed
        // Check if the required attribute have been completed
        foreach ($fullData['completed_stages'] as $stage_id) {
            // Load the required attributes
            $required_attributes = $this->attribute_repo->getRequired($stage_id);

            // Check each attribute has been completed
            foreach ($required_attributes as $attr) {
                if (!array_key_exists($attr->key, $attributes)) {
                    $stage = $this->stage_repo->get($stage_id);
                    // If a required attribute isn't completed, throw an error
                    $this->validation_engine->error('values', 'taskAttributeRequired', [$attr->label, $stage->label]);
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Check that only author or user info is set
     * @param  int $user_id
     * @param  array $fullData
     * @return Boolean
     */
    public function onlyAuthorOrUserSet($user_id, $fullData)
    {
        return (empty($user_id) or (empty($fullData['author_email']) and empty($fullData['author_realname'])) );
    }

    public function validDate($str)
    {
        if ($str instanceof \DateTimeInterface) {
            return true;
        }
        return (strtotime($str) !== false);
    }
}
