@extends('admin.maindesign')
@section('show_food')

    <table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; margin: 10px 0;">


        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Customer Email</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Number Of Guests</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Time</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($booked_tables as $booked_table)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$booked_table->Email}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$booked_table->number_of_guests}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$booked_table->time}}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{$booked_table->date}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection