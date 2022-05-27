<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    //

    public function AllOrders()
    {
        $sql="SELECT id,date_time,invoice,ship_name,ship_mobile,ship_address,status,(select sum(qty*unit_sale) FROM `gen_ord_items` where gen_orders.id=gen_ord_items.invoice) as amount FROM `gen_orders` where store_id=".session('store-id');

        $data=DB::select($sql);

        return view('orders.index',['data'=>$data]);
    }

    function showGenInvoice($invoice)
    {
        $inoviceSql="Select id,date_time,invoice,store_id,ship_name,ship_address,ship_mobile,pay_type,del_charge from gen_orders where invoice='".$invoice."'";
        $invoiceData=DB::select($inoviceSql);
        if(!isset($invoiceData))
            return back()->with('warning','Invoice not found!');
        
        $itemSql="SELECT id,store_p_id,unit_sale,qty,sum(unit_sale*qty) as sub_tot,(SELECT title FROM `store_products` where store_products.id=store_p_id) as title FROM `gen_ord_items` where invoice='".$invoiceData[0]->id."' group by store_p_id";

        $itemData=DB::select($itemSql);

        return view('orders.invoice',['invoiceData'=>$invoiceData[0],'itemData'=>$itemData]);
    }

    function updateGenStatus(Request $req)
    {
        $updateSql="UPDATE `gen_orders` 
                    SET status='".$req->status."' 
                    WHERE invoice='".$req->invoice."'";
        DB::update($updateSql);

        $invoiceNo=$req->invoice;

        $sql4=" SELECT id 
                FROM `gen_orders` 
                WHERE `invoice`='$invoiceNo'";
        $order=DB::select($sql4);

        $orderId=$order[0]->id;
        $orderNote=addslashes($req->note);

        $sql5=" INSERT INTO `order_note`(`order_id`, `status`, `note`) 
                VALUES ('$orderId','".$req->status."','$orderNote')";
        $orderNote=DB::insert($sql5);

        $shopId=Session::get('store-id');

        $sql3="SELECT `shop_name` 
        FROM `user_seller` 
        WHERE `id`=".$shopId;
        $data3=DB::select($sql3);

        $shopName=$data3[0]->shop_name;

        $sql="SELECT `cust_id`
        FROM `gen_orders` 
        WHERE `invoice`='$req->invoice'";
        $data=DB::select($sql);

        $customerId=$data[0]->cust_id;
        if($customerId !=NULL)
        {
            $sql2="SELECT `email` FROM `user_customer` WHERE `id`='$customerId'";
            $data2=DB::select($sql2);
            // dd($customerId);
            $email=$data2[0]->email;
            // $email='masudranamr8061@gmail.com';
            if($req->status=="Processing" || $req->status=="processing")
            {
                $invId=$req->invoiceId;
                $orderNote=addslashes($req->note);
                $randomNumber = random_int(100000, 999999);
                $randomNumber2 = random_int(100000, 999999);
                $randomNumber3 = rand(1000000000, 9999999999);
                $newinvId=$randomNumber2.$invId.$randomNumber.$randomNumber3;
                $url=env('SITE_URL').'checkoutInvoice/'.$newinvId;
                $subject="আপনার অর্ডার আমারদোকান-".$shopName." শপে প্রক্রিয়াধীন আছে। - ".$invoiceNo;
                $bodyText="আপনার অর্ডার ".$invoiceNo." আমারদোকান-".$shopName." শপে প্রক্রিয়াধীন আছে। নিচের লিঙ্কে ক্লিক করে আপনার ইনভয়েস দেখুন।"."<br>"."Note: ".$orderNote;
                
                $this->sendMail($email,$subject,$bodyText,$url);
            }
            elseif($req->status=="Delivered" || $req->status=="delivered")
            {
                $orderNote=addslashes($req->note);
                $subject="আপনার অর্ডার আমারদোকান-".$shopName." শপ থেকে ডেলিভারি হয়েছে। - ".$invoiceNo;
                $bodyText="আপনার অর্ডার ".$invoiceNo." আমারদোকান-".$shopName." শপ থেকে ডেলিভারি হয়েছে। পন্য অথবা সার্ভিস নিয়ে কোন অভিযোগ থাকলে আমাদের সাপোর্ট ইমেইল এ যোগাযোগ করুন। সাপোর্ট ইমেইল - customersupport@ablamardokan.com"."<br>"."Note: ".$orderNote;
                $url=''; 
                
                $this->sendMail($email,$subject,$bodyText,$url);
            }
            else
            {
                $orderNote=addslashes($req->note);
                $subject="আপনার অর্ডার আমারদোকান-".$shopName." শপ থেকে ক্যান্সেল করা  হয়েছে। - ".$invoiceNo;
                $bodyText="আপনার অর্ডার ".$invoiceNo." আমারদোকান-".$shopName." শপ থেকে ক্যান্সেল করা  হয়েছে। পন্য অথবা সার্ভিস নিয়ে কোন অভিযোগ থাকলে আমাদের সাপোর্ট ইমেইল এ যোগাযোগ করুন। সাপোর্ট ইমেইল - customersupport@ablamardokan.com"."<br>"."Note: ".$orderNote;
                $url='';
                
                $this->sendMail($email,$subject,$bodyText,$url);
            }   
        }

        return back()->with('warning','Update Status Successfully!');
    }
    public function PendingOrders()
    {
        $sql="SELECT id,date_time,invoice,ship_name,ship_mobile,ship_address,status,(select sum(qty*unit_sale) FROM `gen_ord_items` where gen_orders.id=gen_ord_items.invoice) as amount FROM `gen_orders` where store_id=".session('store-id')." AND `status`='pending'";

        $data=DB::select($sql);

        return view('orders.pending',['data'=>$data]);
    }
    public function DeliveredOrders()
    {
        $sql="SELECT id,date_time,invoice,ship_name,ship_mobile,ship_address,status,(select sum(qty*unit_sale) FROM `gen_ord_items` where gen_orders.id=gen_ord_items.invoice) as amount FROM `gen_orders` where store_id=".session('store-id')." AND `status`='Delivered'";

        $data=DB::select($sql);

        return view('orders.delivered',['data'=>$data]);
    }
    public function ProcessingOrders()
    {
        $sql="SELECT id,date_time,invoice,ship_name,ship_mobile,ship_address,status,(select sum(qty*unit_sale) FROM `gen_ord_items` where gen_orders.id=gen_ord_items.invoice) as amount FROM `gen_orders` where store_id=".session('store-id')." AND `status`='Processing'";

        $data=DB::select($sql);

        return view('orders.processing',['data'=>$data]);
    }
    public function CanceledOrders()
    {
        $sql="SELECT id,date_time,invoice,ship_name,ship_mobile,ship_address,status,(select sum(qty*unit_sale) FROM `gen_ord_items` where gen_orders.id=gen_ord_items.invoice) as amount FROM `gen_orders` where store_id=".session('store-id')." AND `status`='Canceled'";

        $data=DB::select($sql);

        return view('orders.canceled',['data'=>$data]);
    }
}
