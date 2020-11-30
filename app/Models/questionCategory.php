<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**

 * model for quiz: question_category
 *
 *@param INT id PRIMARY_KEY
 *@param STRING name
 *@param STRING desc
 *@param STRING symbol
 *@param STRING catagory
 *@param STRING sub
 */
class questionCategory extends Model
{
    public $timestamps = false;
    protected $table = 'question_category';

    /**
     * returns an array of catagory id to name, more efficent then multiple
     * sql querries
     *
     * @return array ( $name => $id )
     */
    public static function keyNamearr(){

        foreach( questionCategory::get() as $c ){ $ret[$c->name] = $c->id; }

        return $ret;

    }

}
