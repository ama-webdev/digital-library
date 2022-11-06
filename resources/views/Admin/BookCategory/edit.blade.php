@extends('admin.layouts.master')
@section('book-categories-active')
    active
@endsection
@section('content-title')
  New Book Category
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
       <div class="col-lg-5 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="fw-bold">Edit Book Category</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.book-categories.update',$book_category->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name',$book_category->name)}}">
                            @error('name')
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
@section('script')
<script>
    $(document).ready(function () {
        $('#photo').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => { 
            $('#preview-image').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
        });
    });
</script>
@endsection