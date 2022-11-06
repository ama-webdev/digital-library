@extends('user.layouts.master')
@section('style')
<style>
    
</style>
@endsection
@section('content')
     @php
        $cat = app('request')->input('cat');
        $title = app('request')->input('title');
        $author = app('request')->input('author');
    @endphp
    <div class="container py-3" style="min-height: 100vh">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-12 my-1">         
                <input type="text" class="form-control title-input" placeholder="Enter book title" value="{{$title ?? ''}}">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-12 my-1">
                <input type="text" class="form-control author-input" placeholder="Enter author name" value="{{$author ?? ''}}">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-12 my-1">
                <select name="" id="" class="form-select cat-input">
                    <option value="">Select category</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}" @if ($cat == $category->id) selected @endif>               {{$category->name}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-12 my-1">
                <button class="btn btn-danger w-100 search-btn">Search</button>
            </div>
        </div>
        <div class="row mt-3">
            @foreach($books as $book)
                <div class="col-lg-3 col-md-6 col-sm-12 col-12 mb-3">
                    <div class="card">
                        <img src="{{asset($book->photo)}}" class="card-img-top" alt="..." style="max-height:200px">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{$book->title}}</h5>
                            <p class="text-muted mb-0">{{\Carbon\Carbon::parse($book->created_at)->format('D, M Y')}}</p>
                            <p class="fw-bold">{{$book->author}}</p>
                            <div class="btn-group">
                                <a href="{{asset($book->file)}}" class="btn btn-danger btn-sm">Download</a>
                                <a href="{{route('user.book-detail',[$book->id])}}" class="btn btn-primary btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{$books->links()}}
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
        $('.search-btn').click(function (e) { 
            e.preventDefault();
            var title = $('.title-input').val();
            var author = $('.author-input').val();
            var cat = $('.cat-input').val();
            history.pushState(null,'',`?cat=${cat}&title=${title}&author=${author}`);
            window.location.reload();
        });
    });
    </script>
@endsection