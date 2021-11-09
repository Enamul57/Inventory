<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Model\Product;
use Image;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = DB::table('products')
                    ->join('categories','products.category_id','=','categories.id')
                    ->join('suppliers','products.supplier_id','=','suppliers.id')
                    ->select('categories.category_name','suppliers.name','products.*')
                    ->orderBy('products.id','DESC')->get();
        ;
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validation = $request->validate([
            'product_name'=> 'required|min:2',
            'product_code'=>'required|unique:products',
            'category_id'=>'required',
            'supplier_id'=>'required',
            'buying_price' =>'required',
            'selling_price' =>'required',
            'product_quantity' =>'required',

        ]);

        $image = $request->photo;// abc/jpg;dfdsfsa
        if($image){
            $index_position = strpos($image,';');
            $substr = substr($image,0,$index_position);
            $ext = explode('/',$substr)[1];
            $uniqueName = hexdec(uniqid()).".".$ext;
            $imgFile = Image::make($image)->resize(300,300);
            $upload_path = 'backend/products/';
            $imageUrl = $upload_path.$uniqueName;
            $imgFile->save($imageUrl);
    
            $product = new Product();
            $product->product_name = $request->product_name;
            $product->product_code = $request->product_code;
            $product->category_id = $request->category_id;
            $product->supplier_id = $request->supplier_id;
            $product->root = $request->root;
            $product->buying_price = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->buying_date = $request->buying_date;
            $product->product_quantity = $request->product_quantity;
            $product->image = $imageUrl;
            $product->save();
    
        }else{
            $product = new Product();
            $product->product_name = $request->product_name;
            $product->product_code = $request->product_code;
            $product->category_id = $request->category_id;
            $product->supplier_id = $request->supplier_id;
            $product->root = $request->root;
            $product->buying_price = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->buying_date = $request->buying_date;
            $product->product_quantity = $request->product_quantity;
            $product->save();


        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $products = Product::find($id);
        return response()->json($products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $product= array();
        $product['product_name'] = $request->product_name;
        $product['product_code'] = $request->product_code;
        $product['category_id'] = $request->category_id;
        $product['supplier_id'] = $request->supplier_id;
        $product['root'] = $request->root;
        $product['buying_price'] = $request->buying_price;
        $product['selling_price'] = $request->selling_price;
        $product['buying_date'] = $request->buying_date;
        $product['product_quantity'] = $request->product_quantity;

        $imgFile = $request->newphoto;
        if($imgFile){
            $index_position = strpos($imgFile,';');
            $substr = substr($imgFile,0,$index_position);
            $ext = explode('/',$substr)[1];
            $uniqueName = hexdec(uniqid()).".".$ext;
            $img = Image::make($imgFile)->resize(300,300);
            $path = 'backend/products/';
            $imgUrl = $path.$uniqueName;
            $imgSave = $img->save($imgUrl);
                if($imgSave){
                    $product['image'] = $imgUrl;
                    $database_photo = DB::table('products')->where('id',$id)->first();
                   if($database_photo->image){
                    $old_photo = $database_photo->image;
                    unlink($old_photo);
                   }
                    
                    $user = DB::table('products')->where('id',$id)->update($product);
                }
        }else{
            $old_photo = $request->image;
            $product['image'] = $old_photo;
            $user = DB::table('products')->where('id',$id)->update($product);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $products = Product::where('id',$id)->first();
        if($products->image){
            unlink($products->image);
            $products->delete();
        }
        else{
            $products->delete();
        }
        
    }
}
