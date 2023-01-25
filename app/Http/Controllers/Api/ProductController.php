<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $per_page = 10;

        if(isset($request->per_page) && strlen($request->per_page)>0){
            $per_page = $request->per_page;
        }

        if(isset($request->keyword) && strlen($request->keyword)>0){
            $datas = Product::where('product_name', 'LIKE', "%".$request->keyword."%")
                        ->orderBy("id", "DESC")
                        ->paginate($per_page);
        }
        else{
            $datas = Product::orderBy("id", "DESC")
                        ->paginate($per_page);
        }

        return response()->json([
            'status'     => 'success',
            'results'   => $datas,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator=  Validator::make($request->all(), [
            'product_name'  => 'required|string',
            'quantity'  => 'required|integer',
            'price'  => 'required|decimal',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'     => 'error',
                'results'   => $validator->errors(),
            ]);
        }

        $data = Product::create([
            'product_name'  => $request->product_name,
            'quantity'  => $request->quantity,
            'price'  => $request->price,
        ]);

        return response()->json([
            'status'     => 'success',
            'results'   => $datas,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $status = "success";
        try{
            $decryptId = Crypt::decryptString($id);
            $result = Todo::find($decryptId);
        }
        catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            $status = "error";
            $result = null;
        }
        return response()->json(['status'=>$status, 'datas'=>$result]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $validator=  Validator::make($request->all(), [
            'product_name'  => 'required|string',
            'quantity'  => 'required|integer',
            'price'  => 'required|decimal',
        ]);

        if($validator->fails()){
            return response()->json(['status' => 'error', 'data' => $validator->errors()]);
        }

        try{
            $decryptId = Crypt::decryptString($id);
            $model = Product::find($decryptId);
            $model->product_name = $request->product_name;
            $model->quantity =  $request->quantity ;
            $model->price =  $request->price ;
            $model->save();

            return response()->json(['status' => 'success', 'data' => $model]);
        }
        catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            return response()->json(['status' => 'error', 'data' => null ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        try{
            $decryptId = Crypt::decryptString($id);
            $model = Todo::find($decryptId);
            $model->delete();
            return response()->json(['status' => 'success', 'data' => "Data success deleted" ]);
        }
        catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            return response()->json(['status' => 'error', 'data' => null ]);
        }
    }
}
