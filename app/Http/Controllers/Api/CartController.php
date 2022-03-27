<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cart = DB::table('pos')->get();
        return response()->json($cart);
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
        $pos = DB::table('pos')->where('product_id',$id)->first();
        $pro_quantity = DB::table('products')->where('id',$id)->first();
        if($pos && $pos->product_quantity < $pro_quantity->product_quantity ){
            DB::table('pos')->where('product_id',$id)->increment('product_quantity');
            $product = DB::table('pos')->where('product_id',$id)->first();
            if($product){
                $productTotal = $product->product_quantity * $product->product_price;
            DB::table('pos')->where('product_id',$id)->update(['sub_total'=>$productTotal]);
            
            }
        }elseif(!$pos){
            $cart = DB::table('products')->where('id',$id)->first();
            $data = array();
            $data['product_id'] =$id;
            $data['product_name'] = $cart->product_name;
            $data['product_quantity'] = 1;
            $data['product_price'] = $cart->selling_price;
            $data['sub_total'] = $cart->selling_price;
            DB::table('pos')->insert($data);
            return response()->json($data);
        }else{
            return 'nothing';
        }

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
        $cart = DB::table('pos')->where('id',$id)->delete();
        return response()->json($cart);
    }

    
}
