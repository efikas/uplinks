<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    protected $table = 'user_table';
    protected $fillable = ['username', 'email'];

    public $timestamps = [];
}