<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    protected $table = 'user_table';
    protected $fillable = ['username', 'email'];

    const CREATED_AT = 'added';

    public $timestamps = [C];

    public function userRank(){
        return $this->hasOne(User_rank::class, 'myid', 'myid');
        // second parameter is **user_id** because that's the column name that represent foreign key inside user_rank table
        // third parameter is **id** because that's the column name for local key inside users table.
        // Second and third parameter can be omitted here because they will default to those values
    }

    public function stagesPayment(){
        return $this->hasOne(Stage_payment::class, 'user_id', 'myid');
        // second parameter is **user_id** because that's the column name that represent foreign key inside user_rank table
        // third parameter is **id** because that's the column name for local key inside users table.
        // Second and third parameter can be omitted here because they will default to those values
    }

//    public function ref1(){ return $this->belongsTo(User::class, 'desc_1', 'myid');}
//    public function ref2(){ return $this->belongsTo(User::class,  'desc_2', 'myid');}
//    public function ref3(){ return $this->belongsTo(User::class,  'desc_3', 'myid');}
//    public function ref4(){ return $this->belongsTo(User::class,  'desc_4', 'myid');}
//    public function ref5(){ return $this->belongsTo(User::class, 'desc_5', 'myid');}
//    public function ref6(){ return $this->belongsTo(User::class, 'desc_6', 'myid');}
}