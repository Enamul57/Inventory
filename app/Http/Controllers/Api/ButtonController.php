<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ButtonController extends Controller
{
    //

    public function index()
    {
        //
        $cart = DB::table('pos')->get();
        return response()->json($cart);
    }

    public function show($id)
    {
        //
        $pos = DB::table('pos')->where('product_id',$id)->first();
        $pro_quantity = DB::table('products')->where('id',$id)->first();
        if($pos && $pos->product_quantity < $pro_quantity->product_quantity ){
            DB::table('pos')->where('product_id',$id)->increment('product_quantity');
        }elseif(!$pos){
            $cart = DB::table('products')->where('id',$id)->first();
            $data = array();
            $data['product_id'] =$id;
            $data['product_name'] = $cart->product_name;
            $data['product_quantity'] = 1;
            $data['product_price'] = $cart->selling_price;
            $data['sub_total'] = $cart->selling_price;
            DB::table('pos')->insert($data);
        }else{
            return false;            
        }

    }
    public function destroy($id)
    {
        //
        $cart = DB::table('pos')->where('id',$id)->delete();
        return response()->json($cart);
    }

    public function increment($id){

        //$cart = DB::table('pos')->where('id',$id)->increment('product_quantity');
        $cart = DB::table('pos')->where('product_id',$id)->first();
        $pro_quantity = DB::table('products')->where('id',$id)->first();
        if($cart->product_quantity < $pro_quantity->product_quantity){
            DB::table('pos')->where('product_id',$id)->increment('product_quantity');
            $productId = DB::table('pos')->where('product_id',$id)->first();
            $productsTotal = $productId->product_quantity * $productId->product_price;
            Db::table('pos')->where('product_id',$id)->update(['sub_total'=>$productsTotal]);
            return response('done');
        }
        else{
            return false;
        }
        

        
    }
    public function decrement($id){
        $cart = DB::table('pos')->where('product_id',$id);
            
            DB::table('pos')->where('product_id',$id)->decrement('product_quantity');
            $productId = DB::table('pos')->where('product_id',$id)->first();
            $productsTotal = $productId->product_quantity * $productId->product_price;
            Db::table('pos')->where('product_id',$id)->update(['sub_total'=>$productsTotal]);
            return response('done');
       
        
    }
 
}
