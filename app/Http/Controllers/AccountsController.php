<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    //
    public function MyAccounts(Request $req)
    {
        if($req->date=="")
            $date=date('Y-m-d');
        else
            $date=$req->date;
        $outNinSql="SELECT * FROM `acc_transection` where `date` ='".$date."' and store_id='".session('store-id')."'";
        $outNin=DB::select($outNinSql);

        $closingSql="SELECT coalesce(sum(amount*transection_type),0) as closing_balance FROM `acc_transection` where `date` < '".$date."' and store_id='".session('store-id')."'";
        $closing=DB::select($closingSql);

        $sql="SELECT 	id,
                        ship_name,
                        invoice,
                        (select sum(qty*unit_sale) 
                FROM `gen_ord_items` 
                where gen_orders.id=gen_ord_items.invoice)+del_charge as amount 
                FROM `gen_orders` 
                where store_id='".session('store-id')."' AND gen_orders.status='Delivered'";
        $totalAmount=DB::select($sql);

        return view('accounts.index',['outNin'=>$outNin,'date'=>$date,'closing'=>$closing,'totalAmount'=>$totalAmount]);
    }

    function acc_transection(Request $req)
    {
        if(strlen($req->trans_perpose)>500)
            return back()->with('warning',"Note can't be greater than 500 word");
        if(strlen($req->transection_name)>250)
            return back()->with('warning',"Name can't be greater than 250 word");

        $sql="INSERT INTO `acc_transection`(`date`, `store_id`, `transection_type`, `transection_name`, `amount`, `trans_perpose`) VALUES ('".date('Y-m-d')."','".session('store-id')."','".$req->transection_type."','".$req->transection_name."','".$req->amount."','".$req->trans_perpose."')";
        DB::insert($sql);
        return back()->with('success',"Transection successfully created!");

    }
}
