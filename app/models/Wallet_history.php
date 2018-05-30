<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Wallet_history extends Eloquent
{
    protected $table = 'wallet_history';
    protected $fillable = ['username', 'email'];

    public $timestamps = [];
}