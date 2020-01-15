@extends('layouts.app')
	
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="card panel-default">
					<div class="card-header">Панель администратора</div>
					<div class="card-body table-responsive">
						<router-view name="Adminka"></router-view>
						<router-view></router-view>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection