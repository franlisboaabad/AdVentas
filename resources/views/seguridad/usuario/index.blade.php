@extends('layouts.admin')
@section('contenido')
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de usuarios <a href="usuario/create"> <button class="btn btn-success">Nuevo</button> </a></h3>
			@include('seguridad.usuario.search')
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condesed table-hover">
					<thead>
						<th>Id</th>
						<th>Nombre</th>
						<th>Email</th>
					</thead>
				@foreach($usuarios as $user)
					<tr>
						<td>{{ $user->id }}</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td>
							<a href="{{URL::action('UsuarioController@edit',$user->id)}}"> <button class="btn btn-info">Editar</button> </a>
							<a href="" data-target="#modal-delete-{{ $user->id }}" data-toggle="modal"> <button class="btn btn-danger">Eliminar</button> </a>
						</td>
					</tr>
					
					@include('seguridad.usuario.modal')

				@endforeach
				</table>
			</div>

			{{ $usuarios->render() }}
		</div>
	</div>
@endsection