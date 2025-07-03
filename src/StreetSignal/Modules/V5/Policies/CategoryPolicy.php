<?php

namespace StreetSignal\Modules\V5\Policies;

use StreetSignal\Core\Tool\Acl;
use StreetSignal\Authzn\GenericUser as User;
use StreetSignal\Core\Entity\Tag as StaticCategory;
use StreetSignal\Modules\V5\Models\Category as EloquentCategory;
use StreetSignal\Core\Tool\Authorizer\TagAuthorizer;

class CategoryPolicy
{
    protected $authorizer;

    public function __construct(Acl $acl, TagAuthorizer $authorizer)
    {
        $this->authorizer = $authorizer;
        $this->authorizer->setAcl($acl);
    }

    public function view(User $user, EloquentCategory $category)
    {
        $accessedCategory = new StaticCategory($category->toArray());

        return $this->authorizer->setUser($user)->isAllowed($accessedCategory, 'search');
    }

    public function create(User $user)
    {
        return $this->authorizer->setUser($user)->isAllowed(new StaticCategory, 'create');
    }

    public function show(User $user, EloquentCategory $category)
    {
        $accessedCategory = new StaticCategory($category->toArray());

        return $this->authorizer->setUser($user)->isAllowed($accessedCategory, 'read');
    }

    public function delete(User $user, EloquentCategory $category)
    {
        $accessedCategory = new StaticCategory($category->toArray());
        return $this->authorizer->setUser($user)->isAllowed($accessedCategory, 'delete');
    }

    public function update(User $user, EloquentCategory $category)
    {
        $accessedCategory = new StaticCategory($category->getRawOriginal());

        $accessedCategory->setState($category->getDirty());

        return $this->authorizer->setUser($user)->isAllowed($accessedCategory, 'update');
    }
}
