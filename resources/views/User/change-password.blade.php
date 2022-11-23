@extends('user.layouts.master')
@section('style')
    <style>
        .wrapper{
            min-height: 80vh;
        }
    </style>
@endsection
@section('content')
    <div class="container py-5 wrapper">
        <h3 class="text-uppercase text-center fw-500 mb-5">Change Password</h3>
        <div class="row justify-content-center">    
            <div class="col-lg-6 col-md-7 col-sm-12 col-12">
                @if(Session::has('success'))
                    <p class="text-center text-success">{{ Session::get('success') }}</p>
                @elseif(Session::has('error'))
                    <p class="text-center text-danger">{{ Session::get('error') }}</p>
                @endif
                <form action="{{route('user.change-password')}}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="old-password">Old Password</label>
                        <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" value="{{old('old_password')}}">
                        @error('old_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="new-password">New Password</label>
                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" value="{{old('new_password')}}">
                        @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" value="{{old('confirm_password')}}">
                        @error('confirm_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <button class="btn btn-primary" type="submit">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')  
<script>
    
</script>
@endsection