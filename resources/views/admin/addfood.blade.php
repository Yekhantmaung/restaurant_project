@extends('admin.maindesign')


@section('add_food')

        @if(session('success'))
        <div class=" btn btn-success w-100  mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{session ('success')}}
        </div>
        @endif

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-lg p-4" style="width: 500px; background-color: #1e1e1e; color: #fff; border-radius: 15px;">
        <h3 class="text-center mb-4 btn btn-secondary w-100 ">Add New Food Item</h3>


        <form action="{{ route('admin.postaddfood') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Food Title --}}
            <div class="form-group mb-3">
                <input type="text" name="food_name" class="form-control" placeholder="Food Title" required>
            </div>

            {{-- Description --}}
            <div class="form-group mb-3">
                <textarea name="food_details" class="form-control" rows="4" placeholder="Description" required></textarea>
            </div>

            {{-- Price --}}
            <div class="form-group mb-3">
                <input type="number" name="food_price" class="form-control" placeholder="Price" step="0.01" required>
            </div>

            {{-- Image --}}
            <div class="form-group mb-3">
                <input type="file" name="food_image" class="form-control-file" required>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-success w-100">Add Food</button>
        </form>
    </div>
</div>

@endsection()