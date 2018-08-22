<?php
require_once 'app/init.php';
require_once dirname(__DIR__) . '/includes/UserClass.php';
require_once dirname(__DIR__) . '/includes/Referred.php';

/**
 * Class handle the overall user refererrer analysis
 *
 * @category UserSearchTree
 * @package  Uplink
 * @author   Latyf <latyf01@gmail.com>
 * @license  no licence
 * @link     http://
 */
class SearchTree
{
    /**
     * Create a new contextual binding builder.
     *
     * @return void
     */
    public function __construct()
    {
    }


    public function searchDownLine($id, $searchUser) {

        // get user 2 immediate downlink
        $childrenArray = SearchTree::searchDownLinkArray($id);

        return (in_array($searchUser[0], $childrenArray)) ? true : false;
    }

    public function searchDownLinkArray($id) {
        $allChildren = []; // Array containing all children of the id
        $controlArray = [$id]; // Array containing the frontier

        $forLoop = function ($id) use ( &$allChildren, &$controlArray, &$forLoop ){
            foreach($controlArray as $control){
                $children = SearchTree::getChildren($id);
                foreach($children as $child){
                    if(!in_array($child, $allChildren)){
                        array_push($allChildren, $child);
                        array_push($controlArray, $child);
                    }
                }
                // remove the first element of control array
                array_shift($controlArray);

                while(sizeof($controlArray) > 0) $forLoop($controlArray[0]);
            }

            return $allChildren;
        };

        return $forLoop($id);
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

        $maxLength = (sizeof($downLinkArray) > 2) ? 2 : sizeof($downLinkArray);
        for($i = 0; $i < $maxLength; $i++){
            array_push($userDownLink,  $downLinkArray[$i]);
        }

        return $userDownLink;
    }
}
