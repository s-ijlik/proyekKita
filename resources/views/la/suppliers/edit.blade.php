@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/suppliers') }}">Supplier</a> :
@endsection
@section("contentheader_description", $supplier->$view_col)
@section("section", "Suppliers")
@section("section_url", url(config('laraadmin.adminRoute') . '/suppliers'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Suppliers Edit : ".$supplier->$view_col)

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
				{!! Form::model($supplier, ['route' => [config('laraadmin.adminRoute') . '.suppliers.update', $supplier->id ], 'method'=>'PUT', 'id' => 'supplier-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'nama')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/suppliers') }}">Cancel</a></button>
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
	$("#supplier-edit-form").validate({
		
	});
});
</script>
@endpush
