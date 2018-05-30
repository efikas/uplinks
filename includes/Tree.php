<?php
require_once 'app/init.php';

//namespace  includes\Tree;
//
//require_once 'app/init.php';
//use Tree\Referred as  Referred;
//use Tree\UserClass as UserClass;

/**
 * Class handle the overall user refererrer analysis
 *
 * @category UserTree
 * @package  Uplink
 * @author   Latyf <latyf01@gmail.com>
 * @license  no licence
 * @link     http://
 */
class Tree
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
     * @param id the user id of the user
     * @param  string  $concrete
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function DisplayTree($id)
    {
        $computed = Tree::compute($id);
        $tree = "";
        $img_stage = 1;

        $getTree = function($computed) use ( $img_stage, &$getTree ) {

            $childTree = "";
            // Base case
            if (sizeof($computed) < 1) {
                return $childTree;
            }

            foreach ($computed as $key => $value) {
//                dd($value);
                $childTree .= '<li>';
                $childTree .= "<img width='40px' height='40px' src='assets/img/stage".$img_stage.".png'><br />";
                $childTree .= $value['fullName'];
                $childTree .= $getTree($value['referred']);
                $childTree .= '</li>';
            }
            if ($childTree !== "") {
                return "<ul>" . $childTree . "</ul>";
            }
            return $childTree;
        };

        if (sizeof($computed) > 0) {
            $tree = '<ul>';
            $tree .= '<li>';
            $tree .= "<img width='40px' height='40px' src='assets/img/stage".$img_stage.".png'><br />";
            $tree .= $computed[0]['fullName'];
            $tree .= $getTree($computed[0]['referred']);
            $tree .= '</li></ul>';
        }
        return $tree;
    }

    public function compute($userId)
    {
        $stage = 1;
        $userTree = []; // the final tree

        $user = new UserClass();
        $ref = new Referred();

        //recursive method to get the referred and their referred
        $_getRef = function ($id) use ( $user, $ref, &$_getRef ) {

            $result = [];
            $referred = $ref->getReferred($id); // get user referrers

            // Base case
            if (sizeof($referred) < 1) {
                return [];
            }

            //loop through the referred users
            foreach ($referred as $key => $value) {

                //analyze each referred
                $refererDetail = $_getRef($value);


                array_push($result, [
                    'id'                    => $value,
                    'fullName'              => $user->getFullName($value),
                    'referred'              => $refererDetail,
                ]);
            }

            return $result;
        };

        //initiate the final tree by adding the parent to the list
        $refererDetail = $_getRef($userId);
        array_push($userTree, [
            'id'                    => $userId,
            'fullName'              => $user->getFullName($userId),
            'referred'              => $refererDetail,
        ]);

        return $userTree;
    }


    public function myReferred($refererDetail)
    {
        $_referred = [];
        foreach ($refererDetail as $key => $referred) {
            array_push($_referred, $referred['referred']);
        }

        return $_referred;
    }

    public function myReferredLevel($refererDetail)
    {
        $_levels = [];
        foreach ($refererDetail as $key => $referred) {
            array_push($_levels, $referred['level']);
        }

        return $_levels;
    }


}



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