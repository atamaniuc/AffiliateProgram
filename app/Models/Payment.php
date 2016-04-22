<?php

namespace AffiliateProgram\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * AffiliateProgram\Payment
 *
 * @property integer $id
 * @property integer $referrer_id
 * @property integer $referral_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Models\Payment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Models\Payment whereReferrerId($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Models\Payment whereReferralId($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Models\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Models\Payment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Payment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'total_amount', 'amount', 'added_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*public function user()
    {
        return $this->belongsTo('AffiliateProgram\Models\User', 'id', 'user_id');
    }*/
    
    
}
