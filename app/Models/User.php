<?php

namespace AffiliateProgram\Models;

use Illuminate\Foundation\Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

/**
 * Class User
 * @package AffiliateProgram\Models
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes;

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
        'name', 'email', 'password', 'amount',
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
     * @hasMany
     * @param $id
     * @return array|static[]
     */
    public function referrals($id)
    {
       // return $this->hasMany('AffiliateProgram\Referrals', 'referrer_id', 'id');

        return DB::table('users')
            ->leftJoin('referrals', 'users.id', '=', 'referrals.referral_id')
            ->select('users.*')
            ->where('referrals.referrer_id',$id)
            ->get();

       // return $this->hasManyThrough('AffiliateProgram\User', 'AffiliateProgram\Referrals', 'referrer_id', 'user_id', 'user_id');


       // return $this->hasManyThrough($this, 'AffiliateProgram\Referrals', 'referrer_id', 'id');
       // return $this->hasManyThrough($this, 'AffiliateProgram\Referrals', 'id', 'referrer_id', 'referral_id');

      //  return $this->hasManyThrough('AffiliateProgram\User', 'AffiliateProgram\Referrals', 'id', 'referrer_id', 'id');
    }

    /**
     * @hasOne
     * @param $id
     * @return mixed|static
     */
   public function referrer($id)
    {
        return DB::table('users')
            ->where('id', function ($query) use ($id) {
                $query
                    ->select('referrer_id')
                    ->from('referrals')
                    ->whereRaw('referrals.referral_id =' . $id);
            })
            ->first();
        

       // return $this->hasOne('AffiliateProgram\Referrals', 'referral_id', 'id');

        //return $this->hasManyThrough($this, 'AffiliateProgram\Referrals', 'referral_id',null, 'id');
       // return $this->hasManyThrough($this, 'AffiliateProgram\Referrals', 'referral_id', 'id');
    }


}
