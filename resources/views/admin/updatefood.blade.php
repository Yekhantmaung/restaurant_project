@extends('admin.maindesign')
<base href="/public">

@section('update_food')

        @if(session('update'))
        <div class=" btn btn-success w-100  mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{session ('update')}}
        </div>
        @endif

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-lg p-4" style="width: 500px; background-color: #1e1e1e; color: #fff; border-radius: 15px;">
        <h3 class="text-center mb-4 btn btn-secondary w-100 ">Add New Food Item</h3>


        <form action="{{route('admin.postupdatefood',$food->id)}}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Food Title --}}
            <div class="form-group mb-3">
                <input type="text" name="food_name" class="form-control" value="{{$food->food_name}}">
            </div>

            {{-- Description --}}
            <div class="form-group mb-3">
                <textarea name="food_details" class="form-control" rows="4" value="{{$food->food_details}}"></textarea>
            </div>

            {{-- Price --}}
            <div class="form-group mb-3">
                <input type="number" name="food_price" class="form-control" value="{{$food->food_price}}">
            </div>

            {{-- Image --}}
            <div>
                <h3>Old Image</h3>
                <img style="width:100px;" src="{{asset('food_img/'.$food->food_image)}}" alt="">
            </div>
            {{-- Image --}}
            <div class="form-group mb-3">
                <label style="background-color: bluewhite;" for="updateimage">update image from here!.</label>
                <input type="file" name="food_image" accept="image/*" style="padding: 8px 16px;">
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-success w-100">Update Food</button>
        </form>
    </div>
</div>

@endsection()