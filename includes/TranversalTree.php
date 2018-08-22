<?php
require_once 'app/init.php';
require_once dirname(__DIR__) . '/includes/UserClass.php';
require_once dirname(__DIR__) . '/includes/Referred.php';


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
    public function directMembersTree($id)
    {
        $tranversalTree = "";
        $user = new UserClass();

        $getTranversalTree = function($computed, $myStage) use ( &$getTranversalTree ) {
            $user = new UserClass();
            $childTranversalTree = "";

            // Base case
            if (sizeof($computed) < 1) {
                return $childTranversalTree;
            }

            foreach ($computed as $key => $value) {

                if($value['children'] != null){

                    if($value['id'] != '__' && !($myStage < $value['stage'])){
                        $childTranversalTree .= '<li>';
                        $childTranversalTree .= "<img width='40px' height='40px' src='assets/img/stage".$myStage.".png'><br />";
                        $childTranversalTree .= $user->getFullname($value['id']);
                        $childTranversalTree .= $getTranversalTree($value['children'], $myStage, 1);
                        $childTranversalTree .= '</li>';
                    }
                    else {
                        $childTranversalTree .= '<li>';
                        $childTranversalTree .= "<img width='40px' height='40px' src='assets/img/stage0.png'><br />";
                        $childTranversalTree .= $getTranversalTree($value['children'], $myStage);
                        $childTranversalTree .= '</li>';
                    }
                }
            }

            return $childTranversalTree;
        };
        

        $myStage = ($stage) ? $stage : $userStage = UserClass::getStage($id) || 1; // get user stage
        $tranversalTree = '<ul>';
        $tranversalTree .= '<li>';
        $tranversalTree .= "<img width='40px' height='40px' src='assets/img/stage".$myStage.".png'><br />";
        $tranversalTree .= $user->getFullname($id);
        $tranversalTree .= "<ul>" . $getTranversalTree(TranversalTree::computeTree($id, $myStage, 1), $myStage) . '</ul>';
        $tranversalTree .= '</li></ul>';
        
        return $tranversalTree;
    }

    /**
     * @param id the user id of the user
     *
     * @return the TranversalTree markup
     */
    public function directMembers($id)
    {
        $tranversalTree = "";
        $user = new UserClass();

        $getTranversalTree = function($computed, $myStage) use ( &$getTranversalTree ) {
            $user = new UserClass();
            $childTranversalTree = [];

            // Base case
            if (sizeof($computed) < 1) {
                return $childTranversalTree;
            }

            foreach ($computed as $key => $value) {

                if ($value['children'] != null && $value['id'] != '__' ) {

                    if ( !($myStage < $value['stage']) ) {
                        array_push($childTranversalTree, $value['id']);
                        foreach ($getTranversalTree($value['children'], $myStage, 1) as $val){
                            array_push($childTranversalTree, $val);
                        }
                    }
                    else {
                        $childTranversalTree .= '<li>';
                        $childTranversalTree .= "<img width='40px' height='40px' src='assets/img/stage0.png'><br />";
                        $childTranversalTree .= $getTranversalTree($value['children'], $myStage);
                        $childTranversalTree .= '</li>';
                    }
                }
            }

            return $childTranversalTree;
        };
        

        $myStage = ($stage) ? $stage : $userStage = UserClass::getStage($id) || 1; // get user stage
        $tranversalTree = '<ul>';
        $tranversalTree .= '<li>';
        $tranversalTree .= "<img width='40px' height='40px' src='assets/img/stage".$myStage.".png'><br />";
        $tranversalTree .= $user->getFullname($id);
        $tranversalTree .= "<ul>" . $getTranversalTree(TranversalTree::computeTree($id, $myStage, 1), $myStage) . '</ul>';
        $tranversalTree .= '</li></ul>';
        
        return $tranversalTree;
    }


    public function DisplayTranversalTree($id, $stage = null)
    {
        $tranversalTree = "";
        $user = new UserClass();

        $getTranversalTree = function($computed, $myStage) use ( &$getTranversalTree ) {
            $user = new UserClass();
            $childTranversalTree = "";

            // Base case
            if (sizeof($computed) < 1) {
                return $childTranversalTree;
            }

            foreach ($computed as $key => $value) {

                if($value['children'] != null){

                    if($value['id'] != '__' && !($myStage < $value['stage'])){
                        $childTranversalTree .= '<li>';
                        $childTranversalTree .= "<img width='40px' height='40px' src='assets/img/stage".$myStage.".png'><br />";
                        $childTranversalTree .= $user->getFullname($value['id']);
                        $childTranversalTree .= $getTranversalTree($value['children'], $myStage);
                        $childTranversalTree .= '</li>';
                    }
                    else {
                        $childTranversalTree .= '<li>';
                        $childTranversalTree .= "<img width='40px' height='40px' src='assets/img/stage0.png'><br />";
                        $childTranversalTree .= $getTranversalTree($value['children'], $myStage);
                        $childTranversalTree .= '</li>';
                    }
                    
                }
            //    else{
            //        $childTranversalTree .= '<li>';
            //        $childTranversalTree .= "<img width='40px' height='40px' src='assets/img/stage0.png'><br />";
            //        $childTranversalTree .= '</li>';
            //    }
            }

            if ($childTranversalTree !== "") {
                return "<ul>" . $childTranversalTree . "</ul>";
            }
            return $childTranversalTree;
        };
        

        $myStage = ($stage) ? $stage : $userStage = UserClass::getStage($id) || 1; // get user stage
        $tranversalTree = '<ul>';
        $tranversalTree .= '<li>';
        $tranversalTree .= "<img width='40px' height='40px' src='assets/img/stage".$myStage.".png'><br />";
        $tranversalTree .= $user->getFullname($id);
        $tranversalTree .= $getTranversalTree(TranversalTree::computeTree($id, $myStage), $myStage);
        $tranversalTree .= '</li></ul>';
        
        return $tranversalTree;
    }

    public function computeTree($userId, $myStage, $maxDepth = 0) {
        $ref = new Referred();
        $depth = 0;
        //$maxDepth = 0; // initializing depth
        
        
        // get the user's level to know the dept of the graph tree to draw
        // if the user is in stage 1 or 5 the max depth is 2
        // and if the users is in stage 2, 3, or 4, the max depth is 5
        // $userStage = UserClass::getStage($userId);
        $userStage = $myStage;

        Switch($userStage){
            case '1':
            case '5':
                $maxDepth = 2;
                break;
            case '2':
            case '3':
            case '4':
                $maxDepth = 5;
                break;
            default:
                $maxDepth = 2;
                break;
        }

        //Uses the right to get the children of the user
        $downLinkArray = TranversalTree::getChildren($userId); // get user 2 immediate downlink

        return TranversalTree::DownLinkArray($downLinkArray, $depth, $maxDepth);
    }

    /**
     * Create a new contextual binding builder.
     *
     * @param children  the two children of the user
     * @param depth  the present depth of the TranversalTree
     *
     * @return Array return the array of the object containing name and id of the referred
     */
    public function DownLinkArray($children, $presentDepth, $maxDepth) {
        if($presentDepth == $maxDepth) {
            return [[
                'id' => $children[0],
                'stage' => ($children[0] != '__') ? UserClass::getStage($children[0]) : 0, // assign to empty users a stage of 0
                'children' => null
            ],[
                'id' => $children[1],
                'stage' => ($children[1] != '__') ? UserClass::getStage($children[1]) : 0, // assign to empty users a stage of 0
                'children' => null
            ]];
        }

        $presentDepth += 1;

        // get the right and left downlinks
        $rightDownLinks =  TranversalTree::DownLinkArray(TranversalTree::getChildren($children[0]), $presentDepth, $maxDepth);
        $leftDownLinks =  TranversalTree::DownLinkArray(TranversalTree::getChildren($children[1]), $presentDepth, $maxDepth);

        return [[
                    'id' => $children[0],
                    'stage' => ($children[0] != '__') ? UserClass::getStage($children[0]) : 0,
                    'children' => $rightDownLinks
                ],[
                    'id' => $children[1],
                    'stage' => ($children[1] != '__') ? UserClass::getStage($children[1]) : 0,
                    'children' => $leftDownLinks
                ]];
    }
        
    /**
     * Create a new contextual binding builder.
     *
     * @return Array return the array of the object containing name and id of the referred
     */
    public function getChildren($userId){
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

}
