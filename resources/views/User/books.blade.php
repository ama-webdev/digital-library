@extends('user.layouts.master')
@section('style')
<style>
    
   .book{
        border:1px solid #ddd;
        border-radius: 3px;
        overflow: hidden
    }
    .book img{
        max-width: 100%;
        transition:.3s ease;
        max-height: 150px;
        margin: 0 auto;
        display: block;
    }
    .book img:hover{
        transform: scale(1.1)
    }
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
                    <div class="book">
                    <img src="{{asset($book->photo)}}" alt="">
                    <div class="p-3">
                        <a href="{{route('user.book-detail',$book->id)}}" class="fw-bold">{{$book->title}}</a>
                        <p style="font-size:.8rem;">{{$book->author}}</p>
                        <p class="text-danger">{{number_format($book->qty,0)}} items left.</p>

                        <div class="btn-group">
                            <a href="{{route('user.book-detail',$book->id)}}" class="btn btn-sm btn-primary">View</a>
                            @auth
                            <button data-id="{{$book->id}}" data-photo="{{$book->photo}}" data-title="{{$book->title}}" data-author="{{$book->author}}" class="btn btn-sm btn-success save-book">Save</button>
                            @endauth
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

        $('.save-book').click(function (e) { 
            e.preventDefault();
            var id=$(this).data('id')
            var photo=$(this).data('photo')
            var title=$(this).data('title')
            var author=$(this).data('author');

            var data={
                'id':id,
                'title':title,
                'photo':photo,
                'author':author,
                'qty':1
            };
            addItemToCart(data)
        });
        function addItemToCart (data) { 
            var cart=JSON.parse(localStorage.getItem('cart'));
            var flag=true;
            var count=0;
            if(cart){
                var has_product=cart.findIndex(i=> i.id==data['id']);
                $.each(cart, function (i, v) {
                    count += v.qty;
                });
                if(count>=3){
                    alert('You can save only 3 books.');
                    return;
                }
                if(has_product >= 0){
                    cart[has_product].qty++;
                }else{
                    cart.push(data);
                }
                localStorage.setItem('cart',JSON.stringify(cart));
            }else{
                localStorage.setItem('cart',JSON.stringify([data]))
            }
            showCartCount()
        }

        // remove item
            $(".cart-table-body").on('click','.remove-item', function () {
                var result=confirm('Are You Sure?');
                if (result) {
                    var row_id=$(this).data('row_id');
                    var cart=JSON.parse(localStorage.getItem('cart'))
                    cart.splice(row_id,1);
                    localStorage.setItem('cart',JSON.stringify(cart));
                    showCart();
                    showCartCount()
                }
            });
        
        // show cart count
        function showCartCount() {
            var count = 0;
            var cart = JSON.parse(localStorage.getItem('cart'));
            if (cart) {
                $.each(cart, function (i, v) {
                    count += v.qty;
                });
            }
            $(".item-count").text(count);
        }
    });
    </script>
@endsection