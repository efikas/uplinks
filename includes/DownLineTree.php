<?php
require_once 'app/init.php';
require_once dirname(__DIR__) . '/includes/UserClass.php';
require_once dirname(__DIR__) . '/includes/Referred.php';

/**
 * Class handle the overall user refererrer analysis
 *
 * @category UserDownLineTree
 * @package  Uplink
 * @author   Latyf <latyf01@gmail.com>
 * @license  no licence
 * @link     http://
 */
class DownLineTree
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
     * @return the DownLineTree markup
     */
    public function myDownlineTree($id)
    {
        $DownLineTree = "";
        $user = new UserClass();
        $myStage = ($user->getStage($id)) ? $user->getStage($id) : 1; // get user stage
        $maxDepth = $this->getStageDepth($myStage);
        $depth = 0; //starting depth

        $getDownLineTree = function($computed, $myStage) 
                                    use ( &$getDownLineTree, &$depth ) {

            $user = new UserClass();
            $childDownLineTree = "";

            // Base case
            if (sizeof($computed) < 1) {
                return $childDownLineTree;
            }

            foreach ($computed as $key => $value) {

                if($value['children'] != null){

                    if($value['id'] != '__' && $myStage <= $value['stage']){
                        $childDownLineTree .= '<li>';
                        $childDownLineTree .= "<img width='40px' height='40px' src='assets/img/stage" . $value['stage'] . ".png'><br />";
                        $childDownLineTree .= $user->getFullname($value['id']);
                        $childDownLineTree .= $getDownLineTree($value['children'], $myStage);
                        $childDownLineTree .= '</li>';
                    }
                    else {
                        $childDownLineTree .= '<li>';
                        $childDownLineTree .= "<img width='40px' height='40px' src='assets/img/stage0.png'><br />";
                        $childDownLineTree .= $getDownLineTree($value['children'], $myStage);
                        $childDownLineTree .= '</li>';
                    }
                }
            }

            if ($childDownLineTree !== "") {
                return "<ul>" . $childDownLineTree . "</ul>";
            }
            return $childDownLineTree;
        };
        
        $DownLineTree = '<ul>';
        $DownLineTree .= '<li>';
        $DownLineTree .= "<img width='40px' height='40px' src='assets/img/stage".$myStage.".png'><br />";
        $DownLineTree .= $user->getFullname($id);
        $DownLineTree .= "<ul>" . $getDownLineTree(DownLineTree::computeTree($id, $depth, $maxDepth), $myStage) . '</ul>';
        $DownLineTree .= '</li></ul>';
        
        return $DownLineTree;
    }

    public function computeTree($userId, $depth, $maxDepth = 0) {
        $children = DownLineTree::getChildren($userId); // get user 2 immediate downlink

        return DownLineTree::DownLinkArray($children, $depth, $maxDepth);
    }

    /**
     * Create a new contextual binding builder.
     *
     * @param children  the two children of the user
     * @param depth  the present depth of the DownLineTree
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
        $rightDownLinks =  DownLineTree::DownLinkArray(DownLineTree::getChildren($children[0]), $presentDepth, $maxDepth);
        $leftDownLinks =  DownLineTree::DownLinkArray(DownLineTree::getChildren($children[1]), $presentDepth, $maxDepth);

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
            if(isset($downLinkArray[$i])){
                array_push($userDownLink,  $downLinkArray[$i]);
            }
            else{
                array_push($userDownLink, '__');
            }
        }

        return $userDownLink;
    }

    private function getStageDepth($stage){
        // get the user's level to know the dept of the graph tree to draw
        // if the user is in stage 1 or 5 the max depth is 2
        // and if the users is in stage 2, 3, or 4, the max depth is 5
        Switch($stage){
            case '1':
            case '5':
                return 2;
                break;
            case '2':
            case '3':
            case '4':
                return 5;
                break;
            default:
                return 2;
                break;
        }
    }

}


