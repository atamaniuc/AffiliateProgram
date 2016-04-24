<?php

namespace AffiliateProgram\Models;

use Illuminate\Foundation\Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

/**
 * Class User
 *
 * @package AffiliateProgram\Models
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\AffiliateProgram\Models\Payment[] $payments
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\AffiliateProgram\Models\User whereDeletedAt($value)
 * @mixin \Eloquent
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, Transformable
{
    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes, TransformableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals()
    {
        // return $this->hasMany('AffiliateProgram\Referrals', 'referrer_id', 'id');
        // return $this->hasManyThrough('AffiliateProgram\User', 'AffiliateProgram\Referrals', 'referrer_id', 'user_id', 'user_id');
        // return $this->hasManyThrough($this, 'AffiliateProgram\Referrals', 'referrer_id', 'id');
        // return $this->hasManyThrough($this, 'AffiliateProgram\Referrals', 'id', 'referrer_id', 'referral_id');
        // return $this->hasManyThrough('AffiliateProgram\User', 'AffiliateProgram\Referrals', 'id', 'referrer_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function referrer()
    {
        // return $this->hasOne('AffiliateProgram\Referrals', 'referral_id', 'id');
        // return $this->hasManyThrough($this, 'AffiliateProgram\Referrals', 'referral_id',null, 'id');
        // return $this->hasManyThrough($this, 'AffiliateProgram\Referrals', 'referral_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('AffiliateProgram\Models\Payment', 'user_id');
    }


}
