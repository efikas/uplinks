<?php
require_once 'app/init.php';
require_once 'Tree.php';

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
class ReferrerTree extends Tree
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

            for($i = 0; $i < 6; $i++){

                if($computed[$i]){
                    $childTree .= '<li>';
                    $childTree .= "<img width='40px' height='40px' src='assets/img/stage".$img_stage.".png'><br />";
                    $childTree .= $computed[$i]['fullName'];
                    $childTree .= $getTree($computed[$i]['referred']);
                    $childTree .= '</li>';
                }
                else{
                    $childTree .= '<li>';
                    $childTree .= "<img width='40px' height='40px' src='assets/img/stage0.png'><br />";
                    $childTree .= '</li>';
                }
            }

//            foreach ($computed as $key => $value) {
//
//
//                $childTree .= '<li>';
//                $childTree .= "<img width='40px' height='40px' src='assets/img/stage".$img_stage.".png'><br />";
//                $childTree .= $value['fullName'];
//                $childTree .= $getTree($value['referred']);
//                $childTree .= '</li>';
//            }
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




}
