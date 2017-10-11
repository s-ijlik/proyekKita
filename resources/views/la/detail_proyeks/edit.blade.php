@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/detail_proyeks') }}">Detail Proyek</a> :
@endsection
@section("contentheader_description", $detail_proyek->$view_col)
@section("section", "Detail Proyeks")
@section("section_url", url(config('laraadmin.adminRoute') . '/detail_proyeks'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Detail Proyeks Edit : ".$detail_proyek->$view_col)

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
				{!! Form::model($detail_proyek, ['route' => [config('laraadmin.adminRoute') . '.detail_proyeks.update', $detail_proyek->id ], 'method'=>'PUT', 'id' => 'detail_proyek-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'kamarTidur')
					@la_input($module, 'kamarMandi')
					@la_input($module, 'luasTanah')
					@la_input($module, 'luasBangunan')
					@la_input($module, 'jumlahLantai')
					@la_input($module, 'garasi')
					@la_input($module, 'harga')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/detail_proyeks') }}">Cancel</a></button>
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
	$("#detail_proyek-edit-form").validate({
		
	});
});
</script>
@endpush
