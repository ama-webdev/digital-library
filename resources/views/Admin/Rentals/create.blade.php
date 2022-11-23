@extends('admin.layouts.master')
@section('rentals-active')
    active
@endsection
@section('style')
    <style>
        
    </style>
@endsection
@section('content-title')
    Rent
@endsection
@section('content-btn')
<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm back-btn">
    <i class="fas fa-undo fa-sm text-white-50"></i> Back
</a>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            @error('custom_error')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
           
            <form action="{{route('admin.rentals.admin-rent')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">End Date</label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" required value="{{old('end_date')}}">
                    @error('end_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Select Books ( <span class="text-danger">Only 3 books</span> )</label>
                    <select class="selectpicker form-control book-list" multiple data-live-search="true" name="books[]" data-max-options="3" required>
                        @foreach ($books as $book)
                            <option data-subtext="{{number_format($book->qty)}}" value="{{$book->id}}">{{$book->title}}</option>
                        @endforeach 
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Remark (Optional)</label>
                    <textarea class="form-control @error('remark') is-invalid @enderror" name="remark" value="{{old('remark')}}"></textarea>
                    @error('remark')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Rent</button>
                </div>
            </form>
       </div>
       
    </div>    
@endsection

@section('script')
    <script>
      $(document).ready(function() {

        
        });
    </script>
@endsection