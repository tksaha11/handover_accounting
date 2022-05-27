<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LoginRegController extends Controller
{
    function regForm()
    {
        if(session('store-role')=='Store Owner')
        {
            return redirect('/');
        }

        $distUrl="https://portal2.amarbazarltd.com/ablApi/getDistrict.php?username=ablapi@abl.com&password=1fa960236a09c331615f60afabd0e7e7ffa3f7d508e520d06ea566490c418c67";
        $client = new \GuzzleHttp\Client();
        $res = $client->get($distUrl);
        $content = (string) $res->getBody();

        $district=json_decode($content);
        
        return view('loginReg.regForm',['district'=>$district]);
    }

    function storeReg(Request $req)
    {
        // echo "<pre>";
        // print_r($req->input());
        // die;
        $storeSql="SELECT * FROM `user_seller` WHERE mobile='".$req->mobile."'";
        $checkDuplicate=DB::select($storeSql);
        if(isset($checkDuplicate[0]))
            return back()->withInput()->with('warning','Already have account. Please use different mobile as username!');

        if($req->delArea=='')
            return back()->withInput()->with('warning','Delivery Area is required!');
        if($req->district=='')
            return back()->withInput()->with('warning','District required!');
        if($req->thana=='')
            return back()->withInput()->with('warning','Thana Required!');
        if($req->password!=$req->conpassword)
            return back()->withInput()->with('warning','Password not match!');

        $haspass = Hash::make($req->password, [
            'memory' => 1024,
            'time' => 2,
            'threads' => 2,
        ]);

        $insertSql="INSERT INTO `user_seller`(`email`, `mobile`, `own_name`, `shop_name`, `shop_address`, `shop_contact`,`del_area`,`rin`, `district`, `thana`, `shop_cat`, `password`, `abl_plan`) 
        VALUES ('".$req->email."','".$req->mobile."','".$req->own_name."','".$req->shop_name."','".$req->shop_address."','".$req->shop_contact."','".$req->delArea."','".$req->rin."','".$req->district."','".$req->thana."','".$req->shop_cat."','".$haspass."','".$req->abl_plan."')";

        // echo $insertSql;
        // die;
        DB::insert($insertSql);
        $id = DB::getPdo()->lastInsertId();

        // session()->put('store-login',True);
        // session()->put('store-role','Store Owner');
        // session()->put('store-id',$id);
        // session()->put('store-mobile',$req->mobile);
        // session()->put('store-own_name',$req->own_name);
        // session()->put('store-shop_name',$req->shop_name);
        // session()->put('store-shop_contact',$req->shop_contact);
        // session()->put('store-rin',$req->rin);
        // session()->put('store-district',$req->district);
        // session()->put('store-thana',$req->thana);

        // session()->put('store-admin-url','http://127.0.0.1:8002/');
        // session()->put('store-customer-url','http://127.0.0.1:8003/');

        $this->cartNumber();

        $url='/registration/payment/'.$id;

        return redirect($url);

    }
    function loginForm()
    {
        if(session('store-role')=='Store Owner')
        {
            return redirect('/');
        }
        return view('loginReg.loginForm');
    }
    function storeLogin(Request $req)
    {
       
        $sql="SELECT * FROM `user_seller` where mobile='".$req->mobile."'";
        $store=DB::select($sql);

        if(!isset($store[0]))
            return back()->withInput()->with('warning','Store not found!');
        if($store[0]->status!='active')
            return back()->withInput()->with('warning','Store not active!');


        if (Hash::check($req->password, $store[0]->password)) {
            
            session()->put('store-login',True);
            session()->put('store-role','Store Owner');
            session()->put('store-id',$store[0]->id);
            session()->put('store-mobile',$store[0]->mobile);
            session()->put('store-own_name',$store[0]->own_name);
            session()->put('store-shop_name',$store[0]->shop_name);
            session()->put('store-shop_contact',$store[0]->shop_contact);
            session()->put('store-rin',$store[0]->rin);

            session()->put('store-district',$store[0]->district);
            session()->put('store-thana',$store[0]->thana);
            session()->put('store-admin-url','http://127.0.0.1:8000/');
            session()->put('store-customer-url','http://127.0.0.1:8003/');
            // session()->put('store-admin-url','http://127.0.0.1:8002/');
            // session()->put('store-customer-url','http://127.0.0.1:8003/');

            $this->cartNumber();
            $this->notification();
 
           return redirect('/');
        }
        else
            return back()->withInput()->with('warning','Incorrect Password!');
    }

  
    function notification()
    {
        //notification
        $notficationSql="SELECT *,SUBSTRING(notification_body,1,50) as sort_notification_body FROM `notification` where notification_to='Seller' order by id desc limit 5";
        $notification=DB::select($notficationSql);
        session()->put('notification',$notification);
    }

    function storeLogout()
    {
        session()->forget('store-login');
        session()->forget('store-role');
        return redirect('store-login-form');
    }

    function cartNumber()
    {
        $cartSql="select count(*) as cart_num from b2b_carts where store_id='".session('store-id')."' and active=1";
        $cartNum=DB::select($cartSql);

        $cartInfo['number']=$cartNum[0]->cart_num;
        session()->put('cartInfo',$cartInfo);
    }
}
