<?php
/**
 * Created by PhpStorm.
 * User: latyf
 * Date: 6/11/18
 * Time: 10:36 PM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Stages_payment extends Eloquent
{
    protected $table = 'stages_payment';

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'myid');
        // **user_id** is the column that represent foreign key from table users
        // **id** is the name of primary key column inside users table (the column that you are referencing with foreign key)
    }

}
