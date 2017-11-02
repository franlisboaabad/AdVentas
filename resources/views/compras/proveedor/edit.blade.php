@extends('layouts.admin')
@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Proveedor : {{ $persona->nombre }}</h3>


			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>
						{{$error}}	
					</li>
				@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>			


			{!! Form::model($persona,['method'=>'PATCH','route'=>['proveedor.update',$persona->idpersona] ]) !!}
				{{Form::token()}}
			
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="nombre">Nombre</label>
					<input type="text" name="nombre" value="{{ $persona->nombre }}" class="form-control" placeholder="Ingrese nombre.." required> 
				</div>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="direccion">Direccion</label>
					<input type="text" name="direccion" value="{{ $persona->direccion }}" class="form-control" placeholder="direccion.."> 
				</div>
			</div>


			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Documento</label>
					<select name="tipo_documento" class="form-control">
						@if ($persona->tipo_documento=='DNI')
							<option value="DNI" selected>DNI</option>
							<option value="RUC">RUC</option>
							<option value="PASAPORTE">PAS</option>
						@elseif ($persona->tipo_documento=='RUC')
							<option value="DNI">DNI</option>
							<option value="RUC" selected>RUC</option>
							<option value="PASAPORTE">PAS</option>
						@else
							<option value="DNI">DNI</option>
							<option value="RUC">RUC</option>
							<option value="PASAPORTE" selected>PAS</option>
						@endif
					</select>
				</div>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="num_documento">Numero de documento</label>
					<input type="text" name="num_documento" value="{{ $persona->num_documento }}" class="form-control" placeholder="numero de documento">
				</div>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="telefono">Telefono</label>
					<input type="text" name="telefono" value="{{ $persona->telefono }}" class="form-control" placeholder="telefono...">
				</div>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="emai">Email</label>
					<input type="text" name="email" value="{{ $persona->email }}" class="form-control" placeholder="correo electronico..">
				</div>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<button class="btn btn-primary" type="submit">Guardar</button>
					<button class="btn btn-danger" type="reset">Cancelar</button>
				</div>
			</div>

		</div>

			{!! Form::close() !!}
@endsection