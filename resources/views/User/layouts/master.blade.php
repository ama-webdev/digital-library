<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Digital Library</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="{{asset('css/user/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/user/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/user/master.css')}}">
    @yield('style')
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
  <div class="container">
    <a class="navbar-brand" href="{{route('user.home')}}">Digital Library</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{route('user.home')}}">Home</a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="{{route('user.about')}}">About</a>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link" href="{{route('user.books')}}">Books</a>
        </li>
        <li class="nav-item">
          <a class="nav-link position-relative" href="{{route('user.show-cart')}}">Cart 
            <span class="badge text-bg-secondary item-count">0</span>
          </a>
        </li>
        @guest
        @if (Route::has('login'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @endif

        @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        @endif
    @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('user.rental-list') }}">
                  Rental List
              </a>
              <a class="dropdown-item" href="{{ route('user.show-change-password') }}">
                    Change Password
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    @endguest
      </ul>
    </div>
  </div>
</nav>
@yield('content')
<footer>
    <span>&copy;2022 All right reserved.</span>
</footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="{{asset('js/user/master.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('js/user/owl.carousel.min.js')}}"></script>
    <script>
      $(document).ready(function () {
        showCartCount();
        $(".back-btn").click(function(){
          window.history.go('-1');
        })
      });
     
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
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

    </script>
    @yield('script')
</body>
</html>