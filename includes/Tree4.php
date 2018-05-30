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
        $tree = "";
        $img_stage = 1;
        $computed = Tree::compute($id);
        dd($computed);

        $getTree = function($computed) use ( $img_stage, &$getTree ) {

            $childTree = "";
            // Base case
            if (sizeof($computed) < 1) {
                return $childTree;
            }
            dd($computed);

            foreach ($computed as $key => $value) {
                if(sizeof($value) > 0){
                    $childTree .= '<li>';
                    $childTree .= "<img width='40px' height='40px' src='assets/img/stage".$img_stage.".png'><br />";
                    $childTree .= $value['fullName'];
                    $childTree .= $getTree($value['referred']);
                    $childTree .= '</li>';
                }
                else{
                    $childTree .= '<li>';
                    $childTree .= "<img width='40px' height='40px' src='assets/img/stage".$img_stage.".png'><br />";
                    $childTree .= $value['fullName'];
                    $childTree .= '</li>';
                }
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
        $userTree = []; // the final tree

        $user = new UserClass();
        $ref = new Referred();

        //recursive method to get the referred and their referred
        $_getRef = function ($id) use ( $user, $ref, &$_getRef ) {

            $user = new UserClass();
            $ref = new Referred();

            $result = [];
            $referred = $ref->getReferred($id); // get user referrers
//            dd($referred);

            // Base case
            if (sizeof($referred) < 1) {
                return [
                    [
                        'id'                    => $id,
                        'fullName'              => $user->getFullName($id),
                        'referred'              => [],
                        'level'                 => 1,
                        'noOfDownlinksPerLevel' => [
                            'level1' => 0,
                            'level2' => 0,
                            'level3' => 0,
                            'level4' => 0,
                            'level5' => 0,
                            'level6' => 0,
                        ],
                    ]
                ];
            }

            //loop through the referred users
            foreach ($referred as $key => $value) {
//                dd($value);

                //analyze each referred
                $refererDetail = $_getRef($value);
//                $level = 1;

//                dd($refererDetail);
//                dd(Tree::myDownlinksPerLevel($refererDetail));
                $dLinkLevel = Tree::myDownlinksPerLevel($refererDetail);
                if(sizeof($refererDetail) > 0) {
                    array_push($result, [
                        'id'                    => $value,
                        'fullName'              => $user->getFullName($value),
                        'referred'              => Tree::myReferred($refererDetail),
//                    'referred'              => $refererDetail,
                        'level'                 => Tree::calcUserLevel(Tree::myReferredLevel($refererDetail), $dLinkLevel),
                        'noOfDownlinksPerLevel' => $dLinkLevel,
                    ]);
                }

            }

//            dd($result);
            return $result;
        };

        //initiate the final tree by adding the parent to the list
        $refererDetail = $_getRef($userId);
//        dd($refererDetail);
//        dd(Tree::myDownlinksPerLevel($refererDetail));

        array_push($userTree, [
            'id'                    => $userId,
            'fullName'              => $user->getFullName($userId),
            'referred'              => Tree::myReferred($refererDetail),
            'level'                 => Tree::calcUserLevel(Tree::myReferredLevel($refererDetail), Tree::myDownlinksPerLevel($refererDetail)),
            'noOfDownlinksPerLevel' => Tree::myDownlinksPerLevel($refererDetail),
        ]);

//        dd($userTree);
        return $userTree;
    }

    /**
     * @param $level
     * @param $noOfDownlinksPerLevelDetails
     * @return array
     * @uses to increment the number of siblings per level
     */
    public function noOfDownlinksPerLevel($level, $noOfDownlinksPerLevelDetails)
    {
//        dd($noOfDownlinksPerLevelDetails);

        if(sizeof($noOfDownlinksPerLevelDetails) < 6){
            return [
                'level1' => 0,
                'level2' => 0,
                'level3' => 0,
                'level4' => 0,
                'level5' => 0,
                'level6' => 0,
            ];
        }

        if ($level === 1) $noOfDownlinksPerLevelDetails['level1'] += 1;
        if ($level === 2) $noOfDownlinksPerLevelDetails['level2'] += 1;
        if ($level === 3) $noOfDownlinksPerLevelDetails['level3'] += 1;
        if ($level === 4) $noOfDownlinksPerLevelDetails['level4'] += 1;
        if ($level === 5) $noOfDownlinksPerLevelDetails['level5'] += 1;
        if ($level === 6) $noOfDownlinksPerLevelDetails['level6'] += 1;

        return $noOfDownlinksPerLevelDetails;
    }

    /**
     * @param $refererDetail
     * @return array
     * @uses get the array of number of downlinks per level of a user referred users
     */
    public function myDownlinksPerLevel($refererDetail)
    {
        $_myDownlinksPerLevel = [];
//        dd($refererDetail);

        if(sizeof($refererDetail) > 0){
            foreach ($refererDetail as $key => $referred) {
//                dd($referred);

                array_push($_myDownlinksPerLevel, Tree::noOfDownlinksPerLevel($referred['level'], $referred['noOfDownlinksPerLevel']));
            }

        }

//        dd($_myDownlinksPerLevel);
        return $_myDownlinksPerLevel;
    }

    public function calcUserLevel($referersLevel, $noOfDownlinksPerLevel)
    {
//        dd($noOfDownlinksPerLevel);
        if (Tree::stageFive($referersLevel, $noOfDownlinksPerLevel[0])) return 5;
        if (Tree::stageFour($referersLevel, $noOfDownlinksPerLevel[0])) return 4;
        if (Tree::stageThree($referersLevel, $noOfDownlinksPerLevel[0])) return 3;
        if (Tree::stageTwo($noOfDownlinksPerLevel[0])) return 2;

        return 1;
    }

    public function myReferred($refererDetail)
    {
        $_referred = [];

//        if(sizeof($refererDetail) < 1) return [];
//        dd($refererDetail);
        foreach ($refererDetail as $key => $referred) {
//            dd($referred);
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


    /**
     * get users qualified fro a stage from the generated tree elements
     *
     * @param tree the generated tree elements
     *
     * @return array element qualified for stage
     */
    public function stageOne($noOfDownlinksPerLevel)
    {
        return true;
    }

    public function stageTwo($noOfDownlinksPerLevel)
    {
        if(sizeof($noOfDownlinksPerLevel) > 1){
            if ($noOfDownlinksPerLevel['level1'] >= 6) return true;
        }

        return false;
    }

    public function stageThree($referersLevel, $noOfDownlinksPerLevel)
    {
        //array of id

        if (sizeof($referersLevel) >= 6){
            $totalPass = 0; //number of referred that are in stage 2
            foreach ($referersLevel as $key => $level) {
                if($level >= 2) $totalPass += 1;
            }

            if($totalPass === 6 && $noOfDownlinksPerLevel['level2'] >= 62) return true;
        }

        return false;
    }

    public function stageFour($referersLevel, $noOfDownlinksPerLevel)
    {
        if (sizeof($referersLevel) >= 6){
            $totalPass = 0; //number of referred that are in stage 3
            foreach ($referersLevel as $key => $level) {
                if($level >= 3) $totalPass += 1;
            }

            if($totalPass === 6 && $noOfDownlinksPerLevel['level3'] >= 62) return true;
        }

        return false;
    }

    public function stageFive($referersLevel, $noOfDownlinksPerLevel)
    {
        if (sizeof($referersLevel) >= 6){
            $totalPass = 0; //number of referred that are in stage 4
            foreach ($referersLevel as $key => $level) {
                if($level >= 4) $totalPass += 1;
            }

            if($totalPass === 6 && $noOfDownlinksPerLevel['level4'] >= 62) return true;
        }

        return false;
    }



    private function getimg($user_toget){

        global $dbc;
        $query3 = "SELECT * FROM `user_rank` WHERE `myid` = '$user_toget'";
        $res3 = mysqli_query($dbc, $query3);
        $user_row3 = mysqli_fetch_array($res3);
        $img_stage = $user_row3['stage'];
        $img_link = "<img width='40px' height='40px' src='assets/img/stage".$img_stage.".png'>";
        return $img_link;
    }

    private function getstage_name($stage)
    {

        if($stage == 0){
            $stagename= "Blank";
        }else if($stage == 1){
            $stagename= "Associate Member";
        }else if($stage == 2){
            $stagename= "Master Member";
        }else if($stage == 3){
            $stagename= "Super Master";
        }else if($stage == 4){
            $stagename= "Minister";
        }else if($stage == 5){
            $stagename= "Prime Minister";
        }else{
            $stagename= "Blank";
        }
        return $stagename;

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
//                array_push(
//                    $referred,
//                   [
//                       'referredId'           => $userRank[$value],
//                       'level'              => 1,
//                       'noOfDownlinksPerLevel'   => [
//                                   'level1' => 0,
//                                   'level2' => 0,
//                                   'level3' => 0,
//                                   'level4' => 0,
//                                   'level5' => 0,
//                                   'level6' => 0,
//                               ]
//                   ]
//                );
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
//        dd($id);
        $user = User::where('myid', $id)->first();
        if ($user) {
            return $user->firstName . ' ' . $user->lastName . '<br />' . $id;
        }
        return '';

    }
}