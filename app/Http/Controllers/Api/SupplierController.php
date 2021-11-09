<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Model\Supplier;
use Image;
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $supplier = Supplier::all();
        return response()->json($supplier);

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
            'name'=> 'required|min:4',
            'email'=>'required|unique:suppliers',
            'phone'=>'required|unique:suppliers',
            'address'=>'required',
        ]);

        $image = $request->photo;// abc/jpg;dfdsfsa
        if($image){
            $index_position = strpos($image,';');
            $substr = substr($image,0,$index_position);
            $ext = explode('/',$substr)[1];
            $uniqueName = hexdec(uniqid()).".".$ext;
            $imgFile = Image::make($image)->resize(300,300);
            $upload_path = 'backend/supplier/';
            $imageUrl = $upload_path.$uniqueName;
            $imgFile->save($imageUrl);
    
            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->shopName = $request->shopName;
            $supplier->photo = $imageUrl;
            $supplier->save();
    
        }else{
            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->shopName = $request->shopName;
            $supplier->photo = $imageUrl;
            $supplier->save();
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
        $supplier =  Supplier::find($id);
        return response()->json($supplier);

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
        $supplier= array();
        $supplier['name'] = $request->name;
        $supplier['email'] = $request->email;
        $supplier['phone'] = $request->phone;
        $supplier['address'] = $request->address;
        $supplier['shopName'] = $request->shopName;

        $imgFile = $request->newphoto;
        if($imgFile){
            $index_position = strpos($imgFile,';');
            $substr = substr($imgFile,0,$index_position);
            $ext = explode('/',$substr)[1];
            $uniqueName = hexdec(uniqid()).".".$ext;
            $img = Image::make($imgFile)->resize(300,300);
            $path = 'backend/supplier/';
            $imgUrl = $path.$uniqueName;
            $imgSave = $img->save($imgUrl);
                if($imgSave){
                    $supplier['photo'] = $imgUrl;
                    $database_photo = DB::table('suppliers')->where('id',$id)->first();
                   if($database_photo->photo){
                    $old_photo = $database_photo->photo;
                    unlink($old_photo);
                   }
                    
                    $user = DB::table('suppliers')->where('id',$id)->update($supplier);
                }
        }else{
            $old_photo = $request->photo;
            $supplier['photo'] = $old_photo;
            $user = DB::table('suppliers')->where('id',$id)->update($supplier);
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
        $supplier = Supplier::find($id);
        $supplier->delete();
    }
}
