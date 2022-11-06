@extends('admin.layouts.master')
@section('users-active')
    active
@endsection
@section('content-title')
  New User
@endsection
@section('content-btn')
<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm back-btn">
    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
</a>
@endsection
@section('content')
    <div class="row justify-content-center">
       <div class="col-lg-5 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="fw-bold">Add New User</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.users.insert')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                         <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password" name="password" value="{{old('password')}}">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control  @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" value="{{old('confirm_password')}}">
                            @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    @if ($role->name!='super-admin')
                                        <option value="{{$role->name}}" @if (old('role')==$role->name) selected @endif>{{$role->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
       </div>
    </div>
@endsection