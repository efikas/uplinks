<?php
require_once 'app/init.php';

/**
 * Class handle the overall user refererrer analysis
 *
 * @category UserTranversalTree
 * @package  Uplink
 * @author   Latyf <latyf01@gmail.com>
 * @license  no licence
 * @link     http://
 */
class TranversalTree
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
     * @return the TranversalTree markup
     */
    public function DisplayTranversalTree($id)
    {
        $tranversalTree = "";
        $myStage = 1;
        $user = new UserClass();

        $getTranversalTree = function($computed) use ( $myStage, &$getTranversalTree ) {
            $user = new UserClass();
            $childTranversalTree = "";

            // Base case
            if (sizeof($computed) < 1) {
                return $childTranversalTree;
            }

            foreach ($computed as $key => $value) {

                if($value['children'] != false){
                    
                    if($value['id'] != '__'){
                        $childTranversalTree .= '<li>';
                        $childTranversalTree .= "<img width='40px' height='40px' src='assets/img/stage".$myStage.".png'><br />";
                        $childTranversalTree .= $user->getFullname($value['id']);
                        $childTranversalTree .= $getTranversalTree($value['children']);
                        $childTranversalTree .= '</li>';
                    }
                    else {
                        $childTranversalTree .= '<li>';
                        $childTranversalTree .= "<img width='40px' height='40px' src='assets/img/stage0.png'><br />";
                        $childTranversalTree .= $getTranversalTree($value['children']);
                        $childTranversalTree .= '</li>';
                    }
                    
                }
                else{
                    $childTranversalTree .= '<li>';
                    $childTranversalTree .= "<img width='40px' height='40px' src='assets/img/stage0.png'><br />";
                    $childTranversalTree .= '</li>';
                }
            }

            if ($childTranversalTree !== "") {
                return "<ul>" . $childTranversalTree . "</ul>";
            }
            return $childTranversalTree;
        };
        

        $tranversalTree = '<ul>';
        $tranversalTree .= '<li>';
        $tranversalTree .= "<img width='40px' height='40px' src='assets/img/stage".$myStage.".png'><br />";
        $tranversalTree .= $user->getFullname($id);
        $tranversalTree .= $getTranversalTree(TranversalTree::compute($id));
        $tranversalTree .= '</li></ul>';
        
        return $tranversalTree;
    }

    public function compute($userId) {
        $ref = new Referred();
        $depth = 0;
        $downLinkArray = $ref->getDirectDownLink($userId); // get user 2 immediate downlink

        return TranversalTree::DownLinkArray($downLinkArray, $depth);
    }

    /**
     * Create a new contextual binding builder.
     *
     * @param children  the two children of the user
     * @param depth  the present depth of the TranversalTree
     *
     * @return Array return the array of the object containing name and id of the referred
     */
    public function DownLinkArray($children, $depth) {
      if($depth == 5) return false;

      $depth += 1;

      // get downlinks
        $rightDownLinks =  TranversalTree::DownLinkArray(TranversalTree::rightSide($children[0]), $depth);
        $leftDownLinks =  TranversalTree::DownLinkArray(TranversalTree::rightSide($children[1]), $depth);

        return [[
                'id' => $children[0],
                'children' => $rightDownLinks
                ],[
                    'id' => $children[1],
                    'children' => $leftDownLinks
                ]];
    }



    /**
     * Create a new contextual binding builder.
     *
     * @return Array return the array of the object containing name and id of the referred
     */
    public function rightSide($userId){
        $userDownLink = [];
        $ref = new Referred();
        $downLinkArray = $ref->getDirectDownLink($userId); // get user 2 immediate downlink

        // loop through the referred users
        for($i = 0; $i < 2; $i++){
            if(isset($downLinkArray[$i]) && $downLinkArray[$i] != '__'){
                array_push($userDownLink,  $downLinkArray[$i]);
            }
            else{
                array_push($userDownLink, '__');
            }
        }

        return $userDownLink;
    }

    /**
     * Create a new contextual binding builder.
     *
     * @return Array return the array of the object containing name and id of the referred
     */
    public function LeftSide($userId) {
        $userDownLink = [];
        $ref = new Referred();
        $downLinkArray = $ref->getDirectDownLink($userId); // get user 2 immediate downlink

        //loop through the referred users
        for($i = 0; $i < 2; $i++) {
            if(isset($downLinkArray[$i]) && $downLinkArray[$i] != '__') {
                array_push($userDownLink,  $downLinkArray[$i]);
            }
            else{
                array_push($userDownLink, '__');
            }
        }
        return $userDownLink;
    }
}



/**
 * Class handle the overall user refererrer analysis
 *
 * @category UserTranversalTree
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
    public function getDirectDownLink($id) {
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
 * @category UserTranversalTree
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
}