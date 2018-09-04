<?php
require_once 'app/init.php';
require_once 'includes/StagesUpdater.php';

$allUsersId = User::orderByDesc('userId')->pluck('myid');
$updater = new StagesUpdater();

foreach($allUsersId as $userId){
    $updater->update($userId);
}

?>

