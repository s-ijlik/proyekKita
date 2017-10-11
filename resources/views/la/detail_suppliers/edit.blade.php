@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/detail_suppliers') }}">Detail Supplier</a> :
@endsection
@section("contentheader_description", $detail_supplier->$view_col)
@section("section", "Detail Suppliers")
@section("section_url", url(config('laraadmin.adminRoute') . '/detail_suppliers'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Detail Suppliers Edit : ".$detail_supplier->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($detail_supplier, ['route' => [config('laraadmin.adminRoute') . '.detail_suppliers.update', $detail_supplier->id ], 'method'=>'PUT', 'id' => 'detail_supplier-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'namaSupplier')
					@la_input($module, 'nama_toko')
					@la_input($module, 'alamatSupplier')
					@la_input($module, 'No.Telepon')
					@la_input($module, 'emailSupplier')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/detail_suppliers') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#detail_supplier-edit-form").validate({
		
	});
});
</script>
@endpush
