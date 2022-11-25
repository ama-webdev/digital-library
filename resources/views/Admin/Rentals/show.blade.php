@extends('admin.layouts.master')
@section('rentals-active')
    active
@endsection
@section('style')
    <style>
        img{
            max-width: 50px;
        }
        .detail-table td,.detail-table th{
            min-width: 100px;
            height: 40px;
        }
    </style>
@endsection
@section('content-title')
    Rental Detail
@endsection
@section('content-btn')
<a href="#" class="d-none d-sm-inline-block back-btn btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-undo fa-sm text-white-50"></i> Back
</a>
@endsection
@section('content')
   <div class="row">
    <div class="col-lg-4 my-5">
        <table class="detail-table">
            <tr>
                <th>Code</th>
                <td>{{$rental->code}}</td>
            </tr>
            <tr>
                <th>UserName</th>
                <td>{{$rental->user->name}}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{$rental->user->email}}</td>
            </tr>
            <tr>
                <th>NRC No</th>
                <td>{{$rental->user->nrc ?? '-'}}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{$rental->user->address ?? '-'}}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td class="text-uppercase">{{$rental->status}}</td>
            </tr>
            <tr>
                <th>Total</th>
                <td>{{$rental->total}} books</td>
            </tr>
        </table>
    </div>
    <div class="col-lg-4 my-5">
        <table class="detail-table">
            @php
                $end_date=\Carbon\Carbon::parse($rental->end_date);
                $start_date=\Carbon\Carbon::parse($rental->start_date);
                if($rental->end_date < now()){
                    $remain = '-'   ;
                    $over = (now()->diffInDays($end_date) + 1) .' days';
                }else{
                    $remain = (now()->diffInDays($end_date) + 1) .' days';
                    $over = '-';
                }
                $duration = ($start_date->diffInDays($end_date) + 1) .' days';
            @endphp
            <tr>
                <th>Start Date</th>
                <td>{{$rental->start_date ? \Carbon\Carbon::parse($rental->start_date)->format('d-m-Y') : '-'}}</td>
            </tr>
            <tr>
                <th>End Date</th>
                <td>{{$rental->end_date ? \Carbon\Carbon::parse($rental->end_date)->format('d-m-Y') : '-'}}</td>
            </tr>
            <tr>
                <th>Return Date</th>
                <td>{{$rental->return_date ? \Carbon\Carbon::parse($rental->return_date)->format('d-m-Y') : '-'}}</td>
            </tr>
            <tr>
                <th>Rent by</th>
                <td>{{$rental->rentaledby->name ?? '-'}}</td>
            </tr>
            <tr>
                <th>Duration</th>
                <td>{{$duration}}</td>
            </tr>
            <tr>
                <th>Remain</th>
                @if($rental->status=='borrow')
                <td>{{$remain}}</td>
                @else
                <td> - </td>
                @endif
            </tr>
            <tr>
                <th>Over</th>
                @if($rental->status=='borrow')
                <td>{{$over}}</td>
                @else
                <td> - </td>
                @endif
            </tr>
        </table>
    </div>
    <div class="col-lg-4 my-5">
        <table class="detail-table">
            <tr>
                <th>Admin Remark</th>
                <td>{{$rental->admin_remark ?? '-'}}</td>
            </tr>
            <tr>
                <th>User Remark</th>
                <td>{{$rental->user_remark ?? '-'}}</td>
            </tr>
        </table>
    </div>
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