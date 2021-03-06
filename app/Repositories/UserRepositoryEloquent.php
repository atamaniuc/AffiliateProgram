<?php

namespace AffiliateProgram\Repositories;

use Illuminate\Database\Eloquent\Collection;
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

    /**
     * @param $id
     * 
     * @return User
     */
    public function getReferrerByReferralId($id)
    {
        $this->applyCriteria();
        $model = $this->model
            ->where('id', function ($query) use ($id) {
                $query
                    ->select('referrer_id')
                    ->from('referrals')
                    ->where('referrals.referral_id', $id);
            })
            ->first();

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * @param $id
     * 
     * @return Collection
     */
    public function gerReferralsByReferrerId($id)
    {
        $this->applyCriteria();
        $model = $this->model
            ->leftJoin('referrals', 'users.id', '=', 'referrals.referral_id')
            ->select('users.*')
            ->where('referrals.referrer_id', $id)
            ->get();

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * @return Collection
     */
    public function gerUsersWithLatestPayments()
    {
        $this->applyCriteria();
        $model = $this->model
            ->crossJoin('payments', 'users.id', '=', 'payments.user_id')
            ->select('users.*', 'payments.id as pi', \DB::raw('MAX(`payments`.total_amount) as total_amount'))
            ->groupBy('users.id')
            ->orderBy('users.id')
            ->get();
        
        $this->resetModel();
        
        return $this->parserResult($model);
    }

}
