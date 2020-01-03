@extends("ca.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('crmadmin.adminRoute') . '/roles') }}">Roles</a> :
@endsection
@section("contentheader_description", $role->$view_col)
@section("section", "Roles")
@section("section_url", url(config('crmadmin.adminRoute') . '/roles'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Role Edit : ".$role->$view_col)

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
				{!! Form::model($role, ['route' => [config('crmadmin.adminRoute') . '.roles.update', $role->id ], 'method'=>'PUT', 'id' => 'role-edit-form']) !!}
					@ca_input($module, 'name', null, null, "form-control text-uppercase", ["placeholder" => "Role Name in CAPITAL LETTERS with '_' to JOIN e.g. 'SUPER_ADMIN'"])
					@ca_input($module, 'display_name')
					@ca_input($module, 'description')
					@ca_input($module, 'parent')
					@ca_input($module, 'dept')
					<br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('crmadmin.adminRoute') . '/roles') }}">Cancel</a></button>
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
	$("#role-edit-form").validate({

	});
});
</script>
@endpush
