<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
    //
    public function index()
    {
        $distUrl="https://portal2.amarbazarltd.com/ablApi/getDistrict.php?username=ablapi@abl.com&password=1fa960236a09c331615f60afabd0e7e7ffa3f7d508e520d06ea566490c418c67";
        $client = new \GuzzleHttp\Client();
        $res = $client->get($distUrl);
        $content = (string) $res->getBody();
        $district=json_decode($content);

        $sql="SELECT * FROM `user_seller` where id='".session('store-id')."'";
        $store=DB::select($sql);
        if(!isset($store[0]))
            return back()->with('warning','Store not found!');

        return view('profile.index',['district'=>$district,'store'=>$store[0]]);
    }

    function update(Request $req)
    {
        // return back()->with('success',"Hello Mister");
        $password="";
        if(isset($req->password))
        {
            if($req->password!=$req->conpassword)
                return back()->with('warning',"Password and confirm password does not match!");
            else if(strlen($req->password)<6)
                return back()->with('warning',"Password should be minimum 6 character!");
            else
            {
                $haspass = Hash::make($req->password, [
                    'memory' => 1024,
                    'time' => 2,
                    'threads' => 2,
                ]);

                $password=",`password`='".$haspass."'";
            }
        }

        $sql="UPDATE `user_seller` 
            SET `email`='".$req->email."',
                `own_name`='".$req->own_name."',
                `shop_address`='".$req->shop_address."',
                `shop_contact`='".$req->shop_contact."',
                `rin`='".$req->rin."',
                `del_area`='".$req->delArea."',
                `district`='".$req->district."',
                `thana`='".$req->thana."',
                `shop_cat`='".$req->shop_cat."'
                ".$password.",
                `del_charge`='".$req->del_charge."' 
            
            WHERE mobile='".$req->mobile."' and status='active'";

        $update=DB::update($sql);

        
        if($update>0)
        {
            session()->put('store-own_name',$req->own_name);
            session()->put('store-shop_name',$req->shop_name);
            session()->put('store-shop_contact',$req->shop_contact);
            session()->put('store-rin',$req->rin);
            session()->put('store-district',$req->district);
            session()->put('store-thana',$req->thana);
            
            $logSql="INSERT INTO `log`(`table_name`, `table_id`, `user_id`, `user_type`, `log_type`, `note`) VALUES ('user_seller','".session('store-id')."','".session('store-id')."','Store','Update Store Profile','Update Store profile by seller')";
            DB::update($logSql);
        }
        return back()->with('success','Update profile successfully!');
       
    }
    
}
