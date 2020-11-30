<?php

namespace App\Http\Controllers;

use App\Models\questions;
use App\Models\tournament;
use App\Models\tournamentPlayer;
use App\Models\tournamentScore;
use App\Models\useful;
use Carbon\Traits\Timestamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class tournamentController extends Controller
{

    public function changeSetting(Request $request)
    {
        //double check admin
        if (!tournamentPlayer::isAdmin(Auth::id(), $request->get('tid'))){

            return redirect('settings?tid=' . $request->get('tid'));

        }

        $settings  = tournament::find($request->get('tid'));

        $arr = ($settings->settings) ? unserialize($settings->settings) : array() ;

        switch ($request->get('type')){
            case 'scoreboard':
                $arr['scoreboard'] = $request->get('setting');
            break;
        }

        $settings->settings = serialize($arr);
        $settings->save();

        return redirect('settings?tid='.$request->get('tid'));
    }


    public function settingsPage(Request $request)
    {

        if (! $request->get('tid') && !tournamentPlayer::isAdmin(Auth::id(),$request->get('tid'))){
            return redirect('/');
        }

        return view('settings', array(
            'tournament'    => tournament::find($request->get('tid')),
            'settings'      => tournament::settings($request->get('tid')),
            'players'       => DB::select(' SELECT u.name,u.id
                                            FROM tournament_player p
                                                INNER JOIN users u
                                                    ON u.id = p.uid
                                            WHERE p.tid = ?
                                                AND p.uid != ?',
                                [$request->get('tid'), Auth::id()]),
        ));
    }

    /**
     * Create a new tournament and add logged in member as admin
     *
     * @param  Request $request
     * @return redirect Play
     */
    public function createtournament(Request $request)
    {
        $t           = new tournament();
        $t->name     = $request->get('name');
        $t->password = $request->get('password');
        $t->settings = serialize(array('scoreboard'=>1));
        $t->save();

        $tm          = new tournamentPlayer();
        $tm->tid     = $t->id;
        $tm->uid     = Auth::id();
        $tm->admin   = 1;
        $tm->save();

        return redirect( 'lobby?tid='.$t->id );
    }


    /**
     * display tourniment page using given $tid
     *
     * @param  Request $request
     * @return view play
     */
    public function lobbyPage(Request $request)
    {
        if ( $request->get('tid') && count(tournamentPlayer::where('tid', $request->get('tid'))->where('uid', Auth::id())->get()) > 0 ) {

            return view('lobby', array(
                'tournament' => tournament::find( $request->get('tid') ),
                'score'      => tournamentScore::getScoreBoard($request->get('tid'), useful::currentTimeStamp('Y-m-d')),
                'today'      => tournamentScore::where('date', useful::currentTimeStamp('Y-m-d'))->where('tid', $request->get('tid'))->where('uid', Auth::id())->first(),
                'total'      => tournamentScore::getScoreBoard($request->get('tid')),
            ));

        }
       return redirect('/');
    }


    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function playPage(Request $request)
    {
        if ($request->get('tid') && count(tournamentPlayer::where('tid', $request->get('tid'))->where('uid', Auth::id())->get()) > 0) {

            //stop people retacking daily quiz
            if ( count(tournamentScore::where('tid', $request->get('tid'))->where('uid', Auth::id())->where('date',useful::currentTimeStamp('Y-m-d'))->get()) > 0 ){
                return redirect( 'lobby?tid='.$request->get('tid') );
            }

            //return quiz
            $this->startClock($request->get('tid'));
            return view('play', array(
                'questions' => tournament::getQuestions($request->get('tid')),
                'tid'       => $request->get('tid'),
            ));

        }

        return redirect('/');
    }


    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function result(Request $request)
    {
        $time = $this->getClock($request->get('tid'));

        if ( tournamentScore::where('date', date('Y-m-d', session('timer')[$request->get('tid')]))->where('uid',Auth::id())->where('tid', $request->get('tid'))->first() ) {
            return redirect('/');
        }

        $sql = 'SELECT q.*
            FROM tournament_question tq
                INNER JOIN questions q
                    ON q.id = tq.qid
            WHERE tid = ?
                AND date = ?
            ORDER BY qno;';

        $questions = DB::select($sql, [ $request->get('tid'), date('Y-m-d', session('timer')[$request->get('tid')]) ]);

        $score = 0;
        for($i=0;$i<count($questions);$i++){ if ( $questions[$i]->answer == $request->get('a'.$i) ) { $score++; } }

        $ps         = new tournamentScore();
        $ps->tid    = $request->get('tid');
        $ps->uid    = Auth::id();
        $ps->date   = date('Y-m-d', session('timer')[$request->get('tid')]);
        $ps->score  = $score;
        $ps->time   = $time;
        $ps->save();

        return view('result', array(
            'time'      => $time,
            'score'     => $score,
            'result'    => $request->all(),
            'questions' => $questions
        ));
    }


    /**
     * start clock for given tournament id, if already started doesnt reset
     *
     * @param int $tid tauntament id
     * @return int start time
     */
    private function startClock($tid)
    {
        if (!session()->has('timer')){ session(['timer' => array()]); }

        $data = session('timer');

        if (!isset($data[$tid])){ $data[$tid] = time(); }

        session(['timer' => $data]);

        return $data[$tid];
    }


    /**
     * returns the time taken since starting the clock
     *
     * @param int $tid tauntament id
     * @return int time in seconds
     */
    private function getClock($tid)
    {
        return time() - session('timer')[$tid];
    }

}
