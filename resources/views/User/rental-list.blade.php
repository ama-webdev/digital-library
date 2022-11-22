@extends('user.layouts.master')
@section('style')
<style>
    .wrapper{
        min-height: 80vh;
    }
</style>
@endsection
@section('content')
    <div class="container wrapper">
        <h3 class="text-center mt-3">Your Rental List</h3>
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8 col-md-10 col-sm-12 col-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Draft</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Borrow</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Return</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Code</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    @foreach ($rentals as $rental)
                                        @if($rental->status=='draft')
                                            <tr>
                                                <td>{{$rental->code}}</td>
                                                <td>
                                                    {{\Carbon\Carbon::parse($rental->start_date)->format('d-m-Y')}}
                                                </td>
                                                <td>
                                                    {{\Carbon\Carbon::parse($rental->end_date)->format('d-m-Y')}}
                                                </td>
                                                <td>{{$rental->total}}</td>
                                                <td class="text-uppercase">{{$rental->status}}</td>
                                                <td>
                                                    <a href="{{route('user.rental-detail',$rental->id)}}" class="">
                                                        <i class="bx bxs-info-circle text-success"></i>
                                                    </a>
                                                    @if($rental->status=='draft')
                                                    <a href="#" class="delete-btn">
                                                        <i class="bx bxs-trash text-danger"></i>
                                                        <form id="delete-form" action="{{ route('user.rental-delete',$rental->id) }}" method="POST" class="d-none">
                                                            @csrf
                                                        </form>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <div class="table-responsive">
                            <table class="table ">
                                <tr>
                                    <th>Code</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Duration</th>
                                    <th>Remain</th>
                                    <th>Over</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    @foreach ($rentals as $rental)
                                        @if($rental->status=='borrow')
                                            <tr>
                                                <td>{{$rental->code}}</td>
                                                <td>
                                                    {{\Carbon\Carbon::parse($rental->start_date)->format('d-m-Y')}}
                                                </td>
                                                <td>
                                                    {{\Carbon\Carbon::parse($rental->end_date)->format('d-m-Y')}}
                                                </td>
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
                                                <td class="text-success">{{$remain}}</td>
                                                <td class="text-danger">{{$over}}</td>
                                                <td>
                                                    <a href="{{route('user.rental-detail',$rental->id)}}" class="">
                                                        <i class="bx bxs-info-circle text-success"></i>
                                                    </a>
                                                    @if($rental->status=='draft')
                                                    <a href="" class="">
                                                        <i class="bx bxs-trash text-danger"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                        <div class="table-responsive">
                            <table class="table ">
                                <tr>
                                    <th>Code</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Return Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    @foreach ($rentals as $rental)
                                        @if($rental->status=='return')
                                            <tr>
                                                <td>{{$rental->code}}</td>
                                                <td>
                                                    {{\Carbon\Carbon::parse($rental->start_date)->format('d-m-Y')}}
                                                </td>
                                                <td>
                                                    {{\Carbon\Carbon::parse($rental->end_date)->format('d-m-Y')}}
                                                </td>
                                                <td>
                                                    {{\Carbon\Carbon::parse($rental->return_date)->format('d-m-Y')}}
                                                </td>
                                                <td>{{$rental->total}}</td>
                                                <td class="text-uppercase">{{$rental->status}}</td>
                                               
                                                <td>
                                                    <a href="{{route('user.rental-detail',$rental->id)}}" class="">
                                                        <i class="bx bxs-info-circle text-success"></i>
                                                    </a>
                                                    @if($rental->status=='draft')
                                                    <a href="" class="">
                                                        <i class="bx bxs-trash text-danger"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $('.delete-btn').click(function (e) { 
            e.preventDefault();
            var parent=$(this).parent;
            var result= confirm('Are You Sure?');
            if(result){
                $("#delete-form").submit();
            }
        });
    });
</script>
       
@endsection