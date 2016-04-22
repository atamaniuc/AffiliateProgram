<?php

namespace AffiliateProgram\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use AffiliateProgram\Contracts\Repositories\UserRepository;
use AffiliateProgram\Models\User;
use AffiliateProgram\Validators\UserValidator;
use DB;

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

    /**
     * TODO: find a way to return User instead of stdClass
     * @param $id
     * @return mixed|static
     */
    public function getReferrerById($id)
    {
       return DB::table('users')
            ->where('id', function ($query) use ($id) {
                $query
                    ->select('referrer_id')
                    ->from('referrals')
                    ->whereRaw('referrals.referral_id =' . $id);
            })
            ->first();
    }

    /**
     * TODO: find a way to return User instead of stdClass
     * @param $id
     * @return array|static[]
     */
    public function gerReferralsById($id)
    {
        return DB::table('users')
            ->leftJoin('referrals', 'users.id', '=', 'referrals.referral_id')
            ->select('users.*')
            ->where('referrals.referrer_id', $id)
            ->get();
    }

}
