<?php

namespace adVentas\Http\Controllers;
use Illuminate\Http\Request;

use adVentas\Http\Requests;


use adVentas\Articulo;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use adVentas\Http\Requests\ArticuloFormRequest;
use DB;

class ArticuloController extends Controller
{
	    public function __construct()
	   {

	   }

	   /*recibe como parametro un objeto del tipo request*/
	   public function index(Request $request)
	   {
	   	if ($request) {
	   		$consulta=trim($request->get('searchText'));
	   		$articulos=DB::table('articulo as a')
	   		->join('categoria as c','a.idcategoria','=','c.idcategoria')
	   		->select('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado')
	   		->where('a.nombre','LIKE','%'.$consulta.'%')
	   		->orderBy('a.idarticulo','desc')
	   		->paginate(7);

	   		return view('almacen.articulo.index',['articulos'=>$articulos,'searchText'=>$consulta]);
	   	}

	   }

	   /* retornar a una vista */
	   public function create()
	   {
	   	/* listado de categorias | estado de categorias */
	   		$categorias=DB::table('categoria')->where('estado','=',1)->get();
	   		return view('almacen.articulo.create',['categorias'=>$categorias]);
	   }

	   /* almacenar el objeto del modelo categoria | tabla categoria de la BD  | validacion formrequest */
	   public function store(ArticuloFormRequest $request)
	   {
	   		$articulo = new Articulo;
	   		$articulo->idcategoria=$request->get('idcategoria');
	   		$articulo->codigo=$request->get('codigo');
	   		$articulo->nombre=$request->get('nombre');
	   		$articulo->stock=$request->get('stock');
	   		$articulo->descripcion=$request->get('descripcion');
	   		$articulo->estado='Activo';

	   			if (Input::hasFile('imagen')) {
	   				$file=Input::file('imagen');
	   				$file->move(public_path().'/imagenes/articulos',$file->getClientOriginalName());
	   				$articulo->imagen=$file->getClientOriginalName();
	   			}

	   		$articulo->save();
	   		return Redirect::to('almacen/articulo'); /* direcciona al listado del almacen categoria */
	   }

	   /* recibe un parametro de una categoria | retorna una vista*/
	   public function show($id)
	   {
	   		return view('almacen.articulo.show',['articulo'=>Articulo::findOrFail($id)]);
	   }

	   /* llamar a un formulario donde modifico los datos de una categoria especifica */ 
	   public function edit($id)
	   {
	   		/* opciones adicionales | mostrar listado de los articulos | detalles*/
	   		$articulo=Articulo::findOrFail($id);
	   		$categorias=DB::table('categoria')->where('estado','=',1)->get();
	   		return view('almacen.articulo.edit',['articulo'=>$articulo,'categorias'=>$categorias]);
	   }

	   /* recibe 2 parametro de tipo formRequest*/
	   public function update(ArticuloFormRequest $request,$id)
	   {
	   		$articulo = Articulo::findOrFail($id); // categoria que quiero modificar 
	   		$articulo->idcategoria=$request->get('idcategoria');
	   		$articulo->codigo=$request->get('codigo');
	   		$articulo->nombre=$request->get('nombre');
	   		$articulo->stock=$request->get('stock');
	   		$articulo->descripcion=$request->get('descripcion');

	   			if (Input::hasFile('imagen')) {
	   				$file=Input::file('imagen');
	   				$file->move(public_path().'/imagenes/articulos',$file->getClientOriginalName());
	   				$articulo->imagen=$file->getClientOriginalName();
	   			}

	   		$articulo->update();
	   		return Redirect::to('almacen/articulo');
	   }

	   /* recibe como parametro un ID | cambiar el estado de la categoria*/
	   public function destroy($id)
	   {
	   		$articulo=Articulo::findOrFail($id);
	   		$articulo->estado='Inactivo';
	   		$articulo->update();
	   		return Redirect::to('almacen/articulo');	
	   }


}
