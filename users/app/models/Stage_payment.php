<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Stage_payment extends Eloquent
{
    protected $table = 'stages_payment';
    protected $fillable = ['user_id'];

    public $timestamps = [];

    // public function user(){
    //     return $this->belongsTo(User::class, 'user_id', 'myid');
    //     // **user_id** is the column that represent foreign key from table users
    //     // **id** is the name of primary key column inside users table (the column that you are referencing with foreign key)
    // }

}
