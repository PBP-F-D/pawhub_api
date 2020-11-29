<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Catalog;

class CatalogController extends Controller
{
    public function index(){
        $catalogs = Catalog::all();

        if(count($catalogs) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $catalogs
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],404);
    }

    public function show($id){
        $catalog = Catalog::find($id);

        if(!is_null($catalog)){
            return response([
                'message' => 'Retrieve Barang Success',
                'data' => $catalog
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
           'stok_barang' => 'required|numeric',
           'kategori_barang' => 'required',           
       ]);

       if($validate->fails())
            return response(['message' => $validate->errors()],400);

       $catalog = Catalog::create($storeData);
       return response([
        'message' => 'Add Barang Success',
        'data' => $catalog,
        ],200);
   }

   public function destroy($id){
       $catalog = Catalog::find($id);

        if(is_null($catalog)){
            return response([
                'message' => 'Barang Not Found',
                'data' => null
            ],404);
        }

        if($catalog->delete()){
            return response([
                'message' => 'Delete Barang Success',
                'data' => $catalog,
            ],200);
        }

        return response([
            'message' => 'Delete Barang Failed',
            'data' => null,
        ],400);
   }

   public function update(Request $request, $id){
       $catalog = Catalog::find($id);
       if(is_null($catalog)){
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
           'stok_barang' => 'required|numeric',
           'kategori_barang' => 'required',         
       ]);

       if($validate->fails())
            return response(['message' => $validate->errors()],400);
       
       $catalog->nama_barang = $updateData['nama_barang'];
       $catalog->harga_barang = $updateData['harga_barang'];
       $catalog->stok_barang = $updateData['stok_barang'];
       $catalog->kategori_barang = $updateData['kategori_barang'];
       $catalog->img_barang = $updateData['img_barang'];
       
       if($catalog->save()){
            return response([
                'message' => 'Update Barang Success',
                'data' => $catalog,
                ],200);
       }

       return response([
        'message' => 'Updated Barang Failed',
        'data' => null,
        ],400);
   }
}
