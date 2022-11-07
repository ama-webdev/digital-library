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
    <div class="col-4">
        <a href="{{route('admin.users')}}" class="dash-card bg-warning">
            <i class="fas fa-users dash-card-icon"></i>
            <div class="dash-card-text">
                <p>{{$user_count}}</p>
                <p>Users</p>
            </div>
        </a>
    </div>
    <div class="col-4">
        <a href="{{route('admin.book-categories')}}" class="dash-card bg-info">
            <i class="fas fa-list dash-card-icon"></i>
            <div class="dash-card-text">
                <p>{{$category_count}}</p>
                <p>Book Categoires</p>
            </div>
        </a>
    </div>
    <div class="col-4">
        <a href="{{route('admin.books')}}" class="dash-card bg-danger">
            <i class="fas fa-book dash-card-icon"></i>
            <div class="dash-card-text">
                <p>{{$book_count}}</p>
                <p>Books</p>
            </div>
        </a>
    </div>
</div>
<div class="row mt-5">
       <div class="col-12">
        <h4 class="my-3 mb-5">Book Management</h4>
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