<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PortalApiController extends Controller
{
    function dokanList()
    {
        $sql="SELECT id as xsl,shop_name as org, shop_address as addr, shop_contact as mobile, district as dist FROM `user_seller` where status='Active'";
        $data = DB::select($sql);
        $result = json_encode($data);
        return $result;
    }
}
