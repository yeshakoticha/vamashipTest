@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Add Address
					<div class="pull-right col-md-2 text-right"><a href="{{ URL::asset('addressBook') }}" class="panel-heading">Address List</a></div>
				</div>
				<div class="panel-body">

					@if(Session::has('flash_message'))
					    <div class="alert alert-success">{!! session('flash_message') !!}</div>
					@endif

					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ URL::asset('saveAddr') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Title</label>
							<div class="col-md-6">
								<select class="form-control" name="title" tabindex='1'>
									<option value="Mobile">Mobile</option>
									<option value="Home">Home</option>
									<option value="Work">Work</option>
									<option value="Main">Main</option>
									<option value="Fax">Fax</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" tabindex='2' value="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Contact</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="contact" tabindex='3' value="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Address line 1</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="add1" tabindex='4' value="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Address line 2</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="add2" tabindex='5' value="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Address line 3</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="add3" tabindex='6' value="">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Pincode</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="pincode" tabindex='7' value="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">City</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="city" tabindex='8' value="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">State</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="state" tabindex='9' value="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Country</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="country" tabindex='10' value="">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary" tabindex='11'>
									Register
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
