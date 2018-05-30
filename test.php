<?php
require_once 'app/init.php';
require_once 'includes/Tree.php';

$user = new User();
$wallet = new Wallet();
$tree = new Tree();
// $user->name = "Alex";

// echo $user->name;
// $history = Wallet::where('id', '=', 1)->first();
// echo $history;

$t = $tree->DisplayTree('1509227304-526012118');
dd($t);