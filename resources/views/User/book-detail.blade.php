@extends('user.layouts.master')
@section('style')

@endsection
@section('content')
    <div class="container py-5" style="min-height: 100vh">
        <button class="back btn back-btn"><i class="fas fa-arrow-left me-3"></i>Back</button>
        <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12 col-12 text-center">
                <img src="{{$book->photo}}" alt="" style="max-width: 100%" class="mb-5">
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                <h3 class="fw-bold">{{$book->title}}</h3>
                <p class="text-muted mb-0">{{\Carbon\Carbon::parse($book->created_at)->format('D, M Y')}}</p>
                <p class="fw-bold">{{$book->author}}</p>
                <p>{!!$book->description!!}</p>
               <a href="{{$book->file}}" class="btn btn-sm btn-danger">Download</a>
            </div>
        </div>
    </div>
@endsection

@section('script')  
<script>
    
</script>
@endsection