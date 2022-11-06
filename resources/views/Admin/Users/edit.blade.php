@extends('admin.layouts.master')
@section('users-active')
    active
@endsection
@section('content-title')
  Edit User
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
                    <h5 class="fw-bold">Edit User</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.users.update',$user->id)}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name',$user->name)}}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email',$user->email)}}">
                            @error('email') 
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
       </div>
    </div>
@endsection