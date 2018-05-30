<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class User_rank extends Eloquent
{
    protected $table = 'user_rank';
    protected $fillable = ['username', 'email'];

    public $timestamps = [];
}