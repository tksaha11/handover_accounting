<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    //
    public function AllCustomer()
    {
        $sql="  SELECT
                        user_customer.name as name,
                        user_customer.mobile as mobile,
                        (
                            SELECT COUNT(invoice) 
                            FROM gen_orders 
                            WHERE gen_orders.cust_id=user_customer.id
                        ) as total_order
                FROM `user_customer`,log 
                where log.table_name='user_customer' AND 
                log.user_id='".session('store-id')."' AND 
                log.table_id=user_customer.id";
        $data=DB::select($sql);

  
        return view('customer.index',['data'=>$data]);
    }

    function regForm()
    {
        if(session('store-rin'))
            $reff_rin=session('store-rin');
        else
            $reff_rin='ABL-777-0001';

        return view('customer.reg-form',['reff_rin'=>$reff_rin]);
    }

    function customerReg(Request $req)
    {
       
        if($req->password!=$req->conpassword)
            return back()->withInput()->with('warning','Password not match!');
        
        $haspass = Hash::make($req->password, [
            'memory' => 1024,
            'time' => 2,
            'threads' => 2,
        ]);

        $sql="INSERT INTO `user_customer`(`name`,`email`, `mobile`,`reff_rin`, `password`) VALUES ('".$req->name."','".$req->email."','".$req->mobile."','".$req->reff_rin."','".$haspass."')";

        DB::insert($sql);
        $tableId=DB::getPdo()->lastInsertId();

        $sql2="INSERT INTO `log`(`table_name`, `table_id`, `user_id`, `user_type`, `log_type`, `note`) VALUES ('user_customer','$tableId','".session('store-id')."','Customer','Customer Registration','New Customer Registration From Store')";
        DB::insert($sql2);

       
        return back()->with('success','Customer Registration Successfully!');
    }

    function AllCustomerList()
    {
        $sql="SELECT bill_name, bill_mobile,COUNT(invoice) as total_order,bill_address
        FROM gen_orders WHERE store_id='".session('store-id')."'
        GROUP by bill_mobile";
        $data=DB::select($sql);
        return view('customer.allCustomerList',['data'=>$data]);
    }
  
}
