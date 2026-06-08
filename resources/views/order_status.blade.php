<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Status') }}
        </h2>

     
        <!-- <h1>Tea</h1>
        <h1>Break</h1> -->
        
    </x-slot>
    @section('my_order')

    <table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; margin: 10px 0;">

        <thead>
            <tr style="background-color: #f2f2f2;">
                <!-- <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">ID</th> -->
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Your Name</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Your Email Details</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food Image</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food Quantity</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Order Current Status</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Action</th>
            </tr>
        </thead>
        <tbody>

            @foreach($my_order as $order)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->customer_name}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->customer_email}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><img style="width: 200px;" src="{{asset('food_img/'.$order->food_image)}}" alt="{{$order->food_image}}"></td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->food_quantity}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->food_price}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$order->order_status}}</td>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @endsection
</x-app-layout>