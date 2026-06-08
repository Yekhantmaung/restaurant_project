<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Food;
use App\Models\FoodCart;
use App\Models\Orders;
use App\Models\BookTable;

class UserController extends Controller
{

    public function index () {
        $foods=Food::all();
        return view('home',compact('foods'));
    }

    public function addToCart(Request $request){
        if(Auth::check()){
        // food for food table, reqeust for form fields, cart fo FoodCart table
        $food=Food::findOrFail($request->food_id);


        $cart=new FoodCart();


        $cart->userID=Auth::id();
        $cart->food_id=$food->id;
        $cart->food_name=$food->food_name;
        $cart->food_details=$food->food_details;
        $cart->food_image=$food->food_image;
        $cart->food_quantity=$request->quantity;
        // this price is from food table
        $price=$cart->food_quantity*$food->food_price;
        $cart->food_price=$price;

        $cart->save();
        if($cart->save()){
            return redirect()->back()->with('cart_message','food added to the cart');
        }
    }
}


    public function foodCart () {
        $current_auth = Auth::id();
        $cart_food_info=FoodCart::where('userID','=',$current_auth)->get();
        return view('show_cart',compact('cart_food_info'));
    }

    public function removeCart($id){
        $remove_food = FoodCart::findOrFail($id);
        $remove_food->delete();
        return redirect()->back();
        
    }

    public function confrimOrderCart(Request $request){
    


        $current_user=Auth::id();
        $cart_food=FoodCart::where('userID','=',$current_user)->get();
        foreach($cart_food as $cart_foods){
            $single_order=new Orders();
            $single_order->customer_id=Auth::user()->id;
            $single_order->customer_name=Auth::user()->name;
            $single_order->customer_email=Auth::user()->email;
            $single_order->customer_Address=Auth::user()->address;
            $single_order->customer_phone=Auth::user()->phone;
            $single_order->food_name=$cart_foods->food_name;
            $single_order->food_image=$cart_foods->food_image;
            $single_order->food_quantity=$cart_foods->food_quantity;
            $single_order->food_price=$cart_foods->food_price;
            $single_order->save();
        }
        return redirect()->back()->with('confirm_order','Ordered Added SuccessFully.');
    }

     public function gofile () {
        return view('admin.adminfile');
    }

    public function home () {
        if(Auth::id() && Auth::user()->usertype=='admin'){
            return view('admin.dashboard');
        }
        if(Auth::id() && Auth::user()->usertype=='user'){
            return view('dashboard');
        }
    }
    public function findATable(Request $request) {
        $book = new BookTable();
        $book->Email=$request->email;
        $book->number_of_guests=$request->number_of_guests;
        $book->time=$request->time;
        $book->date=$request->date;
        $book->save();
        return redirect()->back()->with('booktable' , 'book table reqeust sent');
    }

    public function orderStatus(){
        $current_auth = Auth::id();
        $my_order = Orders::where('customer_id','=',$current_auth)->get();
        return view('order_status',compact('my_order'));
    }
    //
}