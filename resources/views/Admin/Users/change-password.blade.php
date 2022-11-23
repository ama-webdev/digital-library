@extends('admin.layouts.master')
@section('change-password-active')
    active
@endsection
@section('content-title')
  Change Password
@endsection
@section('style')
    <style>
       
    </style>
@endsection
@section('content-title-action')
<button class="back-btn btn btn-sm btn-primary text-capitalize fw-bold"><i class="fas fa-undo mr-2"></i>Back</button>
@endsection
@section('content')
    <div class="row justify-content-center">
       <div class="col-lg-7 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
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
    </div>
@endsection
@section('script')
<script>
    
</script>
@endsection