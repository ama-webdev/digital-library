@extends('admin.layouts.master')
@section('rentals-active')
    active
@endsection
@section('style')
    
@endsection
@section('content-title')
    Rentals
@endsection
@section('content-btn')
<a href="{{route('admin.rentals.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-hand-holding-heart fa-sm text-white-50"></i> Rent
</a>
@endsection
@section('content')
    <div class="row">
         <div class="col-lg-3 col-md-6 col-sm-12 col-12">
            @php
                // $start_date = app('request')->input('start_date');
                // $end_date = app('request')->input('end_date');
                $code = app('request')->input('code');
                $email = app('request')->input('email');
                $status = app('request')->input('status');
            @endphp
                <div class="form-group">
                    <label for="">Code</label>
                    <input type="text" class="form-control code" value="{{$code}}">
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control email" value="{{$email}}">
                </div>
            </div>
            {{-- <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="form-group">
                    <label for="">Start Date</label>
                    <input type="date" class="form-control start_date" value="{{\Carbon\Carbon::parse($start_date)->format('Y-m-d')}}">
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="form-group">
                    <label for="">End Date</label>
                    <input type="date" class="form-control end_date" value="{{\Carbon\Carbon::parse($end_date)->format('Y-m-d')}}">
                </div>
            </div> --}}
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="form-group">
                    <label for="">Status</label>
                    <select class="form-control status">
                        <option value="">Select Status</option>
                        <option value="draft" @if ($status=='draft') selected @endif>
                            DRAFT
                        </option>
                        <option value="borrow" @if ($status=='borrow') selected @endif>
                            BORROW
                        </option>
                        <option value="return" @if ($status=='return') selected @endif>
                            RETURN
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="form-group">
                    <div class="btn-group" style="margin-top: 2rem">
                        <button class="btn btn-danger form-control search">Search</button>
                    </div>
                </div>
            </div>
    </div>
    <div class="row">
       <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Code</th>
                        {{-- <th>Username</th> --}}
                        <th>Email</th>
                        {{-- <th>Start Date</th>
                        <th>End Date</th>
                        <th>Return Date</th> --}}
                        <th>Total</th>
                        <th>Status</th>
                        <th>Admin Remark</th>
                        <th>User Remark</th>
                        {{-- <th>Duration</th>
                        <th>Remain</th>
                        <th>Over</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rentals as $rental)
                    <tr>
                        <td>{{$rental->code}}</td>
                        {{-- <td>{{$rental->user->name}}</td> --}}
                        <td>{{$rental->user->email}}</td>
                        {{-- <td>{{\Carbon\Carbon::parse($rental->start_date)->format('d-m-Y')}}</td>
                        <td>{{\Carbon\Carbon::parse($rental->end_date)->format('d-m-Y')}}</td>
                        <td>{{\Carbon\Carbon::parse($rental->return_date)->format('d-m-Y')}}</td> --}}
                        <td>{{$rental->total}}</td>
                        <td class="text-uppercase">{{$rental->status}}</td>
                        <td>{{$rental->admin_remark}}</td>
                        <td>{{$rental->user_remark}}</td>
                        {{-- @php
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
                        </td> --}}
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
                var id = $(this).data('id')
                var result=confirm('Are You Sure');
                if(result){
                    $.ajax({
                        type: "POST",
                        url: "/admin/rentals/delete/"+id,
                        data: "data",
                        dataType: "json",
                        success: function (response) {
                            window.location.reload()
                        }
                    });
                }
            })
            function search(){
                // var start_date = $(".start_date").val();
                // var end_date = $(".end_date").val();
                var status = $(".status").val();
                var email = $(".email").val();
                var code = $(".code").val();

                history.pushState(null,'',`?code=${code}&email=${email}&status=${status}`);
                // window.location.reload();
            }
            $('.status').change(function (e) { 
                e.preventDefault();
                search()
                window.location.reload()
            });
            $('.code').keyup(function (e) { 
                if(e.keyCode==13){
                    search()
                    window.location.reload()
                }
            });
            $('.email').keyup(function (e) { 
                if(e.keyCode==13){
                    search()
                    window.location.reload()
                }
            });
            // $('.start_date').change(function (e) { 
            //     e.preventDefault();
            //     search()
            //     window.location.reload()
            // });
            // $('.end_date').change(function (e) { 
            //     e.preventDefault();
            //     search()
            //     window.location.reload()
            // });
            $('.search').click(function (e) { 
                e.preventDefault();
                search()
                window.location.reload()
            });
        });
    </script>
@endsection