@extends('layout.main')
@extends('layout.sidebar')
@extends('layout.navbar')

@section('title', 'Page-create transaction')

@section('container')
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-2 text-gray-800">Create Transaction</h1>
		<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

        <!-- DataTales Example -->
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Customer</h6>
                    </div>
                
                    <div class="card-body">
                        <form id="form1">
                            @csrf
                            <div class="form-group">
                                <label for="customer">Customer</label>
                                <select id="customer" class="form-control" name="customer_id" id="">
                                    @foreach ($customer as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">City</label>
                                <input type="text" id="city" class="form-control" readonly>
                            </div>
                        </form>
                    </div>
        
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Order</h6>
                    </div>
                
                    <div class="card-body">
                        <form id="formAdd">
                            @csrf
                            <div class="form-group">
                                <label for="customer">Item</label>
                                <input type="text" name="item" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Price</label>
                                <input type="text"  name="price" id="price" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Quantity</label>
                                <input type="number" name="qty" value="1" id="qty" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Total</label>
                                <input type="number" id="total" name="total" class="form-control" readonly>
                            </div>
                            <button type="button" id="add" class="btn btn-success btn-sm">Add to Order</button>
                        </form>
                    </div>
        
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Order</h6>
                    </div>
                
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th  class="text-center">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="detail">

                            </tbody>
                        </table>
                    </div>
                </div>
                <button id="btnSave" class="btn btn-primary btn-block">Save</button>
            </div>

        </div>
@endsection

@section('script')
    <script type="text/javascript">
        let details = [];

        $('#customer').change(()=>{
            let id =  $('#customer').val();
            
            $.ajax({
                url : '{{url('/customer')}}/' + id,
                type : 'GET',
                dataType: 'json',
                success : function(data){
                    $('#city').val(data.kota.kota);
                }
            })
        })

        $('#add').click(() => {
            let data = $("#formAdd").serializeArray();
            let dat = {};

            data.map( x => {
                dat[x.name] = x.value;
            })
            details.push(dat);
            // console.log(details)
            $("#formAdd").get(0).reset();
            detail();
        });

        $('#price').on('keyup',() => {
            let value = $('#qty').val();
            let price = $('#price').val();
            let total = value * price; 

            $('#total').val(total);
            
        })

        $('#qty').on('keyup',() => {
            let value = $('#qty').val();
            let price = $('#price').val();
            let total = value * price; 

            $('#total').val(total);
            
        })

        function detail(){
            let html='';
            let total = 0;
            details.map((x, y) => {
                total = total + parseInt(x.total);
                html += `<tr>
                       <td>${y + 1}</td> 
                       <td>${x.item}</td> 
                       <td class=""text-center>${x.qty}</td>  
                       <td>${x.price}</td> 
                       <td class="text-right">${x.total}</td> 
                       <td class="text-center">
                            <button onclick="deletes(${y})" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-sm"></i></button>
                        </td> 
                       </tr>`
            })

            html += `<tr>
                <td colspan="4"><b>Sub Total</b></td>
                <td class="text-right">${total}</td>
                </tr>
                `
            
            $('#detail').html(html)  

        }

        function deletes(id)
        {
            details.splice(id, 1);
            detail();
        }

        $('#btnSave').click(() => {
            let dat = $('#form1').serialize()
            $.ajax({
                url : '{{url('/transaction')}}',
                type  : 'POST',
                data : dat,
                dataType : 'json',
                success : function(data){
                    console.log(data)
                    for(let x = 0; x < details.length; x++){
                        details[x]['transaction_id'] = data.id;
                        $.ajax({
                            url : '{{url('/detail')}}',
                            type  : 'POST',
                            data : details[x],
                            dataType : 'json',
                            success : function(hasil){
                                swal({
                                    type: 'success',
                                    title: 'Sukses',
                                    text:  'Data Berhasil disimpan',
                                    showConfirmButton: false,
                                    timer: 1500
                                })

                                window.location.href = '{{url('/transaction')}}';
                            }
                        })
                    }
                }
            })
        })
    </script>
@endsection
