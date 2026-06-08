@extends('main')
@section('show_cart')

    <table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; margin: 10px 0;">
          @if(session('danger'))
        <div style="background-color: rgba(240, 16, 0); color: white; text-align:center;">
            {{session ('danger')}}
        </div>
        @endif
         @if(session('confirm_order'))
        <div style="background-color: rgba(7, 253, 192); color: black; text-align:center;">
            {{session ('confirm_order')}}
        </div>
        @endif
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food ID</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food Name</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food Details</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food Image</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food Quantity</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food Price</th>
                <!-- <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">created_at</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Updated_at</th> -->
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Action</th>
            </tr>
        </thead>
        <tbody>

            @php
                $total_price = 0;
            @endphp

            @foreach($cart_food_info as $user_cart_foods)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$user_cart_foods->id}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$user_cart_foods->food_name}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$user_cart_foods->food_details}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><img style="width: 200px;" src="{{asset('food_img/'.$user_cart_foods->food_image)}}" alt="{{$user_cart_foods->food_image}}"></td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$user_cart_foods->food_quantity}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$user_cart_foods->food_price}}</td>
                <!-- <td style="border: 1px solid #ddd; padding: 8px;">{{$user_cart_foods->created_at}}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{$user_cart_foods->updated_at}}</td> -->
                <td style="border: 1px solid #ddd; padding: 8px;">
<!-- 
                    <a href="{{route('admin.updatefood',$user_cart_foods->id)}}" style="color: #2196F3; text-decoration: none; padding: 4px 8px; border-radius: 4px; background-color: #e7f3ff;">Update</a>
                    <p><br></p> -->

                    <a href="{{route('delete.cart',$user_cart_foods->id)}}" onclick="return confirm('Are you Sure')" style="color: #f44336; text-decoration: none; padding: 4px 8px; border-radius: 4px; background-color: #ffebee;">Remove</a>
                </td>
            </tr>
            @php 
                $total_price = $total_price + $user_cart_foods->food_price;
            @endphp
            @endforeach
        </tbody>
    </table>
    <h1>Total Price is : {{$total_price}}</h1>

    <div>
        <form action="{{route('cart.confirm')}}" method="post">
        @csrf
            <input style="background-color: greenyellow; border-radius: 11px; padding: 10px;" type="submit" value="confirm_order">
        </form>
    </div>

@endsection