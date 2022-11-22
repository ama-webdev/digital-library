@extends('user.layouts.master')
@section('style')
<style>
    .wrapper{
        min-height: 80vh;
    }
    .card{
            box-shadow: var(--box-shadow)
        }
        .card img{
            width:100px;
        }
        .table{
            vertical-align: middle;
            /* border: 1px solid #ddd; */
        }
        .card-header{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 1.25rem;
        }
        .card-header h5,.card-header span{
            font-weight: bold;
            margin: 0;
            padding: 0;
        }
        .qty-wrapper{
            width: 100%;
            display: flex;
            justify-content: start;
            align-items: center;
            gap: .5rem
        }
        .qty-wrapper button{
            background:none;
            outline: none;
            border: 1px solid var(--text-color);
            padding: 0 .5rem;
            border-radius: 5px;
        }
        .qty-wrapper input[type="number"]{
            width: 70px;
            border: 1px solid var(--text-color);
            border-radius: 5px;
            text-align: center;
            outline: none;
        }
        .card-footer{
            display: flex;
            justify-content: space-between;
            align-content: center;
            padding: 1rem;
        }
        table tbody tr:last-child{
            /* border-top: 1px solid #ddd; */
        }
        table thead{
            border-bottom: 1px solid #ddd;
        }
        table thead tr.table-heading th{
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        
        .remove-item{
            font-size: 1.3rem;
            color: crimson;
            cursor: pointer;
        }
</style>
@endsection
@section('content')
    <div class="container wrapper">
        <h3 class="text-center mt-5">Your Rental Detail</h3>
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8 col-md-10 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{$rental->code}}</h5>
                        <span>
                            <button class="btn btn-secondary btn-sm back-btn">Back</button>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr class="table-heading">
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody class="cart-table-body">
                                    @foreach ($rental->rental_details as $item)
                                        <tr>
                                            <td>
                                                <img src="{{asset($item->book->photo)}}" alt="">
                                            </td>
                                            <td>
                                                {{$item->book->title}}
                                            </td>
                                            <td>                                                {{$item->book->author}}
                                            </td>
                                            <td>
                                                <div class="qty-wrapper">
                                                    <input type="number" class="qty" disabled value="{{$item->qty}}">
                                                </div>
                                            </td>
                                        </tr>     
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

       
@endsection