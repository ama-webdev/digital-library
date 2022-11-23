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
    Rental Management
@endsection
@section('content-btn')
<a href="#" class="d-none d-sm-inline-block back-btn btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-undo fa-sm text-white-50"></i> Back
</a>
@endsection
@section('content')
   <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.rentals.rent',$rental->id)}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Code</label>
                                <input type="text" disabled value="{{$rental->code}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Qty</label>
                                <input type="text" disabled value="{{$rental->total}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Status</label>
                                <input type="text" disabled value="{{$rental->status}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Duration</label>
                                <input type="text" disabled value="" class="form-control duration">
                            </div>
                        </div>
                        @php
                            $status = '';
                            if($rental->status=='draft'){
                                $status='borrow';
                            }elseif($rental->status=='borrow'){
                                $status='return';
                            }
                            
                        @endphp
                        <input type="hidden" value="{{$status}}" name="status">
                        @if ($rental->status=='borrow')
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Remain</label>
                                    <input type="text" disabled value="{{$remain}}" class="form-control ">
                                </div>
                            </div>
                            <div class="col-6">
                            <div class="form-group">
                                <label for="">Over</label>
                                <input type="text" disabled value="{{$over}}" class="form-control ">
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="">Start Date (Y-m-d) <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" value="{{\Carbon\Carbon::parse($rental->start_date)->format('Y-m-d')}}" class="form-control start_date" @if ($rental->status=='borrow') readonly @endif>
                    </div>
                    <div class="form-group">
                        <label for="">End Date (Y-m-d) <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" value="{{\Carbon\Carbon::parse($rental->end_date)->format('Y-m-d')}}" class="form-control end_date" @if ($rental->status=='borrow') readonly @endif>
                    </div>
                    <div class="form-group">
                        <label for="">Remark (Optional)</label>
                        <textarea name="remark" class="form-control" @if ($rental->status=='borrow') readonly @endif>
                            {{$rental->admin_remark}}
                        </textarea>
                    </div>
                    @if ($rental->status=='draft')
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Rent</button>
                        </div>
                    @endif
                    @if ($rental->status=='borrow')
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Return</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Qty</th>
                                @if ($rental->status=='draft')
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rental->rental_details as $item)
                                <tr>
                                    <td>
                                        <img src="{{asset($item->book->photo)}}" alt="">
                                    </td>
                                    <td>{{$item->book->title}}</td>
                                    <td>{{$item->book->author}}</td>
                                    <td><input type="number" value="{{$item->qty}}" class="form-control" style="max-width:100px;text-align:center;" disabled></td>
                                    <td>
                                        @if ($rental->status=='draft')
                                        <a href="#" class="text-danger detail-delete" data-id="{{$item->id}}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @endif
                                        <form action="{{route('admin.rental-detail.delete',$item->id)}}" class="d-none" id="detail-form"></form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.detail-delete').click(function (e) { 
                e.preventDefault();
                var id = $(this).data('id');
                var parent=$(this).parent();
                var result=confirm('Are you sure?');
                if(result == true){
                    $.ajax({
                        type: "post",
                        url: "/admin/rentals-detail/delete/"+id,
                        data: "data",
                        dataType: "json",
                        success: function (response) {
                            window.location.reload();
                        }
                    });
                }
            });
            calcDuration();
            function calcDuration(){
                var start = new Date($('.start_date').val());
                var end = new Date($('.end_date').val());
                
                var diff = new Date(end - start);
                days  = diff/1000/60/60/24 + 1
                $(".duration").val(days)
            }
            $('.start_date').change(function (e) { 
                e.preventDefault();
                calcDuration();
            });
            $('.end_date').change(function (e) { 
                e.preventDefault();
                calcDuration();
            });
        });
    </script>
@endsection