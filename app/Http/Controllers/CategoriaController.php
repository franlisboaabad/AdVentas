<?php

namespace adVentas\Http\Controllers;
use Illuminate\Http\Request;

use adVentas\Http\Requests;


use adVentas\Categoria;
use Illuminate\Support\Facades\Redirect;
use adVentas\Http\Requests\CategoriaFormRequest;
use DB;


class CategoriaController extends Controller
{
   public function __construct()
   {

   }

   /*recibe como parametro un objeto del tipo request*/
   public function index(Request $request)
   {
   	if ($request) {
   		$consulta=trim($request->get('searchText'));
   		$categorias=DB::table('categoria')->where('nombre','LIKE','%'.$consulta.'%')
   		->where('estado','=',1)
   		->orderBy('idcategoria','desc')
   		->paginate(7);

   		return view('almacen.categoria.index',['categorias'=>$categorias,'searchText'=>$consulta]);
   	}

   }

   /* retornar a una vista */
   public function create()
   {
   		return view('almacen.categoria.create');
   }

   /* almacenar el objeto del modelo categoria | tabla categoria de la BD  | validacion formrequest */
   public function store(CategoriaFormRequest $request)
   {
   		$categoria = new Categoria;
   		$categoria->nombre=$request->get('nombre');
   		$categoria->descripcion=$request->get('descripcion');
   		$categoria->estado=1;
   		$categoria->save();
   		return Redirect::to('almacen/categoria'); /* direcciona al listado del almacen categoria */
   }

   /* recibe un parametro de una categoria | retorna una vista*/
   public function show($id)
   {
   		return view('almacen.categoria.show',['categoria'=>Categoria::findOrFail($id)]);
   }

   /* llamar a un formulario donde modifico los datos de una categoria especifica */ 
   public function edit($id)
   {
   		return view('almacen.categoria.edit',['categoria'=>Categoria::findOrFail($id)]);
   }

   /* recibe 2 parametro de tipo formRequest*/
   public function update(CategoriaFormRequest $request,$id)
   {
   		$categoria = Categoria::findOrFail($id); // categoria que quiero modificar 
   		$categoria->nombre=$request->get('nombre');
   		$categoria->descripcion=$request->get('descripcion');
   		$categoria->update();
   		return Redirect::to('almacen/categoria');
   }

   /* recibe como parametro un ID | cambiar el estado de la categoria*/
   public function destroy($id)
   {
   		$categoria=Categoria::findOrFail($id);
   		$categoria->estado=0;
   		$categoria->update();
   		return Redirect::to('almacen/categoria');	
   }



}
