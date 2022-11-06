@extends('admin.layouts.master')
@section('users-active')
    active
@endsection
@section('content-title')
    Users
@endsection
@section('content-btn')
<a href="{{route('admin.users.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus fa-sm text-white-50"></i> New User
</a>
@endsection
@section('content')
    <div class="row">
       <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                               <div class="btn-group">
                                    <a href="{{route('admin.users.edit',$user->id)}}" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="" data-id="{{$user->id}}" class="btn btn-sm btn-danger delete-btn">Delete</a>
                                    <form action="{{route('admin.users.destroy',$user->id)}}" method="POST" class="d-none delete-form">
                                        @csrf
                                    </form>
                               </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$users->links()}}
        </div>
       </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $(".delete-btn").click(function(e){
                e.preventDefault();
                var parent=$(this).parent();
                $result=confirm('Are you sure?');
                if($result){
                    $(".delete-form",parent).submit();
                }
            })
        });
    </script>
@endsection