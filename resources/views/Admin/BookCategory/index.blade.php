@extends('admin.layouts.master')
@section('book-categories-active')
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
    Book Categories
@endsection
@section('content-btn')
<a href="{{route('admin.book-categories.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus fa-sm text-white-50"></i> New Category
</a>
@endsection
@section('content')
    <div class="row">
       <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($book_categories as $book_category)
                        <tr>
                            <td>{{$book_category->name}}</td>
                            <td>
                               <div class="btn-group">
                                    <a href="{{route('admin.book-categories.edit',$book_category->id)}}" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="" class="btn btn-sm btn-danger delete-btn">Delete</a>
                                    <form action="{{route('admin.book-categories.destroy',$book_category->id)}}" method="POST" class="d-none delete-form">
                                        @csrf
                                    </form>
                               </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$book_categories->links()}}
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