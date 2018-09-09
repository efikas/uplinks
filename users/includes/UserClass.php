<?php
// namespace Tree\UserClass;
/**
 * Created by PhpStorm.
 * User: latyf
 * Date: 5/27/18
 * Time: 10:32 AM
 */

/**
 * Class handle the overall user refererrer analysis
 *
 * @category UserTree
 * @package  Uplink
 * @author   Latyf <latyf01@gmail.com>
 * @license  no licence
 * @link     http://
 */
class UserClass
{
    /**
     * Create a new contextual binding builder.
     *
     * @return void
     */
    public function __construct(){}

    public function getFullName($id) {
        $user = User::where('myid', $id)->first();
        if ($user) {
            return '<b>' . $user->userName . '</b><br />' . $user->firstName . ' ' . $user->lastName;
        }
        return '';
    }

    public function getUsername($id) {
        $user = User::where('myid', $id)->first();
        if ($user) {
            return $user->userName;
        }
        return '';
    }

    public function getStage($id) {
        $user = User_rank::where('myid', $id)->first();
        if ($user) {
            return $user->stage;
        }
        return '1';

    }

    public function getFullNameByUsername($username) {
        $user = User::where('userName', $username)->first();
        if ($user) {
            return $user->firstName . ' ' . $user->lastName;
        }
        return '0';
    }

    public function getUserId($username) {
        $user = User::where('userName', $username)->first();
        if ($user) {
            return $user->myid;
        }
        return null;

    }

}