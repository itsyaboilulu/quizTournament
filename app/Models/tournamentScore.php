<?php

namespace App\Models;

use DateTime;
use DatePeriod;
use DateInterval;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/**

 * model for quiz: tournament_score
 *
 *@param INT tid PRIMARY_KEY
 *@param INT uid PRIMARY_KEY
 *@param DATE date PRIMARY_KEY
 *@param INT score
 *@param INT time
 */
class tournamentScore extends Model
{
    public $timestamps = false;
    protected $table = 'tournament_score';


    /**
     * returns the score board for the given torniment id, if date is given will return the
     * score board for that specific date else returns total
     *
     * @param int $tid tourniment id
     * @param datetime $date date in Y-m-d
     * @return obj
     */
    public static function getScoreBoard($tid, $date = NULL)
    {
        $settings = tournament::settings($tid);

        if (isset($settings->scoreboard) && $settings->scoreboard) {

            $sql = "SELECT  u.id,
                            u.name,
                            ( ( SUM(s.score) * 100 ) - SUM(s.time) ) as points
                        FROM quizdailytourniment.tournament_score s
                            INNER JOIN quizdailytourniment.users u
                                ON u.id = s.uid
                        WHERE s.tid = $tid
                        GROUP BY u.name
                        ORDER BY points DESC, s.time ASC, s.score DESC;";

            return DB::select($sql);

        } else {
            if ($date) {

                return DB::select(" SELECT u.id,
                                        u.name,
                                        s.time,
                                        s.score,
                                        ( (s.score * 100) - s.time ) as points
                                    FROM quizdailytourniment.tournament_score s
                                        INNER JOIN quizdailytourniment.users u
                                            ON u.id = s.uid
                                    WHERE s.tid = $tid
                                        AND s.date = '$date'
                                    ORDER BY points DESC, s.time ASC, s.score DESC;");

            } else {

                $ret = array();

                self::updateScoreBoard($tid);

                return DB::select(" SELECT u.name, p.points
                                    FROM tournament_points p
                                        INNER JOIN users u
                                            ON u.id = p.uid
                                    WHERE tid = $tid
                                    ORDER BY p.points DESC");
                tournamentPoints::where('tid',$tid)->orderBy('points','DESC')->get();

            }
        }
    }


    /**
     * updates the tournament_points with members total points
     *
     * @param int $tid tournament id
     */
    public static function updateScoreBoard($tid)
    {

        $maxdate = tournamentPoints::select(DB::raw('MAX(last_updated) as date'))->where('tid', $tid)->first();

        if ( !isset($maxdate) || date('Y-m-d',  strtotime($maxdate->date)) == date('Y-m-d',strtotime("-1 days"))  ) {
            return TRUE; // everything is up to date
        }

        $daterange = new DatePeriod(
            new DateTime(date('Y-m-d',  strtotime($maxdate->date))),
            new DateInterval('P1D'),
            new DateTime(useful::currentTimeStamp('Y-m-d'))
        );

        $count = 0;

        foreach ($daterange as $date) {

            if ($count != 0) {

                $sb = self::getScoreBoard($tid, $date->format("Y-m-d"));;

                for($i=0;$i<count($sb);$i++){
                    switch($i){
                        case 0:     $points = 5;    break;
                        case 1:     $points = 4;    break;
                        case 2:     $points = 3;    break;
                        default:    $points = 1;    break;
                    }
                    if ($i > 2 && $i < 9){ $points = 2; }

                    $u = tournamentPoints::where('tid',$tid)->where('uid',$sb[$i]->id)->first();
                    if ($u){
                        DB::update("UPDATE `tournament_points`
                                    SET `points` = ". ($u->points + $points). ",
                                        `last_updated` = '".date('Y-m-d',strtotime("-1 days"))."'
                                    WHERE `tid` = ? AND `uid` = ? ", [$tid,$sb[$i]->id]);
                    } else {
                        $u               = new tournamentPoints();
                        $u->tid          = $tid;
                        $u->uid          = Auth::id();
                        $u->points       = $points;
                        $u->last_updated = date('Y-m-d', strtotime("-1 days"));
                        $u->save();
                    }
                }

            }

            $count++;

        }

    }

}
