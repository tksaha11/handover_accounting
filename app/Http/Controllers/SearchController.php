<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    //Products
    function shopLiveProduct(Request $req)
    {

        $search_qry="";
        if($req->title!='')
            $search_qry.=" and store_products.title like '%".$req->title."%' ";
        if($req->category!=0)
            $search_qry.=" and category like '%".$req->category."%'";
        if($req->sub_category)
            $search_qry.=" and sub_category like '%".$req->sub_category."%'";

        $sql="SELECT store_products.id as store_p_id,products.id as product_id,store_products.sale_price,store_products.abl_com_amnt,store_products.stock,store_products.store_enlist,store_products.title,products.unit_mrp,products.status as product_status
        FROM `store_products`,products
        where products.status='active' and store_products.store_enlist=1 and store_products.prod_id=products.id and store_products.store_id=".session('store-id').$search_qry;

      
        $data=DB::select($sql);

        $catInfo=$this->getCategory();

        return view('product.shopLiveProducts.index',['data'=>$data,'catInfo'=>$catInfo]);
    }


    function myProductList(Request $req)
    {
        $search_qry="";
        if($req->title!='')
            $search_qry.=" and store_products.title like '%".$req->title."%' ";
        if($req->category!=0)
            $search_qry.=" and category like '%".$req->category."%'";
        if($req->sub_category!=0)
            $search_qry.=" and sub_category like '%".$req->sub_category."%'";
        if($req->status!=0)
            $search_qry.=" and products.status like '%".$req->status."%'";


        $sql="SELECT store_products.id as store_p_id,products.id as product_id,store_products.sale_price,store_products.abl_com_amnt,store_products.stock,store_products.store_enlist,products.title,products.unit_mrp,products.status as product_status
        FROM `store_products`,products
        where store_products.prod_id=products.id and store_products.store_id=".session('store-id').$search_qry;

        $data=DB::select($sql);
        $catInfo=$this->getCategory();
        return view('product.myProductList.index',['data'=>$data,'catInfo'=>$catInfo]);
    }

    function amarDokanProductForAdd(Request $req)
    {
        $search_qry="";
        if($req->title!='')
            $search_qry.=" and title like '%".$req->title."%' ";
        if($req->category!=0)
            $search_qry.=" and category like '%".$req->category."%'";
        if($req->sub_category)
            $search_qry.=" and sub_category like '%".$req->sub_category."%'";

        // $sql="SELECT * FROM `products` where product_type='B2B' and status='active'".$search_qry;
        $sql="SELECT * FROM `products` where product_type='General' and status='active'".$search_qry." and products.id not in (select prod_id from store_products where store_products.store_id=".session('store-id').")";
        $data=DB::select($sql);

        $catInfo=$this->getCategory();

        return view('product.addFromAmarokan.index',['data'=>$data,'catInfo'=>$catInfo]);
    }

    //campaign
    public function ComboOfferList(Request $req)
    {
        $search_qry="";
        if($req->title!='')
            $search_qry.=" and store_products.title like '%".$req->title."%' ";
        if($req->category!=0)
            $search_qry.=" and category like '%".$req->category."%'";
        if($req->sub_category)
            $search_qry.=" and sub_category like '%".$req->sub_category."%'";

        $sql="SELECT store_products.id as store_p_id,products.id as product_id,store_products.sale_price,store_products.stock,store_products.title,products.unit_mrp 
        FROM `store_products`,products
        where products.status='active' and store_products.store_enlist=1 and store_products.prod_id=products.id and store_products.store_id=".session('store-id')." and store_products.id in (SELECT store_p_id FROM `campaign` where store_id=".session('store-id')." and campaign_name='Special Combo Offer' and active=1)".$search_qry;

        $data=DB::select($sql);
        $catInfo=$this->getCategory();

        return view('campaign.special-combo',['data'=>$data,'campaign_name'=>'Special Combo Offer','catInfo'=>$catInfo]);
    }
    public function DiscountOfferList(Request $req)
    {
        $search_qry="";
        if($req->title!='')
            $search_qry.=" and store_products.title like '%".$req->title."%' ";
        if($req->category!=0)
            $search_qry.=" and category like '%".$req->category."%'";
        if($req->sub_category)
            $search_qry.=" and sub_category like '%".$req->sub_category."%'";

        $sql="SELECT store_products.id as store_p_id,products.id as product_id,store_products.sale_price,store_products.stock,store_products.title,products.unit_mrp 
        FROM `store_products`,products
        where products.status='active' and store_products.store_enlist=1 and store_products.prod_id=products.id and store_products.store_id=".session('store-id')." and store_products.id in (SELECT store_p_id FROM `campaign` where store_id=".session('store-id')." and campaign_name='Discount Offer' and active=1)".$search_qry;

        $data=DB::select($sql);
        $catInfo=$this->getCategory();
        return view('campaign.discount',['data'=>$data,'campaign_name'=>'Discount Offer','catInfo'=>$catInfo]);

    }

    public function SellerCampaignList(Request $req)
    {
        $search_qry="";
        if($req->title!='')
            $search_qry.=" and store_products.title like '%".$req->title."%' ";
        if($req->category!=0)
            $search_qry.=" and category like '%".$req->category."%'";
        if($req->sub_category)
            $search_qry.=" and sub_category like '%".$req->sub_category."%'";

        $sql="SELECT store_products.id as store_p_id,products.id as product_id,store_products.sale_price,store_products.stock,store_products.title,products.unit_mrp 
        FROM `store_products`,products
        where products.status='active' and store_products.store_enlist=1 and store_products.prod_id=products.id and store_products.store_id=".session('store-id')." and store_products.id in (SELECT store_p_id FROM `campaign` where store_id=".session('store-id')." and campaign_name='Seller Campaign' and active=1)".$search_qry;

        $data=DB::select($sql);
        $catInfo=$this->getCategory();
        return view('campaign.seller-campaign',['data'=>$data,'campaign_name'=>'Seller Campaign','catInfo'=>$catInfo]);

    }
    public function ReqProductList($campaign_name,Request $req)
    {
        $search_qry="";
        if($req->title!='')
            $search_qry.=" and store_products.title like '%".$req->title."%' ";
        if($req->category!=0)
            $search_qry.=" and category like '%".$req->category."%'";
        if($req->sub_category)
            $search_qry.=" and sub_category like '%".$req->sub_category."%'";

        $sql="SELECT store_products.id as store_p_id,products.id as product_id,store_products.sale_price,store_products.stock,store_products.title,products.unit_mrp 
        FROM `store_products`,products
        where products.status='active' and store_products.store_enlist=1 and store_products.prod_id=products.id and store_products.store_id=".session('store-id')." and store_products.id not in (SELECT store_p_id FROM `campaign` where store_id=".session('store-id')." and campaign_name='".$campaign_name."' and active=1)".$search_qry;

        $data=DB::select($sql);
        $catInfo=$this->getCategory();

        return view('campaign.requiredProductList.index',['data'=>$data,'campaign_name'=>$campaign_name,'catInfo'=>$catInfo]);
       
    }

    //purchase from admin
    public function NewArrival(Request $req)
    {
        $search_qry="";
        if($req->search_qry!='')
        {
            $search_qry="and (title like '%".$req->search_qry."%' or category like '%".$req->search_qry."%' or sub_category like '%".$req->search_qry."%' or description like '%".$req->search_qry."%')";
        }

        $sql="SELECT products.id,products.title,products.unit_mrp,b2b_products.id as b2b_p_id,b2b_products.seller_price FROM `products`,b2b_products where b2b_products.product_id=products.id and products.product_type='B2B' and products.status='active' and b2b_products.b2b_enlist=1 ".$search_qry." order by b2b_products.id desc limit 25";
      
        $data=DB::select($sql);
        return view('b2b.newArrival.index',['data'=>$data]);
    }

    public function AllSuppliers(Request $req)
    {
        $search_qry="";
        if($req->search_qry!='')
        {
            $search_qry="and (supp_comp_name like '%".$req->search_qry."%' or cont_person_name like '%".$req->search_qry."%' or supp_address like '%".$req->search_qry."%' or sup_country like '%".$req->search_qry."%')";
        }

        $sql="SELECT id,supp_comp_name FROM `b2b_suppliers` where active_status=1 ".$search_qry;
        $data=DB::select($sql);
        return view('b2b.supllierProduct.suplliers',['data'=>$data]);
    }

    public function supllierProduct($supplier_id,Request $req){

        $search_qry="";
        if($req->search_qry!='')
        {
            $search_qry="and (title like '%".$req->search_qry."%' or category like '%".$req->search_qry."%' or sub_category like '%".$req->search_qry."%' or description like '%".$req->search_qry."%')";
        }

        $sql="SELECT products.id,products.title,products.unit_mrp,b2b_products.id as b2b_p_id,b2b_products.seller_price FROM `products`,b2b_products where supplier_id='".$supplier_id."' and b2b_products.product_id=products.id  and products.status='active' and b2b_products.b2b_enlist=1 ".$search_qry." order by b2b_products.id ";
        $data=DB::select($sql);

        $supNameSql="select id,supp_comp_name from b2b_suppliers where id=".$supplier_id;
        $supName=DB::select($supNameSql);
        if(!isset($supName[0]))
            return back()->with('warning','Supllier not found!');
        return view('b2b.supllierProduct.products',['data'=>$data,'supName'=>$supName[0]]);
    }

    
    function getCategory()
    {
        $sql="SELECT id,name FROM `category` where parent_id=0 order by name";
        $catInfo=DB::select($sql);
        return $catInfo;
    }
    
    
    //Change MRP
    function changeMRP(Request $req){
        $search_qry="";
        if($req->title!='')
            $search_qry.=" and s2.title like '%".$req->title."%' ";
        if($req->category!=0)
            $search_qry.=" and s2.category like '%".$req->category."%'";
        if($req->sub_category!=0)
            $search_qry.=" and s2.sub_category like '%".$req->sub_category."%'";
        if($req->status!=0)
            $search_qry.=" and s1.status like '%".$req->status."%'";

            $sql2="SELECT s2.id as product_id,s2.category,s2.sub_category, s2.title,s1.ex_mrp, s1.new_mrp,s1.status
            FROM `change_mrp` as s1
            LEFT JOIN products as s2 ON s1.product_id=s2.id
            WHERE s1.user_id='".session('store-id')."'".$search_qry;
            $data2=DB::select($sql2);

            $catInfo=$this->getCategory();
            return view('product.own.changeMRP',['data2'=>$data2,'catInfo'=>$catInfo]);
    }

    
    function C_MRP_List(Request $req){
        $search_qry="";
        if($req->title!='')
            $search_qry.=" and title like '%".$req->title."%' ";
        if($req->category!=0)
            $search_qry.=" and category like '%".$req->category."%'";
        if($req->sub_category!=0)
            $search_qry.=" and sub_category like '%".$req->sub_category."%'";
        if($req->status!=0)
            $search_qry.=" and `status` like '%".$req->status."%'";

        $sql="SELECT id as product_id, category, sub_category, title, unit_mrp, `status`
        FROM products
        where 1".$search_qry;
        
        
        $data=DB::select($sql);
        //dd($data);
        $catInfo=$this->getCategory();

        return view('product.own.changeable_MRP_List',['data'=>$data,'catInfo'=>$catInfo]);
    }
}
