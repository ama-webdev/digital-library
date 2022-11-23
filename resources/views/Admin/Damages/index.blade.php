@extends('admin.layouts.master')
@section('damage-books-active')
    active
@endsection
@section('style')
    <style>
        img{
            width: 80px;
        }
    </style>
@endsection
@section('content-title')
    Damage Books
@endsection
@section('content-btn')
    <a href="{{route('admin.damage-books.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> New Damage
    </a>
@endsection
@section('content')
    <div class="row">
       <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Lost By</th>
                        <th>Noted by</th>
                        <th>Qty</th>
                        <th>Remark</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($damages as $damage)
                        <tr>
                            <td>
                                <img src="{{$damage->book->photo}}" alt="">
                            </td>
                            <td>{{$damage->book->title}}</td>
                            <td>{{$damage->book->author}}</td>
                            <td>{{$damage->user->name}}</td>
                            <td>{{$damage->notedBy->name}}</td>
                            <td>{{$damage->qty}}</td>
                            <td>{{$damage->remark}}</td>
                            <td>
                               {{-- <div class="btn-group"> --}}
                                    <a href="" class="btn btn-sm btn-danger delete-btn">Delete</a>
                                    <form action="{{route('admin.damage-books.destroy',$damage->id)}}" method="POST" class="d-none delete-form">
                                        @csrf
                                    </form>
                               {{-- </div> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$damages->links()}}
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