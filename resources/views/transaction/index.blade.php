@extends('layout.main')
@extends('layout.sidebar')
@extends('layout.navbar')

@section('title', 'Page-Transaction')

@section('container')
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-2 text-gray-800">Data Transaction</h1>
		<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

		<!-- DataTales Example -->
		<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
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
		<div class="card-body">
            <a href="{{url('transaction/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('Add')}}</a>
			<div class="table-responsive mt-3">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
				<tr>
                    <th width="70px">Code Transaction</th>
                    <th>Date</th>
					<th>Customer</th>
					<th>City</th>
                    <th>Order</th>
                    <th class="text-center">Total</th>
                    <th></th>
                    <th></th>
				</tr>
				</thead>
				<tfoot>
				<tr>
                    <th width="70px">Code Transaction</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>City</th>
                    <th>Order</th>
                    <th class="text-center">Total</th>
                    <th></th>
                    <th></th>
				</tr>
				</tfoot>
				<tbody>
                @foreach ($transaction as $data)
                    <tr>
                        <td class="text-center">{{ $data->id }}</td>
                        <td>{{ date('d M Y', strtotime($data->created_at)) }}</td>
                        <td>{{ $data->customer->name }}</td>
                        <td>{{ $data->customer->kota->kota }}</td>
                        <td>{{ count($data->detail) }} Orderan</td>
                        <td class="text-right">Rp. {{ number_format(array_sum($sum[$data->id])) }}</td>
                        <td class="text-center">
                            <button onclick="showModal({{ $data->id }})" data-id="{{ $data->id }}" class="btn btn-primary btn-sm">Detail Order</button>
                        </td>
                        <td class="text-center">
                            <a href="{{url('/transaction/'.$data->id.'/edit')}}" class="btn btn-success btn-circle btn-sm"><i class="fa fa-pen"></i> </a>
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

    </div>

    <div class="modal fade " id="exampleModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <a class="navbar-brand" href="#">Customer</a>                    
                </nav>
                <table class="table">
                    <tr>
                        <th>Code Transaction</th>
                        <td id="code"></td>
                        <th>Date</th>
                        <td id="date"></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td id="name"></td>
                        <th>Oder</th>
                        <td id="order"></td>
                    </tr>
                </table>
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <a class="navbar-brand" href="#">Detail Order</a>                  
                </nav>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody id="detail">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </form>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function showModal(id){
            $('#exampleModalEdit').modal('show');
            $.ajax({
                url : '{{url('/transaction')}}/' + id,
                type : 'GET',
                dataType: 'json',
                success : function(data){
                    $('#code').html(data.id)
                    $('#name').html(data.customer.name)
                    $('#date').html(data.created_at)
                    $('#order').html(data.detail.length + ' Orderan')

                    let html = '';
                    let total = 0;
                    data.detail.map((x, y) => {
                        total = total + parseInt(x.total)
                        html += `
                            <tr>
                                <td>${y + 1}</td>
                                <td>${x.item}</td>
                                <td class="text-center">${x.qty}</td>
                                <td>${x.price}</td>
                                <td class="text-right">${x.total}</td>
                            </tr>
                        `
                    })
                    html += `
                        <tr>
                            <th colspan="4">Subtotal</th>
                            <th class="text-right">${total}</th>
                        </tr>
                    `
                    $('#detail').html(html);
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
                    $('#formDelete').attr('action', '/transaction/' + id)
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

