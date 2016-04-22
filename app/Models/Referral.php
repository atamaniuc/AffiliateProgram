<?php

namespace AffiliateProgram\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * AffiliateProgram\Referral
 *
 * @property integer $id
 * @property integer $referrer_id
 * @property integer $referral_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Referral whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Referral whereReferrerId($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Referral whereReferralId($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Referral whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Referral whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Referral extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'referrals';

    /*public function user1()
    {
        return $this->belongsTo('AffiliateProgram\Users', 'referrer_id', 'id');
    }

    public function user2()
    {
        return $this->belongsTo('AffiliateProgram\Users', 'referral_id', 'id');
    }*/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*public function referrer()
    {
        return $this->belongsTo('AffiliateProgram\Users', 'referral_id', 'id');
    }


    public function referral()
    {
        return $this->belongsTo('AffiliateProgram\Users', 'referrer_id', 'id');
    }*/
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

   /* public function getReferrals()
    {
        return $this->belongsTo('AffiliateProgram\Users');
    }*/

    /**
     * @param $referrerId
     * @param $referralId
     * @return bool
     */
    public static function insertRelation($referrerId, $referralId)
    {
        // TODO: timestamps
        return DB::table('referrals')->insert(
            array(
                'referrer_id'     =>   $referrerId,
                'referral_id'   =>   $referralId
            )
        );
    }

}
