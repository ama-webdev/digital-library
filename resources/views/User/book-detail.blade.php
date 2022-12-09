@extends('user.layouts.master')
@section('style')
@endsection
@section('content')
    <div class="container py-5" style="min-height: 100vh">
        <button class="back btn back-btn"><i class="fas fa-arrow-left me-3"></i>Back</button>
        <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12 col-12 text-center">
                <img src="{{ $book->photo }}" alt="" style="max-width: 100%" class="mb-5">
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                <h3 class="fw-bold">{{ $book->title }}</h3>
                <p class="text-muted">{{ $book->author }}</p>
                @if ($book->type == 'paid')
                    <p class="text-danger">{{ number_format($book->qty, 0) }} items left.</p>
                @endif

                <p>{!! $book->description !!}</p>
                @if ($book->type == 'paid')
                    <button data-id="{{ $book->id }}" data-photo="{{ $book->photo }}" data-title="{{ $book->title }}"
                        data-author="{{ $book->author }}" class="btn btn-sm btn-success save-book">Save</button>
                @else
                    <a href="{{ $book->file }}" class="btn btn-danger btn-sm">Download</a>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.save-book').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id')
                var photo = $(this).data('photo')
                var title = $(this).data('title')
                var author = $(this).data('author');

                var data = {
                    'id': id,
                    'title': title,
                    'photo': photo,
                    'author': author,
                    'qty': 1
                };
                addItemToCart(data)
            });

            function addItemToCart(data) {
                var cart = JSON.parse(localStorage.getItem('cart'));
                var flag = true;
                var count = 0;
                if (cart) {
                    var has_product = cart.findIndex(i => i.id == data['id']);
                    $.each(cart, function(i, v) {
                        count += v.qty;
                    });
                    if (count >= 3) {
                        alert('You can save only 3 books.');
                        return;
                    }
                    if (has_product >= 0) {
                        cart[has_product].qty++;
                    } else {
                        cart.push(data);
                    }
                    localStorage.setItem('cart', JSON.stringify(cart));
                } else {
                    localStorage.setItem('cart', JSON.stringify([data]))
                }
                showCartCount()
            }
        });
    </script>
@endsection
