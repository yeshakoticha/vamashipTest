@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					<p>Welcome, {{ Auth::user()->name }}</p>

					<a href="{{ URL::asset('profile') }}" class="btn btn-primary">Manage Profile</a>
					<a href="{{ URL::asset('addressBook') }}" class="btn btn-primary">Manage Address Book</a>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
