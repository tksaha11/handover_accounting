<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    //
    public function ReqProductList($campaign_name)
    {
        
        $sql="SELECT store_products.id as store_p_id,products.id as product_id,store_products.sale_price,store_products.stock,store_products.title,products.unit_mrp 
        FROM `store_products`,products
        where products.status='active' and store_products.store_enlist=1 and store_products.prod_id=products.id and store_products.store_id=".session('store-id')." and store_products.id not in (SELECT store_p_id FROM `campaign` where store_id=".session('store-id')." and campaign_name='".$campaign_name."' and active=1)";

        $data=DB::select($sql);
        $catInfo=$this->getCategory();

        return view('campaign.requiredProductList.index',['data'=>$data,'campaign_name'=>$campaign_name,'catInfo'=>$catInfo]);
       
    }
    function addOrRemove($store_p_id,$type,$campaign_name)
    {
        //add to campaign
        if($type==1)
        {
            $itemInfoSql="SELECT title,sale_price FROM `store_products` where id='".$store_p_id."'";
            $itemInfo=DB::select($itemInfoSql);
            if(!isset($itemInfo[0]))
                return back()->with('warning','Product not found!');
            $sql="INSERT INTO `campaign`(`campaign_name`, `store_id`, `store_p_id`, `title`, `sale_price`,`active`) VALUES ('".$campaign_name."','".session('store-id')."','".$store_p_id."','".$itemInfo[0]->title."','".$itemInfo[0]->sale_price."','".$type."')";
            DB::insert($sql);
        }
        else if($type==0)
        {
            $sql="UPDATE `campaign` SET `active`='".$type."' WHERE campaign_name='".$campaign_name."' and store_p_id=".$store_p_id;
            DB::update($sql);
        }
       
        return back()->with('success','Campagin product update successfully!');
    }
    public function ComboOfferList()
    {
        $sql="SELECT store_products.id as store_p_id,products.id as product_id,store_products.sale_price,store_products.stock,store_products.title,products.unit_mrp 
        FROM `store_products`,products
        where products.status='active' and store_products.store_enlist=1 and store_products.prod_id=products.id and store_products.store_id=".session('store-id')." and store_products.id in (SELECT store_p_id FROM `campaign` where store_id=".session('store-id')." and campaign_name='Special Combo Offer' and active=1)";

        $data=DB::select($sql);
        $catInfo=$this->getCategory();

        return view('campaign.special-combo',['data'=>$data,'campaign_name'=>'Special Combo Offer','catInfo'=>$catInfo]);
    }
    public function DiscountOfferList()
    {
        $sql="SELECT store_products.id as store_p_id,products.id as product_id,store_products.sale_price,store_products.stock,store_products.title,products.unit_mrp 
        FROM `store_products`,products
        where products.status='active' and store_products.store_enlist=1 and store_products.prod_id=products.id and store_products.store_id=".session('store-id')." and store_products.id in (SELECT store_p_id FROM `campaign` where store_id=".session('store-id')." and campaign_name='Discount Offer' and active=1)";

        $data=DB::select($sql);
        $catInfo=$this->getCategory();
        return view('campaign.discount',['data'=>$data,'campaign_name'=>'Discount Offer','catInfo'=>$catInfo]);

    }
    public function SellerCampaignList()
    {
        $sql="SELECT store_products.id as store_p_id,products.id as product_id,store_products.sale_price,store_products.stock,store_products.title,products.unit_mrp 
        FROM `store_products`,products
        where products.status='active' and store_products.store_enlist=1 and store_products.prod_id=products.id and store_products.store_id=".session('store-id')." and store_products.id in (SELECT store_p_id FROM `campaign` where store_id=".session('store-id')." and campaign_name='Seller Campaign' and active=1)";

        $data=DB::select($sql);
        $catInfo=$this->getCategory();
        return view('campaign.seller-campaign',['data'=>$data,'campaign_name'=>'Seller Campaign','catInfo'=>$catInfo]);

    }

    function getCategory()
    {
        $sql="SELECT id,name FROM `category` where parent_id=0 order by name";
        $catInfo=DB::select($sql);
        return $catInfo;
    }
}
