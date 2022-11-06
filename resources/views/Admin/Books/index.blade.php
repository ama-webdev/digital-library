@extends('admin.layouts.master')
@section('books-active')
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
    Books
@endsection
@section('content-btn')
<a href="{{route('admin.books.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus fa-sm text-white-50"></i> New Book
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
                        <th>Description</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>
                                <img src="{{$book->photo}}" alt="">
                            </td>
                            <td><a href="{{$book->file}}">{{$book->title}}</a></td>
                            <td>{{$book->author}}</td>
                            <td>{!! $book->description !!}</td>
                            <td>{{$book->book_category->name}}</td>
                            <td>
                               <div class="btn-group">
                                    <a href="{{route('admin.books.edit',$book->id)}}" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="" class="btn btn-sm btn-danger delete-btn">Delete</a>
                                    <form action="{{route('admin.books.destroy',$book->id)}}" method="POST" class="d-none delete-form">
                                        @csrf
                                    </form>
                               </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$books->links()}}
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