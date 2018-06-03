<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    protected $table = 'user_table';
    protected $fillable = ['username', 'email'];

    public $timestamps = [];

//    public function ref1(){ return $this->belongsTo(User::class, 'desc_1', 'myid');}
//    public function ref2(){ return $this->belongsTo(User::class,  'desc_2', 'myid');}
//    public function ref3(){ return $this->belongsTo(User::class,  'desc_3', 'myid');}
//    public function ref4(){ return $this->belongsTo(User::class,  'desc_4', 'myid');}
//    public function ref5(){ return $this->belongsTo(User::class, 'desc_5', 'myid');}
//    public function ref6(){ return $this->belongsTo(User::class, 'desc_6', 'myid');}
}