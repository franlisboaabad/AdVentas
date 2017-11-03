<?php

namespace adVentas\Http\Controllers;

use Illuminate\Http\Request;

use adVentas\Http\Requests;


use adVentas\Persona;
use Illuminate\Support\Facades\Redirect;
use adVentas\Http\Requests\PersonaFormRequest;
use DB;

class ProveedorController extends Controller
{
     public function __construct()
   {
      $this->middleware('auth');
   }

   /*recibe como parametro un objeto del tipo request*/
   public function index(Request $request)
   {
   	if ($request) {
   		$consulta=trim($request->get('searchText'));
   		$personas=DB::table('persona')
   		->where('nombre','LIKE','%'.$consulta.'%')
   		->where('tipo_persona','=','Proveedor')
   		->orwhere('num_documento','LIKE','%'.$consulta.'%')
   		->where('tipo_persona','=','Proveedor')

   		->orderBy('idpersona','desc')
   		->paginate(7);

   		return view('compras.proveedor.index',['personas'=>$personas,'searchText'=>$consulta]);
   	}

   }

   /* retornar a una vista */
   public function create()
   {
   		return view('compras.proveedor.create');
   }

   /* almacenar el objeto del modelo categoria | tabla categoria de la BD  | validacion formrequest */
   public function store(PersonaFormRequest $request)
   {
   		$persona = new Persona;
   		$persona->tipo_persona="Proveedor";
   		$persona->nombre= $request->get('nombre');
   		$persona->tipo_documento=$request->get('tipo_documento');
        $persona->num_documento=$request->get('num_documento');
   		$persona->direccion=$request->get('direccion');
   		$persona->telefono=$request->get('telefono');
   		$persona->email=$request->get('email');
   		$persona->save();
   		return Redirect::to('compras/proveedor'); /* direcciona al listado del almacen categoria */
   }

   /* recibe un parametro de una categoria | retorna una vista*/
   public function show($id)
   {
   		return view('compras.proveedor.show',['persona'=>Persona::findOrFail($id)]);
   }

   /* llamar a un formulario donde modifico los datos de una categoria especifica */ 
   public function edit($id)
   {
   		return view('compras.proveedor.edit',['persona'=>Persona::findOrFail($id)]);
   }

   /* recibe 2 parametro de tipo formRequest*/
   public function update(PersonaFormRequest $request,$id)
   {
   		$persona = Persona::findOrFail($id); // categoria que quiero modificar 
   		$persona->nombre= $request->get('nombre');
         $persona->tipo_documento=$request->get('tipo_documento');
         $persona->num_documento=$request->get('num_documento');
         $persona->direccion=$request->get('direccion');
         $persona->telefono=$request->get('telefono');
         $persona->email=$request->get('email');
   		$persona->update();
   		return Redirect::to('compras/proveedor');
   }

   /* recibe como parametro un ID | cambiar el estado de la categoria*/
   public function destroy($id)
   {
   		$persona=Persona::findOrFail($id);
   		$persona->tipo_persona='Inactivo';
   		$persona->update();
   		return Redirect::to('compras/proveedor');	
   }
}
