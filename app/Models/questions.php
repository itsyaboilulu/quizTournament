<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**

 * model for quiz: questions
 *
 *@param INT id PRIMARY_KEY
 *@param STRING question 
 *@param STRING answer 
 *@param STRING option 
 *@param STRING source 
 *@param DATE created 
 *@param DATE last_updated 
 */
class questions extends Model 
{
    public $timestamps = false;
    protected $table = 'questions';
}