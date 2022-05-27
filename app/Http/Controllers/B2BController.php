<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Image;

class B2BController extends Controller
{
    //
    public function NewArrival()
    {
        $sql="SELECT products.id,products.title,products.unit_mrp,b2b_products.id as b2b_p_id,b2b_products.seller_price FROM `products`,b2b_products where b2b_products.product_id=products.id and products.product_type='B2B' and products.status='active' and b2b_products.b2b_enlist=1  order by b2b_products.id desc limit 25";

        $data=DB::select($sql);
        return view('b2b.newArrival.index',['data'=>$data]);
    }
    function productDetails($product_id)
    {
        $sql="SELECT products.id,products.title,products.unit_mrp,products.description,b2b_products.id as b2b_p_id,b2b_products.seller_price FROM `products`,b2b_products where b2b_products.product_id=products.id and products.id=".$product_id;

        $data=DB::select($sql);
        if(!isset($data[0]))
            return back()->with('warning',"Product not found!");
        return view('b2b.productDetails',['data'=>$data[0]]);
    }

    //cart
    function addToCart(Request $req)
    {
        $delSql="DELETE FROM `b2b_carts` WHERE b2b_p_id='".$req->b2b_p_id."' and store_id='".session('store-id')."'";
        DB::delete($delSql);

        $insertSql="INSERT INTO `b2b_carts`(`store_id`, `b2b_p_id`, `qty`) VALUES ('".session('store-id')."','".$req->b2b_p_id."',$req->pQty)";

        DB::insert($insertSql);

        $this->getCartInfo();

        return back()->with('success','Added to cart successfully!');
    }

    public function showCart(){
        $sql="SELECT products.id,products.title,products.unit_mrp,b2b_products.id as b2b_p_id,b2b_products.seller_price,b2b_carts.id as b2b_cart_id,b2b_carts.qty FROM `products`,b2b_products,b2b_carts where b2b_products.product_id=products.id and b2b_carts.b2b_p_id=b2b_products.id and b2b_carts.active=1 order by b2b_carts.id desc";

        $data=DB::select($sql);

        return view('b2b.cart.index',['data'=>$data]);
    }

    function updateB2bCart(Request $req)
    {
        //type 1 increment and -1 decrement
        if($req->update_type==1)
        {
            $sql="UPDATE `b2b_carts` SET `qty`=qty+1 WHERE id='".$req->b2b_cart_id."'";
            DB::update($sql);
        }
        else if($req->update_type==-1)
        {
            $sql="UPDATE `b2b_carts` SET `qty`=qty-1 WHERE id='".$req->b2b_cart_id."'";
            DB::update($sql);
            $sql="DELETE FROM `b2b_carts` WHERE qty<=0";
            DB::delete($sql);
        }
        $this->getCartInfo();
    }
    function removeB2bCart(Request $req)
    {
        // print_r($req->input());
        $sql="DELETE FROM `b2b_carts` WHERE id=".$req->b2b_cart_id;
        DB::delete($sql);
        echo "Remove from cart!";
        $this->getCartInfo();
    }

    function getCartInfo()
    {
        $cartSql="select count(*) as cart_num from b2b_carts where store_id='".session('store-id')."' and active=1";
        $cartNum=DB::select($cartSql);
        $cartInfo['number']=$cartNum[0]->cart_num;
        session()->put('cartInfo',$cartInfo);
    }


    //order

    function confirmOrder(Request $req)
    {

        $invoice=$this->createInvoice();
        $storeSql="SELECT shop_contact,shop_address,own_name FROM `user_seller` where id=".session('store-id');
        $storeInfo=DB::select($storeSql);
        if(!isset($storeInfo[0]))
            return back()->with('warning','User not found!');

        $inoicesSql="INSERT INTO `b2b_inoices_cust`(`invoice`, `store_id`, `del_name`, `del_address`, `del_mobile`,`payment_method`,`transectionid`) VALUES ('".$invoice."','".session('store-id')."','".$storeInfo[0]->own_name."','".$storeInfo[0]->shop_address."','".$storeInfo[0]->shop_contact."','NULL','NULL')";
        DB::insert($inoicesSql);

        $orderInfoSql="SELECT b2b_carts.b2b_p_id,b2b_carts.qty,products.unit_mrp,b2b_products.seller_price,b2b_products.supplier_id FROM `b2b_carts`,`b2b_products`,`products` where b2b_carts.store_id='".session('store-id')."' and b2b_carts.active=1 and b2b_carts.b2b_p_id=b2b_products.id and b2b_products.product_id=products.id";

        $orderInfo=DB::select($orderInfoSql);

        if(!isset($orderInfo[0]))
            return back()->with('warning','Please contact with administrative!');

        $orderSqlCols="INSERT INTO `b2b_orders`(`supp_id`,`invoice`, `b2b_p_id`, `unit_mrp`, `seller_price`, `qty`,`abl_com_percentage`) VALUES ";

        $orderSqlVals="";
        foreach($orderInfo as $item)
        {
            $abl_percentage=$req->abl_comission[$item->b2b_p_id];
            $orderSqlVals.="('".$item->supplier_id."','".$invoice."','".$item->b2b_p_id."','".$item->unit_mrp."','".$item->seller_price."','".$item->qty."','".$abl_percentage."'),";
        }
        $orderSqlVals=rtrim($orderSqlVals, ",");

        $orderFullSql=$orderSqlCols.$orderSqlVals;

        DB::insert($orderFullSql);

        foreach($orderInfo as $item)
        {
            $abl_percentage=$req->abl_comission[$item->b2b_p_id];
            $abl_com_amnt=$item->seller_price*$abl_percentage;

            $sql="SELECT `products`.`id`,products.title
            FROM `products`,`b2b_products`
            WHERE
            b2b_products.id='$item->b2b_p_id' AND
            products.id=b2b_products.product_id";

            $productData=DB::select($sql);

            $sql="SELECT `id` FROM `store_products` WHERE `prod_id`='".$productData[0]->id."'";
            $storeExist=DB::select($sql);

            
            
            if(count($storeExist)==0){
                $sql="INSERT INTO `store_products`
                (`prod_id`, `title`, `store_id`, `sale_price`, `abl_com_amnt`, `stock`, `store_enlist`) 
                VALUES 
                ('".$productData[0]->id."','".$productData[0]->title."','".session('store-id')."','".$item->seller_price."','".$abl_com_amnt."','0','1')";
                DB::insert($sql);
            }
            
        }


        $removeCart="DELETE FROM `b2b_carts` WHERE store_id=".session('store-id');
        DB::delete($removeCart);
        $this->getCartInfo();

        $url="/b2border/payment/".$invoice;
        
        return redirect($url);
    }
    function createInvoice()
    {
        $invoice="AD-WH-".date('Ym').rand(9000000,10000000);
        $sql="SELECT * FROM `b2b_inoices_cust` where invoice='".$invoice."'";
        $checkDuplicate=DB::select($sql);
        if(isset($checkDuplicate[0]))
            return $this->createInvoice();
        else
            return $invoice;
    }
    public function OrderList(){
        $sql="SELECT 
                DATE_FORMAT(date_time,'%Y-%m-%d') as date_time,
                b2b_inoices_cust.status,
                b2b_inoices_cust.invoice,
                sum(qty) as tot_qty,
                sum(qty*seller_price) as tot_amt 
            FROM `b2b_orders`,`b2b_inoices_cust` 
            where 
                b2b_inoices_cust.status='paid' and
                b2b_inoices_cust.invoice=b2b_orders.invoice and 
                b2b_inoices_cust.store_id='".session('store-id')."' 
            
            group by b2b_orders.invoice
            order by date_time DESC";
            
        $data=DB::select($sql);
        return view('b2b.orderList.index',['data'=>$data]);
    }

    public function showInvoice($invoice){
        $invoiceSql="SELECT * FROM `b2b_inoices_cust` where invoice='".$invoice."'";
        $invoiceData=DB::select($invoiceSql);

        if(!isset($invoiceData[0]))
            return back()->with('warning',"Invoice can't fine");

        $orderSql="SELECT (select title from products,b2b_products where b2b_p_id=b2b_products.id and b2b_products.product_id=products.id) as title,seller_price,qty,sum(seller_price*qty) as sub_total,invoice FROM `b2b_orders` where invoice='".$invoice."'  group by b2b_p_id";


        $orderData=DB::select($orderSql);
        return view('b2b.invoice.index',['invoiceData'=>$invoiceData[0],'orderData'=>$orderData]);
    }




    public function AllSuppliers(){
        $sql="SELECT id,supp_comp_name FROM `b2b_suppliers` where active_status=1";
        $data=DB::select($sql);
        return view('b2b.supllierProduct.suplliers',['data'=>$data]);
    }

    public function supllierProduct($supplier_id){

        $sql="SELECT products.id,products.title,products.unit_mrp,b2b_products.id as b2b_p_id,b2b_products.seller_price FROM `products`,b2b_products where supplier_id='".$supplier_id."' and b2b_products.product_id=products.id  and products.status='active' and b2b_products.b2b_enlist=1 order by b2b_products.id ";
        $data=DB::select($sql);

        $supNameSql="select id,supp_comp_name from b2b_suppliers where id=".$supplier_id;
        $supName=DB::select($supNameSql);
        if(!isset($supName[0]))
            return back()->with('warning','Supllier not found!');
        return view('b2b.supllierProduct.products',['data'=>$data,'supName'=>$supName[0]]);
    }



}
