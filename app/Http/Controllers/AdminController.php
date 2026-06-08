<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Orders;
use App\Models\BookTable;

class AdminController extends Controller
{
    public function addFood () {
        return view('admin.addfood');
    }

    public function postAddFood (Request $request) {
        $food = new Food();

        $food->food_name=$request->food_name;

        $food->food_details=$request->food_details;

        $food->food_image=$request->food_image;

        if($image=$request->food_image){
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $food->food_image=$imagename;
        }

        $food->food_price=$request->food_price;

        $food->save();

        if($image=$request->food_image && $food->save()){
            $request->food_image->move('food_img',$imagename);
        }

        return redirect()->back()->with('success','Added SuccessFully.!');

    }
    public function showFood() {
        $foods = Food::all();
        return view ('admin.showfood',compact('foods'));
    }

    public function deleteFood($id) {
        $food=Food::findOrFail($id);
        $food->delete();
        return redirect()->back()->with('danger' , 'Deleted SuccessFully!.');
    }

    public function updateFood($id){
        $food=Food::findOrFail($id);
        return view('admin.updatefood' , compact('food'));
    }

    public function postUpdateFood(Request $request,$id ){
        $food=Food::findOrFail($id);

         $food->food_name=$request->food_name;

        $food->food_details=$request->food_details;

        $food->food_image=$request->food_image;

        if($image=$request->food_image){
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $food->food_image=$imagename;
        }

        $food->food_price=$request->food_price;

        $food->save();

        if($image=$request->food_image && $food->save()){
            $request->food_image->move('food_img',$imagename);
        }

        return redirect()->back()->with('update','Update SuccessFully.!');

    }

    public function viewOrders () {

        $orders=Orders::all();
        return view('admin.vieworders',compact('orders'));
    }

    public function foodStatusDelivered ($id) {
        $order = Orders::findOrFail($id);
        $order->order_status="Delivered";
        $order->save();
        return redirect()->back();
    }

        public function foodStatusCancel ($id) {
        $order = Orders::findOrFail($id);
        $order->order_status="Cancel";
         $order->save();
        return redirect()->back();
    }
    
    public function viewBookedTable(){
        $booked_tables=BookTable::all();
        return view('admin.showbookedtable' , compact('booked_tables'));
    }
}
