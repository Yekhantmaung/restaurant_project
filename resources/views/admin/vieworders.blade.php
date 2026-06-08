@extends('admin.maindesign')
@section('show_orders')

    <table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; margin: 10px 0;">
          @if(session('danger'))
        <div style="background-color: rgba(240, 16, 0); color: white; text-align:center;">
            {{session ('danger')}}
        </div>
        @endif 
        <thead>
            <tr style="background-color: #f2f2f2;">
                <!-- <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food ID</th> -->
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Customer_Name</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Customer_Email</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Customer_Address</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Customer_Phone</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food_Name</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food_Image</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food_Quanity</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food_Price</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Order_Status</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Action</th>
                <!-- <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Created_At</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Updated_At</th> -->
            </tr>
        </thead>
        <tbody>

             @php
                $total_price = 0;
            @endphp

            @foreach($orders as $order)
            <tr style="border-bottom: 1px solid #ddd;">
                <!-- <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->id}}</td> -->
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->customer_name}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->customer_email}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->customer_Address}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->customer_phone}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->food_name}}</td>
                
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                    <img style="width: 200px;" src="{{asset('food_img/'.$order->food_image)}}" alt="{{$order->food_image}}"></td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->food_quantity}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->food_price}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->order_status}}</td>
                <!-- <td style="border: 1px solid #ddd; padding: 8px;">{{$order->created_at}}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{$order->updated_at}}</td> -->
                <td style="border: 1px solid #ddd; padding: 8px;">
                    <a href="{{route('admin.delivered',$order->id)}}" style="color: #2196F3; text-decoration: none; padding: 4px 8px; border-radius: 4px; background-color: #e7f3ff;">Delivered</a>
                    <p><br></p>
                    <a href="{{route('admin.cancel',$order->id)}}" style="color: #f44336; text-decoration: none; padding: 4px 8px; border-radius: 4px; background-color: #ffebee;">Cancel</a>
                </td>
            </tr>

             @php 
                $total_price = $total_price + $order->food_price;
            @endphp
            @endforeach

        </tbody>
    </table>
    
    <h1>Total Price is : {{$total_price}}</h1>

@endsection