@extends('layout.main')
@extends('layout.sidebar')
@extends('layout.navbar')

@section('title', 'Page-Customers')

@section('container')
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-2 text-gray-800">Data Customers</h1>
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
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> {{__('Add')}}</button>
			<div class="table-responsive mt-3">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
				<tr>
					<th width="70px">Code</th>
					<th>Name</th>
					<th>City</th>
					<th></th>
				</tr>
				</thead>
				<tfoot>
				<tr>
					<th>Code</th>
					<th>Name</th>
					<th>City</th>
					<th></th>
				</tr>
				</tfoot>
				<tbody>
                @foreach ($customer as $data)
                    <tr>
                        <td class="text-center">{{ $data->id }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->kota->kota }}</td>
                        <td class="text-center">
                            <button onclick="showModal({{ $data->id }})" data-id="{{ $data->id }}" class="btn btn-sm btn-circle btn-primary"><li class="fa fa-sm fa-pen"></li></button>
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
                <form id="registration" action="/customer" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" placeholder="Nama Customes" id="name" class="form-control">
                        
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <select name="kota_id" class="form-control" id="">
                           @foreach ($kota as $item)
                                <option value="{{$item->id}}">{{ $item->kota }}</option>
                           @endforeach
                        </select>
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
                <h5 class="modal-title">Edit Customer</h5>
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
                        <input type="text" name="name" placeholder="Nama Customes" id="name_update" class="form-control">
                        
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <select name="kota_id" class="form-control" id="kota_update">
                            @foreach ($kota as $item)
                                <option value="{{$item->id}}">{{ $item->kota }}</option>
                            @endforeach
                        </select>
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
        $('#registration').validate({
            errorElement: "span",
            errorClass :"invalid-feedback",
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            rules: {
               name: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Please enter your name"
                }
            },
            submitHandler: function(form) {
                console.log(form)
               form.submit();
            }
        });
        
        function deleteConfirmation(id) {
            event.preventDefault(); 
            var form = event.target.form;
            console.log(form)
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
                    $('#formDelete').attr('action', '/customer/' + id)
                    $('#formDelete').submit();
                } else {
                    e.dismiss;
                }

            }, function (dismiss) {
                return false;
            })
        }

        function showModal(id){
            $('#exampleModalEdit').modal('show');
            $('#editForm').attr('action','/customer/' + id)
            $.ajax({
                url : '{{url('/customer')}}/' + id,
                type : 'GET',
                dataType: 'json',
                success : function(data){
                    console.log(data.name)
                    $('#name_update').val(data.name)
                    $('#kota_update').val(data.kota_id)

                }
            })
        }
    </script>
@endsection
