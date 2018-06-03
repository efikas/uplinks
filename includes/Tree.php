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
     * @param id the user id of the user
     *
     * @return the tree markup
     */
    public function DisplayTree($id)
    {
        $computed = Tree::DownLinkArray($id);
        $tree = "";
        $myStage = 1;

        $getTree = function($computed) use ( $myStage, &$getTree ) {

            $childTree = "";
            // Base case
            if (sizeof($computed) < 1) {
                return $childTree;
            }

            foreach ($computed as $key => $value) {

                if(sizeof($value) > 0){
                    $childTree .= '<li style="padding: 25px 30px 0px 30px">';
                    $childTree .= "<img width='40px' height='40px' src='assets/img/stage".$myStage.".png'><br />";
                    $childTree .= $value['fullName'];
                    $childTree .= $getTree($value['downLineMember']);
                    $childTree .= '</li>';
                }
                else{
                    $childTree .= '<li style="padding: 25px 30px 0px 30px">';
                    $childTree .= "<img width='40px' height='40px' src='assets/img/stage0.png'><br />";
                    $childTree .= '</li>';
                }
            }

            if ($childTree !== "") {
                return "<ul>" . $childTree . "</ul>";
            }
            return $childTree;
        };

        if (sizeof($computed) > 0) {
            //get the stage of the main user
            $myStage = isset($computed[0]['stage']) ?: $computed[0]['stage'] ?: 1;

            $tree = '<ul>';
            $tree .= '<li style="padding: 25px 30px 0px 30px">';
            $tree .= "<img width='40px' height='40px' src='assets/img/stage".$myStage.".png'><br />";
            $tree .= $computed[0]['fullName'];
            $tree .= $getTree($computed[0]['downLineMember']);
            $tree .= '</li></ul>';
        }
        return $tree;
    }

    /**
    * @param id the user id of the user
    *
    * @return basic immediate Downlink information of a user
    */
    public function DownLinkArray($userId)
    {
        $userTree = []; // the final tree
        $stepCounter = 0;

        $user = new UserClass();
        $ref = new Referred();

        // recursive method to get the referred and their referred
        $_getRef = function ($id) use ( $user, $ref, &$_getRef, &$stepCounter ) {
            $result = [];
            $downLinkArray = $ref->getDirectDownLink($id); // get user 2 immediate downlink

            // Base case
            if (sizeof($downLinkArray) < 1) {
                return [];
            }

            //loop through the referred users
            foreach ($downLinkArray as $key => $value) {

                array_push($result, [
                    'id'                    => $value,
                    'fullName'              => $user->getFullName($value),
                    'username'              => $user->getUsername($value),
                    'downLineMember'        => Tree::getUserDownLink($value),
                ]);

            }
            return $result;
        };

        // initiate the final tree by adding the parent to the list
        $downLineMemberDetail = $_getRef($userId);

        array_push($userTree, [
            'id'                    => $userId,
            'fullName'              => $user->getFullName($userId),
            'username'              => $user->getUsername($userId),
            'downLineMember'        => $downLineMemberDetail,
        ]);

        return $userTree;
    }


    /**
     * Create a new contextual binding builder.
     *
     * @return Array return the array of the object containing name and id of the referred
     */
    public function getUserDownLink($userId)
    {
        $userDownLink = [];
        $user = new UserClass();
        $ref = new Referred();
        $downLinkArray = $ref->getDirectDownLink($userId); // get user 2 immediate downlink

        //loop through the referred users
        for($i = 0; $i < 2; $i++){
            if(isset($downLinkArray[$i])){
                array_push($userDownLink, [
                    'id'                    => $downLinkArray[$i],
                    'fullName'              => $user->getFullName($downLinkArray[$i]),
                    'username'              => $user->getUsername($downLinkArray[$i]),
                ]);
            }
            else{
                array_push($userDownLink, []);
            }
        }

       return $userDownLink;
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
class Referred {
    /**
     * Create a new contextual binding builder.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * Create a new contextual binding builder.
     *
     * @return Array return the array of the object containing name and id of the referred
     */
    public function getDirectDownLink($id)
    {
        $directDownLink = [];
        $userRank = User_rank::where('superior_id', $id)->get(['myid']);
        $counter = 0;

         foreach ($userRank as $value){
             if($counter > 2) return $directDownLink;

             array_push($directDownLink, $value->myid);
             $counter++;
         }
        return $directDownLink;
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
class UserClass {
    /**
     * Create a new contextual binding builder.
     *
     * @return void
     */
    public function __construct(){}

    public function getFullName($id)
    {
        $user = User::where('myid', $id)->first();
        if ($user) {
            return '<b>' . $user->userName . '</b><br />' . $user->firstName . ' ' . $user->lastName;
        }
        return '';
    }

    public function getUsername($id)
    {
        $user = User::where('myid', $id)->first();
        if ($user) {
            return $user->userName;
        }
        return '';
    }

    public function getStage($id)
    {
        $user = User_rank::where('myid', $id)->first();
        if ($user) {
            return $user->stage;
        }
        return '1';

    }
}