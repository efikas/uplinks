<?php
require_once 'app/init.php';
require_once dirname(__DIR__) . '/includes/UserClass.php';
require_once dirname(__DIR__) . '/includes/Referred.php';
require_once dirname(__DIR__) . '/includes/Payer.php';
/**
 * Created by PhpStorm.
 * User: latyf
 * Date: 6/11/18
 * Time: 9:20 PM
 */

class StagesUpdater
{
    const STAGES = [
        'complete_stage1_step1',
        'complete_stage1_step2',

        'complete_stage2_step1',
        'complete_stage2_step2',
        'complete_stage2_step3',
        'complete_stage2_step4',
        'complete_stage2_step5',

        'complete_stage3_step1',
        'complete_stage3_step2',
        'complete_stage3_step3',
        'complete_stage3_step4',
        'complete_stage3_step5',

        'complete_stage4_step1',
        'complete_stage4_step2',
        'complete_stage4_step3',
        'complete_stage4_step4',
        'complete_stage4_step5',

        'complete_stage5_step1',
        'complete_stage5_step2',
        'complete_stage5_step3',
    ];

    const STAGESBONUS = [
        'complete_stage1_step1' => 0,
        'complete_stage1_step2' => 0,

        'complete_stage2_step1' => 10,
        'complete_stage2_step2' => 100,
        'complete_stage2_step3' => 200,
        'complete_stage2_step4' => 300,
        'complete_stage2_step5' => 400,

        'complete_stage3_step1' => 200,
        'complete_stage3_step2' => 300,
        'complete_stage3_step3' => 500,
        'complete_stage3_step4' => 500,
        'complete_stage3_step5' => 1500,

        'complete_stage4_step1' => 300,
        'complete_stage4_step2' => 300,
        'complete_stage4_step3' => 500,
        'complete_stage4_step4' => 900,
        'complete_stage4_step5' => 4000,

        'complete_stage5_step1' => 2000,
        'complete_stage5_step2' => 10000,
        'complete_stage5_step3' => 0,
    ];

    public function update($id) {

        //check if record exist
        $this->createStagePaymentRecord($id);
        $children = $this->getChildren($id);

        if (sizeof($children < 2)) {

            // stage equal complete_stage1_step1
            Stage_payment::where('user_id', $id)
                        ->update(['complete_stage1_step1' => 1]);
        }
        else {
            // get the index of the stages of the children
            $indexOfFirstChild = array_search($this->getStageStep($children[0]), self::STAGES);
            $indexOfSecondChild = array_search($this->getStageStep($children[1]), self::STAGES);

            $lowerStage = ($indexOfFirstChild < $indexOfSecondChild) ? $indexOfFirstChild 
                                                                      : $indexOfSecondChild;

            
            // check for any omitted up to the user new level and update
            for ($i = 0; $i <= $lowerStage + 1; $i++) {
                $value = Stage_payment::where('user_id', $id)->pluck(self::STAGES[$i]);
                if ($value[0] == 0) {
                    //update level and pay bonus
                    Stage_payment::where('user_id', $id)
                            ->update([self::STAGES[$i] => 1]);

                    // pay bonus for that step
                    $payer = new Payer();
                    $payer->payBonus($id, self::STAGESBONUS[self::STAGES[$i]],
                                        'Matrix bonus of $' . self::STAGESBONUS[self::STAGES[$i]]);
                }
            }

            // update stage
            $newStage = 1;
            if ($lowerStage >= 1) $newStage = 2;
            if ($lowerStage >= 6) $newStage = 3;
            if ($lowerStage >= 11) $newStage = 4;
            if ($lowerStage >= 16) $newStage = 5;

            User_rank::where('myid', $id)
                        ->update(['stage' => $newStage]);

            // // update user level
            // Stage_payment::where('user_id', $id)
            //             ->update([self::STAGES[$lowerStage] => 1]);
        }
    }

    /**
     * Create a new contextual binding builder.
     *
     * @return Array return the array of the object containing name and id of the referred
     */
    public function getChildren($userId) {
        $userDownLink = [];
        $ref = new Referred();
        $downLinkArray = $ref->getDirectDownLink($userId); // get user 2 immediate downlink
        // loop through the referred users

        $maxLength = (sizeof($downLinkArray) > 2) ? 2 : sizeof($downLinkArray);
        for ($i = 0; $i < $maxLength; $i++) {
            array_push($userDownLink,  $downLinkArray[$i]);
        }

        return $userDownLink;
    }

    public function getStageStep($userId) {

        $userStage = Stage_payment::where('user_id', $userId)->first();

        // get present stage level of user
        foreach (array_reverse(self::STAGES) as $stage) {
            if($userStage[$stage] == 1) return $stage;
        }
        return NULL;
    }

    public function getStageBonus($userId, $stageLevel){

        $amount = self::STAGESBONUS[$stageLevel];
        $payer = new Payer();

        $userStage = Stage_payment::where('user_id', $userId)->first();

        // get present stage level of user
        foreach(array_reverse(self::STAGES) as $stage){
            if($userStage[$stage] == 1) return $stage;
        }
        return NULL;
    }

    /**
     * @name
     * @description
     */
    public function createStagePaymentRecord($userId){

        Stage_payment::where('user_id', $userId)->count();
        $userRecord = Stage_payment::where('user_id', $userId)->count();
        if ($userRecord < 1) {
            // create the user information on the stage / payment table
            Stage_payment::create(['user_id' => $userId]);
        }
    }
}