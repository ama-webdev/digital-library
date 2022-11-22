@extends('admin.layouts.master')
@section('books-active')
    active
@endsection
@section('content-title')
  New Book
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
                    <h5 class="fw-bold">Add New Book </h5>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.books.insert')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control  @error('title') is-invalid @enderror" id="title" name="title" value="{{old('title')}}">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control  @error('author') is-invalid @enderror" id="author" name="author" value="{{old('author')}}">
                            @error('author')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="book_category" class="form-label">Book Bategory</label>
                            <select name="book_category_id" id="book_category" class="form-control @error('book_category_id') is-invalid @enderror">
                                <option value="">select book category</option>
                                @foreach ($book_categories as $book_category)
                                <option value="{{$book_category->id}}" @if (old('book_category_id')==$book_category->id)  selected @endif>{{$book_category->name}}</option>
                                @endforeach
                            </select>
                            @error('book_category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control-file  @error('photo') is-invalid @enderror" id="photo" name="photo" value="{{old('photo')}}" id="photo">
                            @error('photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <img src="{{asset('images/template/preview.jpg')}}" alt="" id="preview-image">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control  @error('description') is-invalid @enderror" id="description">
                                {{old('description')}}
                            </textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
        $('#photo').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => { 
            $('#preview-image').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
        });

        ClassicEditor
        .create( document.querySelector( '#description' ),{
             removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed','Table','BlockQuote',],
        } )
        .catch( error => {
            console.error( error );
        } );
    });
</script>
@endsection