<?php
    namespace App\Http\Traits\Payment;

    use Illuminate\Support\Facades\DB;

    trait Payment{
        public function PaidLogInsert($orderId,$paymentRefId,$amount,$clientMobileNo,$issuerPaymentDateTime,$status)
        {
            # code...\
            $qry="INSERT INTO `payment_log`
                    (`pg_method`, `pg_method_name`,order_id,`payment_ref_id`, `amount`, `client_mobile_no`, `issuer_payment_date_time`, `status`) 
                    VALUES 
                    ('Mobile Bank','Nagad','".$orderId."','".$paymentRefId."','".$amount."','".$clientMobileNo."','".$issuerPaymentDateTime."','".$status."')";
    
            DB::insert($qry);
        }
    }