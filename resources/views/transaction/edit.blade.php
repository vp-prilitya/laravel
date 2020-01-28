@extends('layout.main')
@extends('layout.sidebar')
@extends('layout.navbar')

@section('title', 'Page-create transaction')

@section('container')
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-2 text-gray-800">Update Transaction</h1>
		<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>
        @if (session('status'))
            <script type="text/javascript">
                swal({
                    type: 'success',
                    title: 'Sukses',
                    text:  '{{ session('status') }}',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
        @endif
        <!-- DataTales Example -->
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Customer</h6>
                    </div>
                
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200">Nama Customer</th>
                                <td>{{$transaction->customer->name}}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{$transaction->customer->kota->kota}}</td>
                            </tr>
                        </table>
                    </div>
        
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="m-0 font-weight-bold text-primary">Detail Order</h6>
                            </div>
                            <div class="col-sm-6">
                                <button data-toggle="modal" data-target="#exampleModal" class="btn btn-sm btn-primary float-right">Add Order</button>
                            </div>
                        </div>
                    </div>
                
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th class="text-center">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction->detail as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->item }}</td>
                                        <td>{{ $data->qty }}</td>
                                        <td>{{ $data->price }}</td>
                                        <td class="text-right">{{ $data->total }}</td>
                                        <td class="text-center">
                                            <button onclick="showModal({{ $data->id }})" data-id="{{ $data->id }}" class="btn btn-sm btn-success btn-circle"><i class="fa fa-pen"></i></button>
                                            <form id="formDelete" action="" method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" id="btn-delete" onclick="deleteConfirmation({{ $data->id }})" class="btn btn-sm btn-circle btn-danger"><li class="fa fa-sm fa-trash"></li></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
        
                </div>
            </div>
            <a href="{{url('/transaction')}}" class="btn btn-primary">Back</a>
        </div>


        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="registration" action="/detail/add" method="POST">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{$transaction->id}}">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="item" class="form-control">
                            
                        </div>
                        <div class="form-group">
                            <label for="name">Quantity</label>
                            <input type="text" name="qty" id="qty" class="form-control">
                            
                        </div>
                        <div class="form-group">
                            <label for="name">Price</label>
                            <input type="text" name="price" id="price" class="form-control">
                            
                        </div>
                        <div class="form-group">
                            <label for="name">Total</label>
                            <input type="text" name="total" id="total" class="form-control" readonly>
                            
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </div>
            </form>
            </div>
        </div>
        
        <div class="modal fade" id="exampleModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="item" id="item_update" class="form-control">
                            
                        </div>
                        <div class="form-group">
                            <label for="name">Quantity</label>
                            <input type="text" name="qty" id="qty_update" class="form-control">
                            
                        </div>
                        <div class="form-group">
                            <label for="name">Price</label>
                            <input type="text" name="price" id="price_update" class="form-control">
                            
                        </div>
                        <div class="form-group">
                            <label for="name">Total</label>
                            <input type="text" name="total" id="total_update" class="form-control" readonly>
                            
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </div>
            </form>
            </div>
        </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#price_update').on('keyup',() => {
            let value = $('#qty_update').val();
            let price = $('#price_update').val();
            let total = value * price; 

            $('#total_update').val(total);
            
        })

        $('#qty_update').on('keyup',() => {
            let value = $('#qty_update').val();
            let price = $('#price_update').val();
            let total = value * price; 

            $('#total_update').val(total);
            
        })

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

       function showModal(id){
            $('#exampleModalEdit').modal('show');
            $('#editForm').attr('action','/detail/' + id)
            $.ajax({
                url : '{{url('/detail')}}/' + id,
                type : 'GET',
                dataType: 'json',
                success : function(data){
                    $('#item_update').val(data.item)
                    $('#qty_update').val(data.qty)
                    $('#price_update').val(data.price)
                    $('#total_update').val(data.total)

                }
            })
        }

        function deleteConfirmation(id) {
            event.preventDefault(); 
            var form = event.target.form;
            swal({
                title: "Delete?",
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $('#formDelete').attr('action', '/detail/' + id)
                    $('#formDelete').submit();
                } else {
                    e.dismiss;
                }

            }, function (dismiss) {
                return false;
            })
        }
    </script>
@endsection
