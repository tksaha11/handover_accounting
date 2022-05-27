<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NotificationController extends Controller
{
    //
    function showAll()
    {
        $sql="SELECT *,SUBSTRING(notification_body,1,50) as short_notification_body FROM `notification` where notification_to='Seller' ORDER BY `id` desc";
        $data=DB::select($sql);
        return view('notification.view-all',['data'=>$data]);
    }

    function showFull($id)
    {
        $sql="SELECT * FROM `notification` where id='".$id."'";
        $data=DB::select($sql);
        if(!isset($data[0]))
            return back()->with('warning','Notificaion not found!');
        return view('notification.view-full',['data'=>$data[0]]);
    }
}
