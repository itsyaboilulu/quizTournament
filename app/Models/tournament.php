<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\useful;

/**

 * model for quiz: tournament
 *
 *@param INT id PRIMARY_KEY
 *@param STRING name
 *@param DATE created
 */
class tournament extends Model
{
    public $timestamps = false;
    protected $table = 'tournament';

    /**
     * Undocumented function
     *
     * @param [type] $tid
     * @return object
     */
    public static function settings($tid){

        $t = tournament::find($tid);
        return ($t->settings) ? (object) unserialize($t->settings) : NULL;
    }

    /**
     * returns a list of all tourniments logged in user is apart of
     * @return obj
     */
    public static function tournaments()
    {


        $sql = 'SELECT tp.admin,
                    t.id,
                    t.name,
                    (  SELECT ( (ts.score * 1000) - ts.time )
                            FROM tournament_score ts
                            WHERE ts.date = current_date()
                                AND ts.tid = t.id
                                AND ts.uid = ?
                        ) as score
                FROM tournament_player tp
                    INNER JOIN tournament t
                        ON tp.tid = t.id
                WHERE tp.uid = ?;';

        return DB::select( $sql , [Auth::id(), Auth::id()]);

    }


    /**
     * returns the set of questions for the givens dates tourniment,
     * if none are set, a new set is generated, saved and then returned
     *
     * @param int $tid
     * @param date $date
     * @return obj
     */
    public static function getQuestions($tid, $date = null)
    {
        $date = ($date) ? $date : useful::currentTimeStamp('Y-m-d');

        //check if questions are set
        if ( tournamentQuestion::where('tid', $tid)->where('date', $date)->first() ){

            return DB::select("SELECT q.question, q.answer, q.option, q.catagory
                FROM tournament_question tq
                    INNER JOIN questions q
                        ON tq.qid = q.id
                WHERE tid = $tid
                    AND date = '$date'");

        }

        //check if we have usable questions locally
        $check = DB::select("SELECT q.id, q.question, q.answer, q.option, q.catagory
            FROM questions q
            WHERE id NOT IN (SELECT qid FROM tournament_question WHERE tid = $tid)
            ORDER BY RAND()
            LIMIT 10");

        if ( count($check) == 10) {

            //set as active questions and return
            $count = 1;
            foreach ($check as $c){

                $tq         = new tournamentQuestion();
                $tq->tid    = $tid;
                $tq->date   = $date;
                $tq->qid    = $c->id;
                $tq->qno    = $count;
                $tq->save();
                $count++;

            }

            return $check;

        }

        //we need more questions
        openTrivia::openTriviaToDB(10);
        //recure rather then retype the above
        return self::getQuestions($tid,$date);

    }

}
