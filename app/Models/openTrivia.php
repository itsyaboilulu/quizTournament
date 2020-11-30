<?php

namespace App\Models;


class openTrivia
{

    public $data = null;

    /**
     * retrieves questions form opentrivia.com
     *
     * @param int $no number of questions wanted
     */
    public function __construct($no=10)
    {
        $this->data = (json_decode(file_get_contents("https://opentdb.com/api.php?amount=$no&type=multiple")))->results;
    }


    /**
     * gets questions from open trivia and inserts them directly into
     * the `questions` table
     *
     * @param int $no number of questions
     * @return boolean T/F
     */
    public static function openTriviaToDB($no=10){

        $ot =  new openTrivia($no);
        $qc = questionCategory::keyNamearr();

        foreach($ot->data as $data){

            //check that the question doesnt already exsist
            if( count(questions::where('question', utf8_encode($data->question) )->get()) == 0 ){

                $q            = new questions();
                $q->question  = utf8_encode( $data->question);
                $option       = $data->incorrect_answers;
                $option[]     = $data->correct_answer;
                $q->option    = serialize($option);
                $q->answer    = $data->correct_answer;
                $q->source    = 'openTrivia';
                $q->catagory  = $qc[$data->category];
                $q->save();

            }

        }

        return TRUE;

    }

}
