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
    public function payRegistration($payerId) {

        // deduct 40 dollars from the payer's balance
        if($this->getBalance($payerId) >= $this->registrationFee) {
            $balance = $this->getBalance($payerId) - $this->registrationFee;
            $response = User_rank::where('myid', $payerId)->update(['balance' => $balance]);

            if($response) {
                // pay the money to the master admin's account
                $adminBalance = $this->getBalance(self::MASTER_ACCOUNT_ID) + $this->registrationFee;
                $response = User_rank::where('myid', self::MASTER_ACCOUNT_ID)->update(['balance' => $adminBalance]);

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

}