@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/data_kontraktors') }}">Data Kontraktor</a> :
@endsection
@section("contentheader_description", $data_kontraktor->$view_col)
@section("section", "Data Kontraktors")
@section("section_url", url(config('laraadmin.adminRoute') . '/data_kontraktors'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Data Kontraktors Edit : ".$data_kontraktor->$view_col)

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
				{!! Form::model($data_kontraktor, ['route' => [config('laraadmin.adminRoute') . '.data_kontraktors.update', $data_kontraktor->id ], 'method'=>'PUT', 'id' => 'data_kontraktor-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'nama')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/data_kontraktors') }}">Cancel</a></button>
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
	$("#data_kontraktor-edit-form").validate({
		
	});
});
</script>
@endpush
