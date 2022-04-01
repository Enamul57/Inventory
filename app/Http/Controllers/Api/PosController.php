<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model\Product;
use App\Models\Model\PosModel;
use Illuminate\Support\Facades\DB;
use App\Models\Model\Order;
class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

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
        $order = array();
        $order['customer_id'] = $request->customer_id;
        $order['due'] = $request->due;
        $order['pay'] = $request->pay;
        $order['payby'] = $request->payby;
        $order['quantity'] = $request->quantity;
        $order['subtotal'] = $request->subtotal;
        $order['total'] = $request->total;
        $order['order_date'] = date('d/m/Y');
        $order['order_month'] = date('F');
        $order['order_year'] = date('Y');
        
        $orderId=DB::table('orders')->insertGetId($order);
        
        $pos = DB::table('pos')->get();
        $orderDetails = array();
        foreach($pos as $content){
            $orderDetails['order_id'] = $orderId;
            $orderDetails['pro_id'] = $content->product_id;
            $orderDetails['quantity'] = $content->product_quantity;
            $orderDetails['subtotal'] = $content->sub_total;
            $orderDetails['product_price']= $content->product_price;
            DB::table('order_details')->insert($orderDetails);
            DB::table('products')->where('id',$content->product_id)->update(['product_quantity'=>DB::raw('product_quantity -'.$content->product_quantity)]);
        }
        DB::table('pos')->delete();
        return response()->json($orderId);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $product = DB::table('products')
                    ->where('category_id','=',$id)
                        ->get();
        return response()->json($product);
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
    }
}
