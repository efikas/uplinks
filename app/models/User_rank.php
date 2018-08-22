<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class User_rank extends Eloquent
{
    protected $table = 'user_rank';
    protected $fillable = ['username', 'email'];

    public $timestamps = [];

    public function user(){
        return $this->belongsTo(User::class, 'myid', 'myid');
        // **user_id** is the column that represent foreign key from table users
        // **id** is the name of primary key column inside users table (the column that you are referencing with foreign key)
    }

    /**
     * Get the phone record associated with the user.
     */
//    public function ref1(){ return $this->hasOne(User::class, 'myid', 'desc_1');}
//    public function ref2(){ return $this->hasOne(User::class, 'myid', 'desc_2');}
//    public function ref3(){ return $this->hasOne(User::class, 'myid', 'desc_3');}
//    public function ref4(){ return $this->hasOne(User::class, 'myid', 'desc_4');}
//    public function ref5(){ return $this->hasOne(User::class, 'myid', 'desc_5');}
//    public function ref6(){ return $this->hasOne(User::class, 'myid', 'desc_6');}
//
//    public function superior(){ return $this->hasOne(User::class, 'myid', 'superior_id');}



}