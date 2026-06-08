@extends('admin.maindesign')
@section('show_food')

    <table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; margin: 10px 0;">
          @if(session('danger'))
        <div style="background-color: rgba(240, 16, 0); color: white; text-align:center;">
            {{session ('danger')}}
        </div>
        @endif
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food ID</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food Name</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food Discription</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food Image</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Food Price</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Created_at</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Updated_at</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($foods as $food)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$food->id}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$food->food_name}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$food->food_details}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><img style="width: 200px;" src="{{asset('food_img/'.$food->food_image)}}" alt=""></td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$food->food_price}}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{$food->created_at}}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{$food->updated_at}}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">
                    <a href="{{route('admin.updatefood',$food->id)}}" style="color: #2196F3; text-decoration: none; padding: 4px 8px; border-radius: 4px; background-color: #e7f3ff;">Update</a>
                    <p><br></p>
                    <a href="{{route('admin.deletefood',$food->id)}}" onclick="return confirm('Are you Sure')" style="color: #f44336; text-decoration: none; padding: 4px 8px; border-radius: 4px; background-color: #ffebee;">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection