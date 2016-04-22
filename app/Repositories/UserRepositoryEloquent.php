<?php

namespace AffiliateProgram\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use AffiliateProgram\Contracts\Repositories\UserRepository;
use AffiliateProgram\Models\User;
use AffiliateProgram\Validators\UserValidator;

/**
 * Class UserRepositoryEloquent
 * @package namespace AffiliateProgram\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
