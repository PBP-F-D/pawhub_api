<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Cart;

class CartController extends Controller
{
    public function index(){
        $carts = Cart::all();

        if(count($carts) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $carts
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],404);
    }

    public function show($id){
        $cart = Cart::find($id);

        if(!is_null($cart)){
            return response([
                'message' => 'Retrieve Barang Success',
                'data' => $cart
            ],200);
        }

        return response([
            'message' => 'Barang Not Found',
            'data' => null
        ],404);
    }

   public function store(Request $request) {
       $storeData = $request->all();

        if($request->hasFile('img_barang')){
            $destination_path = 'public/images/catalogs';
            $image = $request->file('img_barang');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('img_barang')->storeAs($destination_path,$image_name);
            $storeData['img_barang']=$path;
        }

       $validate = Validator::make($storeData, [
           'nama_barang' => 'required',
           'harga_barang' => 'required|numeric',
           'jmlbeli_barang' => 'required|numeric',
           'user_barang' => 'required',
           'status_barang' => 'required',
       ]);

       if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $storeData['tharga_barang']=$storeData['jmlbeli_barang']*$storeData['harga_barang'];    

       $cart = Cart::create($storeData);
       return response([
        'message' => 'Add Barang Success',
        'data' => $cart,
        ],200);
   }

   public function destroy($id){
       $cart = Cart::find($id);

        if(is_null($cart)){
            return response([
                'message' => 'Barang Not Found',
                'data' => null
            ],404);
        }

        if($cart->delete()){
            return response([
                'message' => 'Delete Barang Success',
                'data' => $cart,
            ],200);
        }

        return response([
            'message' => 'Delete Barang Failed',
            'data' => null,
        ],400);
   }

   public function update(Request $request, $id){
       $cart = Cart::find($id);
       if(is_null($cart)){
        return response([
            'message' => 'Barang Not Found',
            'data' => null
        ],404);
        }

       $updateData = $request->all();

       if($request->hasFile('img_barang')){
            $destination_path = 'public/images/catalogs';
            $image = $request->file('img_barang');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('img_barang')->storeAs($destination_path,$image_name);
            $updateData['img_barang']=$path;
        }

       $validate = Validator::make($updateData, [
            'nama_barang' => 'required',
            'harga_barang' => 'required|numeric',
            'jmlbeli_barang' => 'required|numeric',       
       ]);

       if($validate->fails())
            return response(['message' => $validate->errors()],400);
       
       $cart->nama_barang = $updateData['nama_barang'];
       $cart->harga_barang = $updateData['harga_barang'];
       $cart->jmlbeli_barang = $updateData['jmlbeli_barang'];
       $cart->tharga_barang = $updateData['harga_barang']*$updateData['jmlbeli_barang'];     
       $cart->img_barang = $updateData['img_barang'];
       
       if($cart->save()){
            return response([
                'message' => 'Update Barang Success',
                'data' => $cart,
                ],200);
       }

       return response([
        'message' => 'Updated Barang Failed',
        'data' => null,
        ],400);
   }
}
