@extends('user.layouts.master')
@section('style')
   <style>
        .content{
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
<div class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-12 col-sm-12 col-12">
                <h5 class="text-muted text-center mt-3 success"></h5>
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Saved Books</h5>
                        <span><span class="item-count">0</span> Items</span>
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
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody class="cart-table-body">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('user.books')}}" class="btn text-primary">
                            <i class="fa-solid fa-left-long"></i>
                            Back To Library
                        </a>
                         <div class="btn-grup">
                            <a href="#" class="clear_cart btn btn-danger">Clear Cart</a>
                            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#borrow-box">Next</a>
                         </div>
                    </div>
                </div>
            </div>
          
        </div>
        {{-- modal --}}
        <div class="modal" tabindex="-1" id="borrow-box">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Complete the Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <ul class="cart-error"></ul>
                        
                       <div class="form-group mb-3">
                        <label for="">Remark (Optional)</label>
                        <textarea class="form-control remark"></textarea>
                       </div>
                       <div class="form-group mb-3">
                        <label for="">End date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control end-date">
                       </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary borrow-btn">Borrow</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
   <script>
    $(document).ready(function () {
        showCart()

        // plus item
        $(".cart-table-body").on('click','.plus', function () {
            var parent=$(this).parent();
            var row_id=$(".qty",parent).data('row_id');
            var count=0;
            
            var cart=JSON.parse(localStorage.getItem('cart'))
            $.each(cart, function (i, v) {
                count += v.qty;
            });
            if(count>=3){
                alert('You can save only 3 books.');
                return;
            }
            cart[row_id].qty+=1;
            localStorage.setItem('cart',JSON.stringify(cart));
            showCart();
            showCartCount()
        });

        // minus item
        $(".cart-table-body").on('click','.minus', function () {
            var parent=$(this).parent();
            var row_id=$(".qty",parent).data('row_id');

            var cart=JSON.parse(localStorage.getItem('cart'))
            if(cart[row_id].qty==1){
                var result = confirm('Are You Sure?')
                if (result) {
                    var cart=JSON.parse(localStorage.getItem('cart'))
                    cart.splice(row_id,1);
                    localStorage.setItem('cart',JSON.stringify(cart));
                    showCart();
                    showCartCount()
                }
            }else{
                cart[row_id].qty-=1;
                localStorage.setItem('cart',JSON.stringify(cart));
                showCart();
                showCartCount()
            }
        });

        // remove item
        $(".cart-table-body").on('click','.remove-item', function () {
            var result=confirm('Are You Sure?');
            if(result){
                var row_id=$(this).data('row_id');
                var cart=JSON.parse(localStorage.getItem('cart'))
                cart.splice(row_id,1);
                localStorage.setItem('cart',JSON.stringify(cart));
                showCart();
                showCartCount()
            }
            
        });

        function showCart(){
            var html=``;
            var total=0;
            var cart=JSON.parse(localStorage.getItem('cart'));
            if(cart){
                if(cart.length>0){
                    $.each(cart, function (i, v) { 
                            html+=`
                                <tr>
                                    <td>
                                        <img src="${v.photo}" alt="">
                                    </td>
                                    <td>
                                        ${v.title}
                                    </td>
                                    <td>
                                        ${v.author}
                                    </td>
                                    <td>
                                        <div class="qty-wrapper">
                                            <button class="minus"><i class="bx bx-minus"></i></button>
                                            <input type="number" class="qty" data-row_id="${i}" disabled value="${v.qty}">
                                            <button class="plus"><i class="bx bx-plus"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <i class="bx bx-trash remove-item"></i>
                                    </td>
                                </tr>
                            `;
                            total+=v.price * v.qty;
                    });
                }else{
                    html+=`
                    <tr>
                        <td colspan="8">
                            <h5 class="text-center" style="color: #555; font-weight:bold;margin-top:2rem;opacity:.5;">No Data</h5>
                        </td>
                    </tr>
                    `;
                    $(".card-footer").addClass('d-none');
                    $("thead").addClass('d-none')

                }
            }else{
                    html+=`
                    <tr>
                        <td colspan="8">
                            <h5 class="text-center" style="color: #555; font-weight:bold;margin-top:2rem;opacity:.5;">No Data</h5>
                        </td>
                    </tr>
                    `;
                $(".card-footer").addClass('d-none');
                $("thead").addClass('d-none')

            }
            $("table tbody").html(html);

        }

        // clear cart btn
        $(".clear_cart").click(function(e){
            var result=confirm('Are You sure?')
            if(result){
                clearCart();
            }
        })

        // clear cart
        function clearCart()
        {
            localStorage.removeItem('cart');
            $(".item-count").text('0');
            showCart();
        }

        // borrow
        $('.borrow-btn').click(function (e) { 
            e.preventDefault();
            var remark=$(".remark").val()
            var end_date=$(".end-date").val()
            var data=JSON.parse(localStorage.getItem('cart'));
            borrow(data,remark,end_date)
            
        });

        function borrow(data,remark,end_date)
        {
            var data={
                'books':JSON.stringify(data),
                'remark':remark,
                'end_date':end_date
            }
            $.ajax({
                type: "post",
                url: "/borrow",
                data: data,
                dataType: "json",
                success: function (response) {
                    $('#borrow-box').modal('hide')
                    $('.item-count').text('0');
                    $('.success').html(`Successfully borrowed. Your Code is <span class="rental_code text-success">${response.data.code}</span>. Confirm with the librarian.`);
                    clearCart();
                },
                error:function(response){
                    var html='';
                    var errors = response.responseJSON.errors
                    errors.forEach(e => {
                        html+=`<li class="text-danger">${e}</li>`;
                    });
                    $(".cart-error").html(html);
                }
            });
        }
    });
   </script>
@endsection