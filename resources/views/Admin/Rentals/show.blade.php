@extends('admin.layouts.master')
@section('rentals-active')
    active
@endsection
@section('style')
    <style>
        img{
            max-width: 50px;
        }
    </style>
@endsection
@section('content-title')
    {{$rental->code}}
@endsection
@section('content-btn')
<a href="#" class="d-none d-sm-inline-block back-btn btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-undo fa-sm text-white-50"></i> Back
</a>
@endsection
@section('content')
   <div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rental->rental_details as $detail)
                    <tr>
                        <td>
                            <img src="{{asset($detail->book->photo)}}" alt="">
                        </td>
                        <td>
                            {{$detail->book->title}}
                        </td>
                         <td>
                            {{$detail->book->author}}
                        </td>
                         <td>
                            {{$detail->qty}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
   </div>
@endsection

@section('script')
    
@endsection