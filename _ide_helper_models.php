<?php
/**
 * An helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace AffiliateProgram\Models{
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
	class Referral extends \Eloquent {}
}

