<?php
namespace Tree\UserClass;
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
    public function __construct()
    {
    }

    public function getFullName($id)
    {
        // $user = new User();
        $user = User::where('myid', $id)->first();
        if ($user) {
            return $user->firstName . ' ' . $user->lastName . '<br />' . $id;
        }
        return '';

    }
}