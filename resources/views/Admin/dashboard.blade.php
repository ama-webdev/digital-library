@extends('admin.layouts.master')
@section('dashboard-active')
    active
@endsection
@section('content-title')
    Dashboard
@endsection

@section('style')
<style>
    img{
        width: 80px;
    }
    .dash-card{
        width:100%;
        height: 100%;
        display: flex;
        justify-content:start;
        align-items: center;
        gap: 2rem;
        padding: 1rem;
        color:white;
        border-radius: 3px;
        text-decoration: none;
        transition: .3s ease all;
    }
    .dash-card:hover{
        color: white;
        text-decoration: none;
    }
    .dash-card-icon{
        font-size: 4rem;
    }
    .dash-card-text p{
        margin: 0;
        padding: 0;
    }
    .dash-card-text p:first-child{
        font-size: 2rem;
        font-weight: bold;
    }
</style>
@endsection

@section('content-btn')
{{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
</a> --}}
@endsection
@section('content')
<div class="row">
    <div class="col-3">
        <a href="{{route('admin.users')}}" class="dash-card bg-warning">
            <i class="fas fa-users dash-card-icon"></i>
            <div class="dash-card-text">
                <p>{{$user_count}}</p>
                <p>Users</p>
            </div>
        </a>
    </div>
    <div class="col-3">
        <a href="{{route('admin.book-categories')}}" class="dash-card bg-info">
            <i class="fas fa-list dash-card-icon"></i>
            <div class="dash-card-text">
                <p>{{$category_count}}</p>
                <p>Categoires</p>
            </div>
        </a>
    </div>
    <div class="col-3">
        <a href="{{route('admin.books')}}" class="dash-card bg-success">
            <i class="fas fa-book dash-card-icon"></i>
            <div class="dash-card-text">
                <p>{{$book_count}}</p>
                <p>Books</p>
            </div>
        </a>
    </div>
    <div class="col-3">
        <a href="{{route('admin.rentals.index')}}" class="dash-card bg-danger">
            <i class="fas fa-hand-holding-heart dash-card-icon"></i>
            <div class="dash-card-text">
                <p>{{$rental_count}}</p>
                <p>Rentals</p>
            </div>
        </a>
    </div>
</div>
<div class="row mt-5">
       <div class="col-12">
        <h4 class="my-3 mb-5">Rental Management</h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Duration</th>
                        <th>Remain</th>
                        <th>Over</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rentals as $rental)
                    <tr>
                        <td>{{$rental->code}}</td>
                        <td>{{$rental->user->name}}</td>
                        <td>{{$rental->user->email}}</td>
                        <td>{{\Carbon\Carbon::parse($rental->start_date)->format('d-m-Y')}}</td>
                        <td>{{\Carbon\Carbon::parse($rental->end_date)->format('d-m-Y')}}</td>
                        <td>{{$rental->total}}</td>
                        <td class="text-uppercase">{{$rental->status}}</td>
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
                        <td>{{$duration}}</td>
                        <td class="text-success">
                            @if ($rental->status=='borrow')
                                {{$remain}}
                            @else
                            -
                            @endif
                        </td>
                        <td class="text-danger">
                            @if ($rental->status=='borrow')
                                {{$over}}
                            @else
                            -
                            @endif
                        </td>
                         <td>
                            <a href="{{route('admin.rentals.show',$rental->id)}}" class="">
                                <i class="fas fa-info-circle text-success"></i>
                            </a>
                            @if($rental->status=='borrow' || $rental->status=='draft')
                            <a href="{{route('admin.rentals.edit',$rental->id)}}" class="">
                                <i class="fas fa-edit text-warning"></i>
                            </a>
                            @endif
                            @if($rental->status=='draft')
                            <a href="#" class="delete-btn" data-id="{{$rental->id}}">
                                <i class="fas fa-trash text-danger"></i>
                            </a>
                            <form id="delete-form" action="{{ route('admin.rentals.destroy',$rental->id) }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    {{ $rentals->links() }}
                </tbody>
            </table>
        </div>
       </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(".delete-btn").click(function(e){
                e.preventDefault();
                var parent=$(this).parent();
                $result=confirm('Are you sure?');
                if($result){
                    $(".delete-form",parent).submit();
                }
            })
        });
    </script>
@endsection