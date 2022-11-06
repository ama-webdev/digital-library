@extends('user.layouts.master')
@section('style')
<style>
    .item{
        height: 150px;
        background: var(--primary);
        display:flex;
        justify-content: center;
        align-items: center;
        border-radius: 3px;
    }
    .item a{
        color: var(--black);
        font-weight: 400;
    }
    .about{
        margin-top: 3rem;
    }
    .about .right{
        display: flex;
        align-items: center;
    }
    img{
        width:100%;
    }
    .book{
        border:1px solid #ddd;
        border-radius: 3px;
        overflow: hidden
    }
    .book img{
        transition:.3s ease;
    }
    .book img:hover{
        transform: scale(1.1)
    }
</style>
@endsection
@section('content')
<div class="banner">
    <div class="container">
        <div class="quote">
            <h1>A library is a hospital <br> for the mind</h1>
            <div class="input-group mt-4">
                <input type="text" class="form-control title-input" placeholder="Search by book title" aria-label="Enter book title">
                <button class="btn btn-danger search-btn" type="button">Search</button>
            </div>
        </div>
    </div>
</div>
<div class="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <img src="{{asset('images/template/reading.png')}}" alt="">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 right">
                <div>
                    <h3 class="mb-3" style="font-weight: 400">Why should we read?</h3>
                    <p>
                    Reading is good for you because it improves your focus, memory, empathy, and communication skills. It can reduce stress, improve your mental health, and help you live longer. Reading also allows you to learn new things to help you succeed in your work and relationships.
                </p>
                <a href="{{route('user.books')}}" style="border-radius: 3px;min-width:100px;" class="btn btn-danger btn-md mt-3">Read Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 right">
                <div>
                    <h3 class="mb-3" style="font-weight: 400">What is digital library?</h3>
                    <p>
                    A digital library is a collection of documents in organized electronic form, available on the Internet or on CD-ROM (compact-disk read-only memory) disks. Depending on the specific library, a user may be able to access magazine articles, books, papers, images, sound files, and videos.
                </p>
                <a href="{{route('user.books')}}" style="border-radius: 3px;min-width:100px;" class="btn btn-danger btn-md mt-3">Read Now</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <img src="{{asset('images/template/library.png')}}" alt="">
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center my-5">Top Categories</h3>
            <div class="owl-carousel owl-theme categories">
                @foreach ($categories as $category)    
                <div class="item"> 
                    <a href="{{route('user.books','cat='.$category->id)}}">{{$category->name}}</a>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-12">
            <h3 class="text-center my-5">Latest Books</h3>
            <div class="owl-carousel owl-theme books">
                @foreach($books as $book)
                <div class="book">
                    <img src="{{asset($book->photo)}}" alt="">
                    <div class="p-3">
                        <a href="{{route('user.book-detail',$book->id)}}" class="fw-bold">{{$book->title}}</a>
                        <p style="font-size:.8rem;">{{$book->author}}</p>
                        <div class="btn-group">
                            <a href="{{$book->file}}" class="btn btn-sm btn-danger"> Download</a>
                            <a href="{{route('user.book-detail',$book->id)}}" class="btn btn-sm btn-primary">view</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('.categories').owlCarousel({
                loop:true,
                margin:10,
                nav:true,
                autoplay:true,
                autoplayHoverPause:true,
                responsive:{
                    0:{
                        items:2
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:5
                    }
                }
            })
            $('.books').owlCarousel({
                loop:true,
                margin:10,
                nav:true,
                autoplay:true,
                autoplayHoverPause:true,
                responsive:{
                    0:{
                        items:2
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:4
                    }
                }
            })
        });
        $('.search-btn').click(function (e) { 
            e.preventDefault();
            var title = $('.title-input').val();
            history.pushState(null,'',`books?title=${title}`);
            window.location.reload();
        });
    </script>
@endsection