<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;


class ProductController extends Controller
{
    //

    function ownProductFrom()
    {
        $catInfo=$this->getCategory();
        return view('product.own.form',compact('catInfo'));
    }
    function insertOwnProduct(Request $req)
    {
        
        $checkSql="SELECT * FROM `products` WHERE title='".$req->title."'";
        $checkDuplicate=DB::select($checkSql);
        if(isset($checkDuplicate[0]))
            return back()->withInput()->with('warning','Already Product Exist with this title!');

        $comonSql="INSERT INTO `products`( `title`, `description`, `barcode`, `category`, `sub_category`, `brand`, `color`, `size`, `unit_mrp`, `product_type`,`upload_from`,`status`) VALUES ('".$req->title."','".$req->description."','".$req->barcode."','".$req->category."','".$req->sub_category."','".$req->brand."','".$req->color."','".$req->size."','".$req->unit_mrp."','General','Store','pending')";

        DB::insert($comonSql);
        $product_id = DB::getPdo()->lastInsertId();
        $logSql="INSERT INTO `log`(`table_name`, `table_id`, `user_id`, `user_type`, `log_type`,`note`) VALUES ('products','".$product_id."','".session('store-id')."','Store','General Product Create','Own Product Request From Store')";
        DB::insert($logSql);

        $abl_com_amnt=($req->abl_com_amnt/100)*$req->sale_price;
        $storeSql="INSERT INTO `store_products`(`prod_id`,`title`, `store_id`, `sale_price`, `abl_com_amnt`, `stock`) VALUES ('".$product_id."','".$req->title."','".session('store-id')."','".$req->sale_price."','".$abl_com_amnt."','".$req->stock."')";
        DB::insert($storeSql);

        $store_p_id = DB::getPdo()->lastInsertId();

        $stockSql="INSERT INTO `store_stock_transec`(`store_p_id`, `stock_in`, `note`) VALUES ('".$store_p_id."','".$req->stock."','Stock by own product request')";

        DB::insert($stockSql);
      
        if($req->file('img1'))
        {
            $filename=$product_id.'-1.jpg';
            $image = $req->file('img1');
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(500, 500);
            $path = public_path('assets/images/products/'.$filename);
            $image_resize->save($path);
            $image_resize->destroy();
        }
        if($req->file('img2'))
        {
            $filename=$product_id.'-2.jpg';
            $image = $req->file('img2');
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(500, 500);
            $path = public_path('assets/images/products/'.$filename);
            $image_resize->save($path);
            $image_resize->destroy();
        }
        if($req->file('img3'))
        {
            $filename=$product_id.'-3.jpg';
            $image = $req->file('img3');
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(500, 500);
            $path = public_path('assets/images/products/'.$filename);
            $image_resize->save($path);
            $image_resize->destroy();
        }
        //testImageCopy 
        //have to upload image in admin project using like testImageCopy()

        

        return redirect('own-product-list')->with('success','Product request send successfully!');
    }
    function ownProductList()
    {
        // echo "Here";

        $sql="SELECT products.* FROM `products`,`log` where products.product_type='General' and products.upload_from='Store' and log.table_id=products.id and log.user_id='".session('store-id')."' and log.user_type='Store' and log_type='General Product Create'";

        $data=DB::select($sql);
        
        return view('product.own.list',['data'=>$data]);
    }

    function ownProductEditFrom($product_id)
    {
        $sql="SELECT products.*,store_products.id as store_p_id,store_products.sale_price,store_products.abl_com_amnt,store_products.stock FROM `products`,store_products where store_products.prod_id=products.id and products.id=".$product_id;

        $data=DB::select($sql);
        if(!isset($data[0]))
            return back()->with('success','Someting goes wrong!');
        return view('product.own.edit-form',['data'=>$data[0]]);
    }

    function editOwnProduct(Request $req)
    {
        $product_id = $req->product_id;
        $store_p_id = $req->store_p_id;

        if($req->title!=$req->old_title)
        {
            $checkSql="SELECT * FROM `products` WHERE title='".$req->title."'";
            $checkDuplicate=DB::select($checkSql);
            if(isset($checkDuplicate[0]))
                return back()->withInput()->with('warning','Already Product Exist with this title!');
        }
        
        $comonSql="UPDATE `products` SET `title`='".$req->title."',`description`='".$req->description."',`barcode`='".$req->barcode."',`category`='".$req->category."',`sub_category`='".$req->sub_category."',`color`='".$req->color."',`size`='".$req->size."',`unit_mrp`='".$req->unit_mrp."' WHERE id=".$product_id;

        // echo $comonSql;
        // die;
        DB::update($comonSql);

        $logSql="INSERT INTO `log`(`table_name`, `table_id`, `user_id`, `user_type`, `log_type`,`note`) VALUES ('products','".$product_id."','".session('store-id')."','Store','General Product Edit','Own Product Edit From Store')";
        DB::insert($logSql);
        

        $abl_com_amnt=($req->abl_com_amnt/100)*$req->sale_price;

        $storeSql="UPDATE `store_products` SET `title`='".$req->title."',`sale_price`='".$req->sale_price."',`abl_com_amnt`='".$abl_com_amnt."',`stock`='".$req->stock."' WHERE prod_id=".$product_id;
        DB::update($storeSql);


        $stockSql="UPDATE `store_stock_transec` SET `stock_in`='".$req->stock."',`note`='Stock by own product request' WHERE store_p_id=".$store_p_id;

        DB::update($stockSql);
        
        
      
        if($req->file('img1'))
        {
            
            $filename=$product_id.'-1.jpg';
            $image = $req->file('img1');
            
            $image_resize = Image::make($image->getRealPath());
            
            var_dump($image_resize);
            die;
            
            $image_resize->resize(500, 500);
            $path = public_path('assets/images/products/'.$filename);
            $image_resize->save($path);
            $image_resize->destroy();
        }
        if($req->file('img2'))
        {
            $filename=$product_id.'-2.jpg';
            $image = $req->file('img2');
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(500, 500);
            $path = public_path('assets/images/products/'.$filename);
            $image_resize->save($path);
            $image_resize->destroy();
        }
        if($req->file('img3'))
        {
            $filename=$product_id.'-3.jpg';
            $image = $req->file('img3');
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(500, 500);
            $path = public_path('assets/images/products/'.$filename);
            $image_resize->save($path);
            $image_resize->destroy();
        }
        return redirect('own-product-list')->with('success','Product edit successfully!');
    }

    //add from amardokan
    public function amarDokanProductForAdd()
    {
        $sql="SELECT products.id,products.`title`,products.`description`,products.`barcode`,products.`category`,products.`sub_category`,products.`brand`,products.`color`,products.`size`,products.`unit_mrp`,products.`product_type`,products.`upload_from`,products.`status`
            FROM `products`
            where
            products.product_type='General' and
            products.status='active' and 
            products.id not in 
                        (
                            select prod_id 
                            from store_products 
                            where 
                            store_products.store_id=".session('store-id')."
                        )
            ORDER BY products.id ASC
            limit 12";
        $data=DB::select($sql);

        $lastID=end($data)->id;
        
        $catInfo=$this->getCategory();
        return view('product.addFromAmarokan.productList',compact('data','catInfo','lastID'));
    }

    public function addFromAmarDokanLoadProduct($lastID)
    {
        # code...
        $sql="SELECT products.id,products.`title`,products.`description`,products.`barcode`,products.`category`,products.`sub_category`,products.`brand`,products.`color`,products.`size`,products.`unit_mrp`,products.`product_type`,products.`upload_from`,products.`status`
            FROM `products`
            where
            products.product_type='General' and
            products.status='active' and 
            products.id not in 
                        (
                            select prod_id 
                            from store_products 
                            where 
                            store_products.store_id=".session('store-id')."
                        ) and
            products.id>".$lastID."
                        
            ORDER BY products.id ASC
            limit 12";
        $data=DB::select($sql);

        $lastID=end($data)->id;

        return view('product.addFromAmarokan.loadProduct',compact('data','lastID'));
        
        // $catInfo=$this->getCategory();
        // return view('product.addFromAmarokan.index',compact('data','catInfo'));
    }

    function amarDokanproductDetails($product_id)
    {
        $sql="SELECT * FROM `products` where status='active' and id='".$product_id."'";
        $data=DB::select($sql);
        if(!isset($data[0]))
            return back()->with('warning','Product not found!');
        return view('product.addFromAmarokan.details-view',['data'=>$data[0]]);
    }

    function AddFromAmarDokan(Request $req)
    {
        // echo "<pre>";
        // print_r($req->input());
        // die;
        
        $product_id=$req->product_id;
        $checkSql="SELECT * FROM `store_products` WHERE prod_id=".$product_id." and store_id=".session('store-id');
        $checkAdd=DB::select($checkSql);
        if(isset($checkAdd[0]))
            return back()->with('warning','Already added in your shop');

        if($req->sale_price > $req->unit_mrp)
            return back()->with('warning','Sale price must be less than mrp');

        $abl_com_amnt=($req->abl_com_amnt/100)*$req->sale_price;
        $storeSql="INSERT INTO `store_products`(`prod_id`,`title`, `store_id`, `sale_price`, `abl_com_amnt`, `stock`) VALUES ('".$product_id."','".$req->title."','".session('store-id')."','".$req->sale_price."','".$abl_com_amnt."','".$req->stock."')";
        DB::insert($storeSql);

        $store_p_id = DB::getPdo()->lastInsertId();

        $stockSql="INSERT INTO `store_stock_transec`(`store_p_id`, `stock_in`, `note`) VALUES ('".$store_p_id."','".$req->stock."','Stock in by seller')";

        DB::insert($stockSql);

        $logSql="INSERT INTO `log`(`table_name`, `table_id`, `user_id`, `user_type`, `log_type`,`note`) VALUES ('store_products','".$store_p_id."','".session('store-id')."','Store','Add Product From Amardokan','Add product from amardokan and stock in')";
        DB::insert($logSql);

        return back()->with('success','Product added successfully!');
        
    }


    //my product list
    public function MyProductList()
    {
        $sql="SELECT store_products.id as store_p_id,products.id as product_id,store_products.sale_price,store_products.abl_com_amnt,store_products.stock,store_products.store_enlist,products.title,products.unit_mrp,products.status as product_status
        FROM `store_products`,products
        where 
        store_products.prod_id=products.id and 
        store_products.store_id=".session('store-id')."
        
        ORDER BY store_products.id DESC

        LIMIT 5
        ";

        $data=DB::select($sql);

        $dataCount=0;

        $catInfo=$this->getCategory();

        $lastID=end($data)->store_p_id;

        return view('product.myProductList.allProductList',compact('data','catInfo','lastID','dataCount'));
    }

    public function LoadProductList($lastId,$dataCount)
    {
        # code...
        $sql="SELECT store_products.id as store_p_id,products.id as product_id,store_products.sale_price,store_products.abl_com_amnt,store_products.stock,store_products.store_enlist,products.title,products.unit_mrp,products.status as product_status
        FROM `store_products`,products
        where 
        store_products.prod_id=products.id and 
        store_products.store_id=".session('store-id')." and
        store_products.id<".$lastId."

        ORDER BY store_products.id DESC
        LIMIT 5
        ";

        $data=DB::select($sql);

        $lastID=end($data)->store_p_id;

        return view('product.myProductList.productList',compact('data','lastID','dataCount'));
    }

    function enlistStoreProduct($store_p_id,$enlist)
    {
        //here enlist can be 0,1
        $updateSql="UPDATE `store_products` SET `store_enlist` = '".$enlist."' WHERE `store_products`.`id` =".$store_p_id;
        DB::update($updateSql);

        $logSql="INSERT INTO `log`(`table_name`, `table_id`, `user_id`, `user_type`, `log_type`) VALUES ('store_products','".$store_p_id."','".session('store-id')."','Store','Enlist store product')";
        DB::insert($logSql);

        return back()->with('success','Update Shop Live Product successfully!');
    }
    function storeStockUpdate(Request $req)
    {
        $store_p_id=$req->store_p_id;
        $stock=$req->stock;
        if($stock<0)
            return back()->with('warning',"Stock can't be negative!");
        
        if($req->update_type==1)
        {
            $updateStock="UPDATE `store_products` SET `stock`=stock+'".$req->stock."' where id=".$store_p_id;

            $stockSql="INSERT INTO `store_stock_transec`(`store_p_id`, `stock_in`, `note`) VALUES ('".$store_p_id."','".$req->stock."','Stock in by seller')";
        }
        else
        {
            $updateStock="UPDATE `store_products` SET `stock`=stock-'".$req->stock."' where id=".$store_p_id;

            $stockSql="INSERT INTO `store_stock_transec`(`store_p_id`, `stock_out`, `note`) VALUES ('".$store_p_id."','".$req->stock."','Stock out by seller')";
        }
            
        DB::insert($stockSql);
        $stock_id = DB::getPdo()->lastInsertId();

        DB::update($updateStock);
  
        $logSql="INSERT INTO `log`(`table_name`, `table_id`, `user_id`, `user_type`, `log_type`) VALUES ('store_stock_transec','".$stock_id."','".session('store-id')."','Store','Stock update by seller')";
        DB::insert($logSql);
        return back()->with('success','Stock update successfully!');
    }

    function editMyShopProductInfo(Request $req)
    {
        if($req->unit_mrp < $req->sale_price)
            return back()->with('warning',"Sale price can't be greater than MRP Price !");

        $abl_com_amnt=($req->abl_com_amnt/100)*$req->sale_price;

        $storeSql="Update store_products set sale_price='".$req->sale_price."', abl_com_amnt='".$abl_com_amnt."' where id=".$req->store_p_id;
        DB::update($storeSql);

        $logSql="INSERT INTO `log`(`table_name`, `table_id`, `user_id`, `user_type`, `log_type`) VALUES ('store_products','".$req->store_p_id."','".session('store-id')."','Store','Sale price and abl percentage update')";
        DB::insert($logSql);

        return back()->with('success','Edit successfully!');
    }

    public function ShopLiveProductList()
    {
        $sql="SELECT store_products.id as store_p_id,products.id as product_id,store_products.sale_price,store_products.abl_com_amnt,store_products.stock,store_products.store_enlist,store_products.title,products.unit_mrp,products.status as product_status
        FROM `store_products`,products
        where products.status='active' and store_products.store_enlist=1 and store_products.prod_id=products.id and store_products.store_id=".session('store-id');

        $data=DB::select($sql);

        $catInfo=$this->getCategory();

        return view('product.shopLiveProducts.index',['data'=>$data,'catInfo'=>$catInfo]);
    }

    function getCategory()
    {
        $sql="SELECT id,name FROM `category` where parent_id=0 order by name";
        $catInfo=DB::select($sql);
        return $catInfo;
    }
    function getSubCategory($category_name)
    {
      
        $sql="SELECT id,name FROM `category` where parent_id=(select id from category where name='".$category_name."')";
        $catInfo=DB::select($sql);
        return $catInfo;
    }
    

    function testCopyImage()
    {

        
        // $query = http_build_query($product_id);
        // $options = array(
        //     'http' => array(
        //         'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
        //                     "Content-Length: ".strlen($query)."\r\n".
        //                     "User-Agent:MyAgent/1.0\r\n",
        //         'method'  => "POST",
        //         'content' => $query,
        //     ),
        // );
        // $context = stream_context_create($options);

        $url=session('store-admin-url')."api/uploadOwnProductImg/15";
        $result = file_get_contents($url);
        print_r($result);

        // $path = 'https://i.stack.imgur.com/koFpQ.png';
        // $filename='13-1-'.rand().'.jpg';

        // // Image::make($path)->save(public_path('images/test/' . $filename));
        // $image = Image::make($path);
        // $image->resize(500, 500);
        // $path = public_path('images/test/'.$filename);
        // $image->save($path);
        // $image->destroy();
    }
    public function ChangeMRP(){
        $sql2="SELECT s2.id as product_id, s2.title,s1.ex_mrp, s1.new_mrp,s1.status
        FROM `change_mrp` as s1
        LEFT JOIN products as s2 ON s1.product_id=s2.id
        WHERE s1.user_id='".session('store-id')."'";
        $data2=DB::select($sql2);

        $catInfo=$this->getCategory();
        return view('product.own.changeMRP',['data2'=>$data2,'catInfo'=>$catInfo]);
    }

    // public function C_MRP_List(){
    //     $sql="SELECT id as product_id,title,unit_mrp,`status`
    //     FROM products
    //     where 1";

    //     $data=DB::select($sql);
    //     $catInfo=$this->getCategory();

    //     return view('product.own.changeable_MRP_List',['data'=>$data,'catInfo'=>$catInfo]);
    // }
    
    public function C_MRP_List(){
        $sql="SELECT id as product_id,title,unit_mrp,`status`
        FROM products
        where 1
        
        ORDER BY product_id ASC
        limit 8";

        $data=DB::select($sql);
        $dataCount=0;
        $lastID=end($data)->product_id;
        // dd($lastID);
        $catInfo=$this->getCategory();

        return view('product.own.lazyLoadChangeable_MRP_List',['data'=>$data,'catInfo'=>$catInfo,'lastID'=>$lastID,'dataCount'=>$dataCount]);
    }

    public function C_MRP_List_Load($lastID,$dataCount){
        $sql="SELECT id as product_id,title,unit_mrp,`status`
        FROM products
        where id > '$lastID'
        
        ORDER BY product_id ASC
        limit 4";

        $data=DB::select($sql);
        $lastID=end($data)->product_id;
        // dd($lastID);
        return view('product.own.LoadChangeable_MRP_List',['data'=>$data,'lastID'=>$lastID,'dataCount'=>$dataCount]);
    }

    public function insertNewMRP(Request $req){
        $sql="INSERT INTO `change_mrp`( `product_id`, `user_id`,`ex_mrp`, `new_mrp`) VALUES ('".$req->product_id."','".session('store-id')."','".$req->ex_mrp."','".$req->unit_price."')";
        DB::insert($sql);

        $result=DB::getPdo()->lastInsertId();

        $sql2="INSERT INTO `log`( `table_name`, `table_id`, `user_id`, `user_type`, `log_type`, `note`) VALUES ('change_mrp','$result','".session('store-id')."','Store','Change MRP','Change MRP ".$req->ex_mrp." to ".$req->unit_price."')";
        DB::insert($sql2);

        return back()->with('success','MRP Change Request Send Successfully!');
    }
}