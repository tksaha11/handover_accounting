<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;


class SupportController extends Controller
{
    //

    public function Index()
    {
        $sql="select id,date_time,dept,sub,status from support_issue where store_id='".session('store-id')."' order by id desc";
        $data=DB::select($sql);
        return view('support.index',['data'=>$data]);
    }
    function createIssue(Request $req)
    {
        $issue_sql="INSERT INTO `support_issue`(`store_id`, `dept`, `sub`) VALUES ('".session('store-id')."','".$req->dept."','".$req->sub."')";
        DB::insert($issue_sql);

        $issue_id = DB::getPdo()->lastInsertId();
        $response_sql="INSERT INTO `support_response`( `issue_id`, `details`, `response_form`) VALUES ('".$issue_id."','".$req->details."','Store')";
        DB::insert($response_sql);

        return back()->with('success','Issue created successfully!');
    }
    public function Details($issue_id)
    {
        $sql="select support_issue.id,support_issue.date_time,dept,sub,status,details from support_issue,support_response where support_issue.id='".$issue_id."' and support_issue.id=support_response.issue_id";
        $data=DB::select($sql);
        if(!isset($data[0]))
            return back()->with('warning','Issuse details not found!');
        return view('support.support-details',['data'=>$data]);
    }
    
    public function CreateDeliveryMan()
    {
        $sql="SELECT id, `district`, `thana`  FROM `user_seller` WHERE id='".session('store-id')."'";
        $data=DB::select($sql);

        $distUrl="https://portal2.amarbazarltd.com/ablApi/getDistrict.php?username=ablapi@abl.com&password=1fa960236a09c331615f60afabd0e7e7ffa3f7d508e520d06ea566490c418c67";
        $client = new \GuzzleHttp\Client();
        $res = $client->get($distUrl);
        $content = (string) $res->getBody();

        $district=json_decode($content);
        
        return view('delivery.create-delivery-man',['data'=>$data,'district'=>$district]);
    }

    public function InsertDeliveryMan(Request $req)
    {
        $req->validate([
                'mobile' => 'unique:delivery_service',
                'nid_no' => 'unique:delivery_service',
            ],
            [
                'mobile.unique'=>'This Number is Already Taken',
                'nid_no.unique'=>'This NID is Already Taken',
            ]
        );
        $name=addslashes($req->name);
        $address=addslashes($req->address);
        $area=addslashes($req->area);
        $bank_name=addslashes($req->bank_name);
        $branch_name=addslashes($req->branch_name);
        $sql="INSERT INTO `delivery_service`( `store_id`, `name`, `address`, `mobile`, `email`, `district`, `thana`, `area`, `nid_no`, `bank_name`, `account_no`, `branch_name`) VALUES ('".session('store-id')."','$name','$address','".$req->mobile."','".$req->email."','".$req->district."','$req->thana','$area','".$req->nid_no."','".$bank_name."','".$req->account_no."','".$branch_name."')";
        DB::insert($sql);
        $lastInsertId = DB::getPdo()->lastInsertId();
        $logSql="INSERT INTO `log`(`table_name`, `table_id`, `user_id`, `user_type`, `log_type`,`note`) VALUES ('delivery_service','".$lastInsertId."','".session('store-id')."','Store','Delivery Man Create','Create Delivery Man')";
        DB::insert($logSql);


        if($req->file('dm_image'))
        {
            $filename=$lastInsertId.'-1.jpg';
            $image = $req->file('dm_image');
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(500, 500);
            $path = public_path('/assets/images/delivery/'.$filename);
            $image_resize->save($path);
            $image_resize->destroy();
        }
        if($req->file('nid_image'))
        {
            $filename=$lastInsertId.'-2.jpg';
            $image = $req->file('nid_image');
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(500, 500);
            $path = public_path('/assets/images/delivery/'.$filename);
            $image_resize->save($path);
            $image_resize->destroy();
        }

        return back()->with('success','Delivery Man Created successfully!');;

    }

    public function DeliveryManList()
    {
        $sql="SELECT  `name`, `mobile`, `email`, `area`, `bank_name`, `account_no`, `branch_name` FROM `delivery_service` WHERE `store_id`='".session('store-id')."'";
        $data=DB::select($sql);
        return view('delivery.delivery-man-list',['data'=>$data]);
    }

    public function AllDeliveryManList()
    {
        $sql="SELECT  `name`, `mobile`, `email`, `area`, `district`, `thana`, `bank_name`, `account_no`, `branch_name` FROM `delivery_service` WHERE 1";
        $data=DB::select($sql);
        return view('delivery.all-delivery-man-list',['data'=>$data]);
    }
}
