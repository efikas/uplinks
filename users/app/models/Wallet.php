<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Wallet extends Eloquent
{
    protected $table = 'wallet';
    protected $fillable = ['username', 'email'];

    public $timestamps = [];
}