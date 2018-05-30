<?php
namespace  Tree\Referred;
/**
 * Created by PhpStorm.
 * User: latyf
 * Date: 5/27/18
 * Time: 10:30 AM
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
class Referred
{
    /**
     * Create a new contextual binding builder.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Create a new contextual binding builder.
     *
     * @return Array return the array of the object containing name and id of the referred
     */
    public function getReferred($id)
    {
        $referred = [];
        $refElements = ['desc_1', 'desc_2', 'desc_3', 'desc_4', 'desc_5', 'desc_6'];
        $user = new UserClass();
        $userRank = User_rank::where('myid', $id)->first();

        foreach ($refElements as $key => $value) {
            if ($userRank[$value]) {
                // echo $userRank[$value] . "  -   ";
                array_push($referred, $userRank[$value]);
            }
        }

        return $referred;
    }
}
