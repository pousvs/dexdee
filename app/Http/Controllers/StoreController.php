<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    //
    public function index(){
        // $store = Store::orderBy('id', 'asc')->get();
        // return $store;
        $sort = \Request::get('sort');
        $perpage = \Request::get('perpage');
        $search = \Request::get('search');

        $store = store::orderBy('id',$sort)
          ->where(
            function($query) use ($search){
                $query->where('name','LIKE',"%{$search}%")
                ->orWhere('price_buy','LIKE',"%{$search}%");
            }
        )
        ->paginate($perpage)
        ->toArray();

        return array_reverse($store);
    }
    public function edit($id){
        $store = store::find($id);
        return $store;
    }
    
   public function add(Request $request) 
   {
        try {

              $store = new Store([
                'name' => $request->name,
                'image' => $request->image,
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
            ]);

            $store->save();
            
          
            $success = true;
            $message = 'ບັນທຶກສຳເລັດ!';
            

        } catch (\Illuminate\Database\QueryException $ex) {
            //throw $th;
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];
        
        return response()->json($response);
    }
    public function update($id,Request $request){
        try {

             $store = store::find($id);

              $store->update([
                    'name' => $request->name, 
                    'image' => $request->image, 
                    'amount' => $request->amount, 
                    'price_buy' => $request->price_buy, 
                    'price_sell' => $request->price_sell, 
                ]);
            
          
            $success = true;
            $message = 'ອັບເດດສຳເລັດ!';
            

        } catch (\Illuminate\Database\QueryException $ex) {
            //throw $th;
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];
        
        return response()->json($response);
    }

    public function delete($id){
        try {

            $store = store::find($id);
            
            $store->delete();

            $success = true;
            $message = 'ລຶບສຳເລັດ!';
            

        } catch (\Illuminate\Database\QueryException $ex) {
            //throw $th;
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];
        
        return response()->json($response);
    }
    
}