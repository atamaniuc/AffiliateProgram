<?php

namespace AffiliateProgram\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use AffiliateProgram\Contracts\Repositories\ReferralRepository;
use AffiliateProgram\Models\User;
use AffiliateProgram\Validators\UserValidator;
use DB;

/**
 * Class ReferralRepositoryEloquent
 * @package namespace AffiliateProgram\Repositories;
 */
class ReferralRepositoryEloquent extends BaseRepository implements ReferralRepository
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
     * Insert relation in `referrals` table
     * 
     * @param $referrerId
     * @param $referralId
     * @return bool
     */
    public static function insert($referrerId, $referralId)
    {
        // TODO: timestamps
        return DB::table('referrals')->insert(
            array(
                'referrer_id' => $referrerId,
                'referral_id' => $referralId
            )
        );
    }
    

}
