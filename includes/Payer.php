<?php
/**
 * Created by PhpStorm.
 * User: latyf
 * Date: 6/11/18
 * Time: 9:20 PM
 * @name Payer
 * @package  Uplink
 * @author   Latyf <latyf01@gmail.com>
 * @license  no licence
 * @link     http://
 * @description This class handles the payments of all the users.uplinks
 */

require_once 'app/init.php';
require_once './UserClass.php';

class Payer
{
    const MASTER_ACCOUNT_ID = 'Admin1'; // the id of the super admin that receives and make payment
    public $registrationFee = 40; // $40 for registration
    public $refererFree = 8; // $8 payment for referring a new user


    /**
     * Create a new contextual binding builder.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * Do the registration payment.
     * @param userId  the id of the user whose balance is to be gotten
     *
     * @return balance
     */
    public function getBalance($userId) {
        $payer = User_rank::where('myid', $userId)->first();

        return $payer->balance;
    }

    /**
     * get the registration financial Status.
     * @param payerId  the id of the payer
     *
     * @return status
     */
    public function userRegFinancialStatus($payerId)
    {
        if($this->getBalance($payerId) >= $this->registrationFee) return true;

        return false;
    }

    /**
     * Do the registration payment.
     * @param payerId  the id of the payer
     *
     * @return void
     */
    public function payRegistration($payerId, $referrerUser) {

        $userClass = new UserClass();
        $referrerId = $userClass->getUserId($referrerUser);

        // deduct 40 dollars from the payer's balance
        if($this->getBalance($payerId) >= $this->registrationFee) {
            $balance = $this->getBalance($payerId) - $this->registrationFee;
            $response = User_rank::where('myid', $payerId)->update(['balance' => $balance]);

            if($response) {
                // pay the money to the master admin's account
                $adminBalance = $this->getBalance(self::MASTER_ACCOUNT_ID) + $this->registrationFee;
                $response = User_rank::where('myid', self::MASTER_ACCOUNT_ID)->update(['balance' => $adminBalance]);

                //todo:: log the payment
                $adminId = $userClass->getUserId(self::MASTER_ACCOUNT_ID);
                $this->logger($payerId, $adminId, $this->registrationFee, 'registration Fee');

                // pay referrer
                $this->payReferrer($referrerId);

                return ($response) ? true : false;
            }
        }

        return false;
    }

    /**
     * Do the registration payment.
     * @param referrerId  the id of the referrer
     *
     * @return response  payment response
     */
    public function payReferrer($referrerId) {

        // pay referrer for referring the new user
        $balance = $this->getBalance($referrerId) + $this->refererFree;
        User_rank::where('myid', $referrerId)->update(['balance' => $balance]);

        //todo:: log the payment
        $userClass = new UserClass();
        $adminId = $userClass->getUserId(self::MASTER_ACCOUNT_ID);
        $this->logger($adminId, $referrerId, $this->refererFree, 'Referrer Bonus');
    }

    /**
     * Do the registration payment.
     * @param senderId  the id of the sender
     * @param receiverId  the id of the receiver
     * @param amount  amount to be transfer
     *
     * @return void
     */
    public function transferFund($senderId, $receiverId, $amount) {
    }





    /**
     * Do the registration payment.
     * @param senderId  the id of the sender
     * @param receiverId  the id of the receiver
     * @param amount  amount to be transfer
     * @param info  information about the payment or transfer
     *
     * @return void
     */
    public function logger($senderId, $receiverId, $amount, $info) {

        User::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
//            'sender_name' => $username,
//            'receiver_name' => $firstname,
//            'ref_id' => $lastname,
//            'ref_name' => $gender,
            'Amount' => $amount,
            'Remark' => $info,
            'Status' => 'Paid',
        ]);
    }









}