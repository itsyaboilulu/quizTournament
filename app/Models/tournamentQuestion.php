<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**

 * model for quiz: tournament_question
 *
 *@param INT tid PRIMARY_KEY
 *@param DATE date PRIMARY_KEY
 *@param INT qno PRIMARY_KEY
 *@param INT qid 
 */
class tournamentQuestion extends Model 
{
    public $timestamps = false;
    protected $table = 'tournament_question';
}