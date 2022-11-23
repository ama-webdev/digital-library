@extends('admin.layouts.master')
@section('damage-books-active')
    active
@endsection
@section('content-title')
  New Damage Book
@endsection
@section('style')
    <style>
        img{
            max-width: 200px;
            margin-top: 1rem;
        }
    </style>
@endsection
@section('content-btn')
<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm back-btn">
    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
</a>
@endsection
@section('content')
    <div class="row justify-content-center">
       <div class="col-lg-7 col-md-7 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="fw-bold">Add New Damage Book </h5>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.damage-books.insert')}}" method="POST" >
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                         <div class="form-group">
                            <label for="">Select Book </label>
                            <select class="selectpicker form-control book-list" data-live-search="true" name="book" data-max-options="1">
                                <option value="">Select Book</option>
                                @foreach ($books as $book)
                                    <option data-subtext="{{number_format($book->qty)}}" value="{{$book->id}}">{{$book->title}}</option>
                                @endforeach 
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="qty" class="form-label">Qty</label>
                            <input type="number" class="form-control  @error('qty') is-invalid @enderror" id="qty" name="qty" value="{{old('qty')}}">
                            @error('qty')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <div class="mb-3">
                            <label for="remark" class="form-label">Remark</label>
                            <textarea name="remark" class="form-control  @error('remark') is-invalid @enderror" id="remark">
                                {{old('remark')}}
                            </textarea>
                            @error('remark')
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
@section('script')
<script>
    $(document).ready(function () {
        
    });
</script>
@endsection