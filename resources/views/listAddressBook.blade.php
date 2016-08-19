@extends('app')
@section('css')
<style>
	body {
		margin: 0;
		padding: 20px 0;
		width: 100%;
		height: 10%;
		display: table;
		color: #171010;
		font-weight: 100;
		font-family: 'Lato';
	}

	.container {
		text-align: center;
		display: table-cell;
		vertical-align: middle;
	}

	.content {
		text-align: center;
		display: inline-block;
	}

	.title {
		font-size: 20px;
		margin-bottom: 40px;
		color: #000;
	}

	.quote {
		font-size: 24px;
	}

	table th{
		padding: 20px;
		color: #171010;
	}
</style>

@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<div class="panel panel-default">
			  <div class="panel-heading">Address Book List
			  	 <div class="pull-right col-md-2 text-right"><a href="{{ URL::asset('addAddress') }}" class="panel-heading">Add Address</a></div>
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
				<table class="table">
					<thead class="flip-content">
						<tr>
							<th>ID</th>
							<th>Title </th>
							<th>Name </th>
							<th>Contact </th>
							<th>Address </th>
							<th>Pincode </th>
							<th>City </th>
							<th>State </th>
							<th>Country </th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($addr as $value)
						<tr>
							<td>
								 {{ $value->id}}
							</td>
							<td>
								 {{ $value->title}}
							</td>
							<td>
								 {{ $value->name}}
							</td>
							<td>
								{{ $value->contact }}
							</td>
							<td>
								{{ $value->add1 }}&nbsp;
								{{ $value->add2 }}&nbsp;
								{{ $value->add3 }}
							</td>
							<td>
								{{ $value->pincode }}
							</td>
							<td>
								{{ $value->city }}
							</td>
							<td>
								{{ $value->state }}
							</td>
							<td>
								{{ $value->country }}
							</td>
							<td class="numeric">
								<a href="{{URL::asset('editAddr')}}/{{ $value->id}}" class="btn default btn-xs purple">
									Edit&nbsp;
								</a>|
								<a href="{{URL::asset('deleteAddr')}}/{{ $value->id}}" class="btn default btn-xs purple">
									Delete&nbsp;
								</a>|
								

								@if($value->default_from==0)
								<a href="{{URL::asset('defaultFrom')}}/{{ $value->id}}" class="btn default btn-xs purple">
									Default From&nbsp;
								</a>|
								@else
								<span style="font-size:12px;">&nbsp;Default From&nbsp;|</span>
								@endif

								@if($value->default_to==0)
								<a href="{{URL::asset('defaultTo')}}/{{ $value->id}}" class="btn default btn-xs purple">
									Default To
								</a>
								@else
								<span style="font-size:12px;">&nbsp;Default To</span>
								@endif

							</td>
						</tr>
						@endforeach								
					</tbody>
				  </table>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
