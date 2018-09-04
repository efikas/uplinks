<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Stage extends Eloquent
{
    protected $table = 'stages_payment';
    protected $fillable = ['name'];

    public $timestamps = [];

    // public function user(){
    //     return $this->belongsTo(User::class, 'user_id', 'myid');
    //     // **user_id** is the column that represent foreign key from table users
    //     // **id** is the name of primary key column inside users table (the column that you are referencing with foreign key)
    // }

}
