<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**

 * model for quiz: users
 *
 *@param INT id PRIMARY_KEY
 *@param STRING name 
 *@param STRING email 
 *@param DATE email_verified_at 
 *@param STRING password 
 *@param STRING two_factor_secret 
 *@param STRING two_factor_recovery_codes 
 *@param STRING remember_token 
 *@param INT current_team_id 
 *@param STRING profile_photo_path 
 *@param DATE created_at 
 *@param DATE updated_at 
 */
class users extends Model 
{
    public $timestamps = false;
    protected $table = 'users';
}