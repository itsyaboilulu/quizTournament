<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**

 * model for quiz: tournament_points
 *
 *@param INT tid PRIMARY_KEY
 *@param INT uid PRIMARY_KEY
 *@param INT points 
 *@param DATE last_updated 
 */
class tournamentPoints extends Model 
{
    public $timestamps = false;
    protected $table = 'tournament_points';
}