<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**

 * model for quiz: tournament_player
 *
 *@param INT tid PRIMARY_KEY
 *@param INT uid PRIMARY_KEY
 *@param UNASSIGNED admin
 */
class tournamentPlayer extends Model
{
    public $timestamps = false;
    protected $table = 'tournament_player';

    /**
     * returns true/false if given member is admin of given
     * tournament
     *
     * @param int $id user id
     * @param int $tid tournament id
     * @return boolean
     */
    public static function isAdmin($id,$tid){

        return (tournamentPlayer::where('uid',$id)->where('tid',$tid)->first())->admin;

    }

}
