<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\Nagad\SendPayment;
use App\Http\Traits\Payment\Payment;
use Illuminate\Support\Facades\DB;



class PaymentNagadController extends Controller
{
    //
    use SendPayment;
    use Payment;

    public function RegPayment($id)
    {
        # code...
        $amount="1000";
        $OrderId="ADSTRREGBR".$id;
        $sendURL='/nagad/payment/';
        $backURL='/registration/paid/';

        $url=$this->sendPayment($OrderId,$amount,$sendURL,$backURL);

        return redirect()->to($url);
    }

    public function RegPaid($requiredData)
    {
        # code...
        $data=json_decode(base64_decode($requiredData));
        
        $explodeData=explode('BR',$data->orderId);
        $storeId=$explodeData[1];
        
        if($data->status=="Success"){
            // var_dump($data->paymentRefId);
            // die;
            $qry="UPDATE `user_seller` SET `payment_stat`='paid',`txn_no`='".$data->paymentRefId."',`status`='inactive' WHERE `id`=".$storeId;
            DB::update($qry);


            $this->PaidLogInsert($data->orderId,$data->paymentRefId,$data->amount,$data->clientMobileNo,$data->issuerPaymentDateTime,$data->status);

            $qry="SELECT `id`,`mobile`, `own_name`, `shop_name`,`shop_contact`, `district`, `thana`,`rin` FROM `user_seller` WHERE `id`=".$storeId;
            $storeData=DB::select($qry);

            session()->put('store-login',True);
            session()->put('store-role','Store Owner');
            session()->put('store-id',$storeData[0]->id);
            session()->put('store-mobile',$storeData[0]->mobile);
            session()->put('store-own_name',$storeData[0]->own_name);
            session()->put('store-shop_name',$storeData[0]->shop_name);
            session()->put('store-shop_contact',$storeData[0]->shop_contact);
            session()->put('store-rin',$storeData[0]->rin);
            session()->put('store-district',$storeData[0]->district);
            session()->put('store-thana',$storeData[0]->thana);

            return redirect('/');
        }
    }

    public function AblComPayment($storeId)
    {
        # code...
        // $sql="SELECT `id`,`abl_comission`
        // FROM `gen_orders` 
        // WHERE 
        // `status`='Delivered' AND 
        // `com_pay_stat`='pending' AND
        // `store_id`=".$storeId;
        

        $sql="SELECT 
                s1.id as id,
                SUM(s2.abl_comission) as comission
        FROM gen_orders as s1
        RIGHT JOIN gen_ord_items as s2 ON s1.id=s2.invoice
        RIGHT JOIN store_products as s3 ON s2.store_p_id=s3.id
        RIGHT JOIN user_seller as s4 ON s1.store_id= s4.id
        WHERE s4.id='".$storeId."' AND s1.status='Delivered' AND s1.com_pay_stat='Pending' group by s1.id";

        $data=DB::select($sql);
        

        $totalComission=0;
        $invoiceId="0";

        foreach($data as $item){
            $totalComission+=$item->comission;
            $invoiceId=$invoiceId.','.$item->id;
        }

  
        $invoiceId=base64_encode($invoiceId);

        $amount=(int)round($totalComission,0);
        
        $OrderId="ABLCOM".date('D').rand(1,9).rand(1,9).rand(1,9).'BR'.$storeId;
        $sendURL='/nagad/payment/';
        $backURL='/ablcomission/paid/'.$invoiceId.'/';
        
        // dd($OrderId, $invoiceId);

        $url=$this->sendPayment($OrderId,$amount,$sendURL,$backURL);
        
        return redirect()->to($url);
    }

    public function AblComPaid($invoices,$requiredData)
    {
        # code...
        $invoices=base64_decode($invoices);
        $data=json_decode(base64_decode($requiredData));
        
        // dd($data);
        
        $explodeData=explode('BR',$data->orderId);
        $storeId=$explodeData[1];
        
        if($data->status=="Success"){
            $this->PaidLogInsert($data->orderId,$data->paymentRefId,$data->amount,$data->clientMobileNo,$data->issuerPaymentDateTime,$data->status);
            
            $qry="UPDATE `gen_orders` SET `com_pay_stat`='paid',`com_paid_reff`='".$data->paymentRefId."' WHERE `id` in (".$invoices.")";

            $update=DB::update($qry);
            

            if($update){
                $sendBv=$this->SendBv($invoices);
                return redirect('/abl-accounts-paidList');
            }
        }
        
        
    }
      function SendBv($ids)
    {
        
        $sql="SELECT id,invoice,store_id,abl_comission,reff_rin FROM `gen_orders` where id in (".$ids.") and com_pay_stat='Paid' and send_bv='Pending'";

        $data=DB::select($sql);
       
        $query = http_build_query($data);

        $options = array(
            'http' => array(
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                            "Content-Length: ".strlen($query)."\r\n".
                            "User-Agent:MyAgent/1.0\r\n",
                'method'  => "POST",
                'content' => $query,
            ),
        );
        $url="https://admin.amarbazarltd.com/doaknreglist/dokanRefCom/";
        // $url="http://localhost/amarbazarltd/doaknreglist/dokanRefCom/";

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        $sql = "UPDATE `gen_orders` SET `send_bv` = 'Success' WHERE `gen_orders`.`id` in (".$ids.") and com_pay_stat='Paid'";
   
        $update=DB::update($sql);
        return 0;
    }

    public function B2BOrderPayment($inv)
    {
        # code...
        $sql="SELECT `id`, `invoice`,SUM(`seller_price`*`qty`) as ammount 
                FROM `b2b_orders` WHERE invoice='".$inv."'
            GROUP BY invoice";
        $data=DB::select($sql);

        $amount=$data[0]->ammount;
        // $amount=10;
        $OrderId=str_replace('-', 'P', $inv);
        $sendURL='/nagad/payment/';
        $backURL='/b2border/paid/'.$inv.'/';

        $url=$this->sendPayment($OrderId,$amount,$sendURL,$backURL);

        return redirect()->to($url);
    }

    public function B2BOrderPaid($invoice,$requiredData)
    {
        # code...
        $data=json_decode(base64_decode($requiredData));

        if($data->status=="Success"){
            $this->PaidLogInsert($data->orderId,$data->paymentRefId,$data->amount,$data->clientMobileNo,$data->issuerPaymentDateTime,$data->status);

            $qry="UPDATE `b2b_inoices_cust` 
                        SET 
                            `status`='paid',
                            `payment_method`='nagad',
                            `transectionid`='".$data->paymentRefId."' 
                        WHERE `invoice`='".$invoice."'";
            // $qry="UPDATE `gen_orders` SET `com_pay_stat`='paid',`com_paid_reff`='".$data->paymentRefId."' WHERE `id` in (".$invoices.")";
            DB::update($qry);

            return redirect('b2b-order-list')->with('success','Requisition created successfully!');
            // return redirect('/abl-accounts-paidList');
        }
    }
}
