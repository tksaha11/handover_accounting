<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ABLAccountsController extends Controller
{
    //
    public function PayableToABL()
    {
        $sql="SELECT s1.invoice as invoice, date(s1.date_time)as date, s1.bill_name as bill_name, s1.status as delivery_status, s1.com_pay_stat as payment_status, s2.unit_sale as unit_price,s2.qty as qty,s2.unit_sale*s2.qty as total, s2.abl_com_percentage as comission_percent, s2.abl_comission as comission,s3.title as name
        FROM gen_orders as s1
        RIGHT JOIN gen_ord_items as s2 ON s1.id=s2.invoice
        RIGHT JOIN store_products as s3 ON s2.store_p_id=s3.id
        RIGHT JOIN user_seller as s4 ON s1.store_id= s4.id
        WHERE s4.id='".session('store-id')."' AND s1.status='Delivered' AND s1.com_pay_stat='Pending'";

        $data=DB::select($sql);

        // $totSql="select coalesce(sum(gen_ord_items.abl_comission),0) as comission,coalesce(sum(unit_sale*qty),0) as tot_amt from gen_ord_item,gsen_orders where gen_ord_items.store_id='".session('store-id')."' and com_pay_stat='Pending' and status='Delivered' and gen_orders.invoice=gen_ord_items.invoice";

        // $tot_data=DB::select($totSql);

        return view('ablAccounts.payableToAbl',['data'=>$data]);
    }

    public function PaidList()
    {
        $sql="SELECT s1.invoice as invoice, date(s1.date_time)as date, s1.bill_name as bill_name, s1.status as delivery_status, s1.com_pay_stat as payment_status, s2.unit_sale as unit_price,s2.qty as qty,s2.unit_sale*s2.qty as total, s2.abl_com_percentage as comission_percent, s2.abl_comission as comission,s3.title as name
        FROM gen_orders as s1
        RIGHT JOIN gen_ord_items as s2 ON s1.id=s2.invoice
        RIGHT JOIN store_products as s3 ON s2.store_p_id=s3.id
        RIGHT JOIN user_seller as s4 ON s1.store_id= s4.id
        WHERE s4.id='".session('store-id')."' AND s1.status='Delivered' AND s1.com_pay_stat='paid'";
        $data=DB::select($sql);

        return view('ablAccounts.paidList',['data'=>$data]);
    }

}
