@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/clients') }}">Client</a> :
@endsection
@section("contentheader_description", $client->$view_col)
@section("section", "Clients")
@section("section_url", url(config('laraadmin.adminRoute') . '/clients'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Clients Edit : ".$client->$view_col)

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
				{!! Form::model($client, ['route' => [config('laraadmin.adminRoute') . '.clients.update', $client->id ], 'method'=>'PUT', 'id' => 'client-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'nama')
					@la_input($module, 'alamat')
					@la_input($module, 'email')
					@la_input($module, 'no_telepon')
					@la_input($module, 'member_sejak')
					@la_input($module, 'no_KTP')
					@la_input($module, 'pekerjaan')
					@la_input($module, 'asal_instansi')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/clients') }}">Cancel</a></button>
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
	$("#client-edit-form").validate({
		
	});
});
</script>
@endpush
