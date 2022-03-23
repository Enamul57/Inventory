<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model\Customer;
use DB;
use Image;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       $customer = DB::table('customers')->get();
       return response()->json($customer);
      
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
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            
        ]);
        $image = $request->photo;
        if($image){
            $strpos = strpos($image,';');
            $substr = substr($image,0,$strpos);
            $ext = explode('/',$substr)[1];
            $uniquename= hexdec(uniqid()).'.'.$ext;
            $imgFile = Image::make($image)->resize(300,300);
            $uploadpath= 'backend/customer/';
            $imgUrl = $uploadpath.$uniquename;
            $imgFile->save($imgUrl);

            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email= $request->email;
            $customer->phone = $request->phone;
            $customer->address= $request->address;
            $customer->image= $imgUrl;
            $customer->save();
        }else{
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email= $request->email;
            $customer->phone = $request->phone;
            $customer->address= $request->address;
            $customer->save();
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
        $customer = DB::table('customers')->where('id',$id)->first();
        return response()->json($customer);
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
       $customer =  array();
       $customer['name'] = $request->name;
       $customer['email'] = $request->email;
       $customer['phone'] = $request->phone;
       $customer['address'] = $request->address;
       $newphoto =  $request->newphoto;
       if($newphoto){
            $strpos = strpos($newphoto,';');
            $substr = substr($newphoto,0,$strpos);
            $ext = explode('/',$substr)[1];
            $uniquename = hexdec(uniqid()).'.'.$ext;
            $uploadpath= 'backend/customer/';
            $imgurl = $uploadpath.$uniquename;
            $img = Image::make($newphoto)->resize(300,300);
            $imgSave= $img->save($imgurl);
            if($imgSave){
                $findId = Customer::find($id);
                $database_photo = $findId->image;
                if($database_photo){
                unlink($database_photo);
            }
                $customer['image'] = $imgurl;
                DB::table('customers')->where('id',$id)->update($customer);
            }
       }else{
           $old_photo = $request->image;
           $customer['image'] = $old_photo;
           DB::table('customers')->where('id',$id)->update($customer);
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
        $customer = Customer::find($id);
        if($customer->image){
            unlink($customer->image);
            $customer->delete();
        }else{
            $customer->delete();
        }
    }
}
