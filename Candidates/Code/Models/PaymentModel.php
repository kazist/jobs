<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Candidates\Code\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Model\BaseModel;
use Kazist\Service\Email\Email;

/**
 * Description of AdvertModel
 *
 * @author sbc
 */
class PaymentModel extends BaseModel {

    //put your code here

    public function paymentSuccessful($payment) {

        $email = new Email();

        $this->deductAmount($payment);

        $this->updatePayment($payment, 1, 'successful');

        $email_data = $this->getDataObject($payment);

        $email->sendDefinedLayoutEmail('jobs.jobs.paymentsuccessful', $email_data['user']->email, $email_data);
    }

    public function paymentFail($payment) {

        $email = new Email();

        $this->updatePayment($payment, 0, 'fail');

        $email_data = $this->getDataObject($payment);

        $email->sendDefinedLayoutEmail('jobs.jobs.paymentfail', $email_data['user']->email, $email_data);
    }

    public function paymentComplete($payment) {

        $email = new Email();

        $this->updatePayment($payment, 0, 'complete');

        $email_data = $this->getDataObject($payment);

        $email->sendDefinedLayoutEmail('jobs.jobs.paymentcomplete', $email_data['user']->email, $email_data);
    }

    public function paymentCancel($payment) {

        $email = new Email();

        $this->updatePayment($payment, 0, 'cancel');

        $email_data = $this->getDataObject($payment);

        $email->sendDefinedLayoutEmail('jobs.jobs.paymentcancel', $email_data['user']->email, $email_data);
    }

    public function updatePayment($payment, $status, $stage) {

        $factory = new KazistFactory();

        $data = new \stdClass();

        $data->id = $payment->item_id;
        $data->payment_amount = $payment->amount;
        $data->payment_status = $status;
        $data->payment_stage = $stage;
        if ($status) {

            $candidate = $factory->getRecord('#__jobs_candidates', 'jc', array('jc.id = :id'), array('id' => $payment->item_id));
            $package_price = $factory->getRecord('#__jobs_packages_prices', 'jpp', array('jpp.id = :id'), array('id' => $candidate->package_price_id));

            $data->payment_expiry = $this->getExpiryDate($candidate->payment_expiry, $package_price->no_of_days); // (time() > strtotime($candidate->payment_expiry));
        }
        $data->payment_date = $payment->date_created;
       
        $factory->saveRecord('#__jobs_candidates', $data);
    }

    public function getExpiryDate($expiry_date, $no_of_days = 30) {

        $no_of_days = ($no_of_days) ? $no_of_days : 30;

        if ($this->is_package_changed) {
            $expiry_date = date('Y-m-d H:i:s');
        }

        $expiry_date_stamp = strtotime($expiry_date);
        $today_date_stamp = time();

        if ($expiry_date_stamp > $today_date_stamp) {

            $d = new \DateTime($expiry_date);
            $d->modify(' +' . $no_of_days . ' days');
            $expiry_date = $d->format('Y-m-d H:i:s');
        } else {

            $d = new \DateTime();
            $d->modify(' +' . $no_of_days . ' days');
            $expiry_date = $d->format('Y-m-d H:i:s');
        }

        return $expiry_date;
    }

    public function deductAmount($payment) {

        $factory = new KazistFactory();

        $deductions = json_decode($payment->deductions, true);

        $data_obj = new \stdClass();
        $data_obj->user_id = $payment->user_id;
        $data_obj->behalf_user_id = $payment->user_id;
        $data_obj->item_id = $payment->id;
        $data_obj->description = $payment->description . ' [Txn : ' . $payment->id . ']';
        $data_obj->debit = ($deductions['intial_amount']) ? $deductions['intial_amount'] : $payment->amount_required;
        $data_obj->type = 'payment-charges';
        $data_obj->source = 'payment';

        $factory->saveRecord('#__finance_transactions', $data_obj);
    }

    public function getDataObject($payment) {

        $factory = new KazistFactory();

        $candidate = $factory->getRecord('#__jobs_candidates', 'jc', array('jc.id = :id'), array('id' => $payment->item_id));
        $user = $factory->getRecord('#__users_users', 'uu', array('uu.id = :id'), array('id' => $candidate->created_by));

        $tmp_array['user'] = $user;
        $tmp_array['candidate'] = $candidate;
        $tmp_array['payment'] = $payment;
        $tmp_array['url']['candidate'] = $this->generateUrl('jobs.candidates', null, 0);

        return $tmp_array;
    }

}
