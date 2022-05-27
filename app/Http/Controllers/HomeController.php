<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    function dashboard()
    {
        $this->notification();
        //order Count
        $orderCntSql="SELECT status,count(id) as cnt FROM `gen_orders` where store_id=".session('store-id')." group by status";
        $orderCnts=DB::select($orderCntSql);
        $totCnt=0;
        foreach($orderCnts as $order)
        {
            $orderCnt[$order->status]=$order->cnt;
            $totCnt+=$order->cnt;
        }
        $orderCnt['Orders']=$totCnt;

        //product
        $uploadProdutSql="SELECT count(id) as cnt,status FROM `products` where upload_from='store' and id in (SELECT table_id FROM `log` where log_type='General Product Create' and user_id=".session('store-id').") group by status";
        $uploadProducts=DB::select($uploadProdutSql);
        $tot_product=0;
        foreach($uploadProducts as $item)
        {
            $tot_product+=$item->cnt;
            $product[$item->status]=$item->cnt;
        }
        $product['total_upload']=$tot_product;

       

        $enlistProductSql="SELECT count(*) as cnt FROM `store_products` where store_id=".session('store-id')." and store_enlist=1 and prod_id in (select id from products where products.id=prod_id and products.status='Active')";
        $enlistProduct=DB::select($enlistProductSql);
        $product['enlist']=$enlistProduct[0]->cnt;
        

        
        //order amount
        $payableSql="SELECT sum(unit_sale*qty) as amt FROM `gen_ord_items`,`gen_orders` where gen_orders.store_id=".session('store-id')." and gen_orders.invoice=gen_ord_items.invoice and gen_orders.status='Delivered' and com_pay_stat='Pending'";
        $payable=DB::select($payableSql);

        $orderAmtSql="SELECT sum(unit_sale*qty) as amt,gen_orders.status FROM `gen_ord_items`,`gen_orders` where gen_orders.store_id=".session('store-id')." and gen_orders.invoice=gen_ord_items.invoice group by gen_orders.status";
        $orderAmts=DB::select($orderAmtSql);
        $totAmt=0;
        foreach($orderAmts as $item)
        {
            $orderAmt[$item->status]=$item->amt;
            $totAmt+=$item->amt;
        }
        $orderAmt['Orders']=$totAmt;
        $orderAmt['payable']=$payable[0]->amt;

        return view('home.dashboard',['orderCnt'=>$orderCnt,'product'=>$product,'orderAmt'=>$orderAmt]);
    }

    function notification()
    {
        //notification
        $notficationSql="SELECT *,SUBSTRING(notification_body,1,50) as sort_notification_body FROM `notification` where notification_to='Seller' order by id desc limit 5";
        $notification=DB::select($notficationSql);
        session()->put('notification',$notification);
    }
}
