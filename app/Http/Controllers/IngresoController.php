<?php

namespace adVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use adVentas\Http\Requests\IngresoFormRequest;
use adVentas\Ingreso;
use adVentas\DetalleIngreso;

use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;



class IngresoController extends Controller
{
      public function __construct()
   {

   }

   /*recibe como parametro un objeto del tipo request*/
   public function index(Request $request)
   {
   	if ($request) {
   		$consulta=trim($request->get('searchText'));
   		$ingresos=DB::table('ingreso as i')
   			->join('persona as p','i.idproveedor','=','p.idpersona')
   			->join('detalle_ingreso as di','i.idproveedor','=','di.idingreso')
   			->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra)as total'))
   			->where('i.num_comprobante','LIKE','%'.$consulta.'%')
   			->orderBy('i.idingreso','desc')
   			->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
   			->paginate(7);
   			return view('compras.ingreso.index',['ingresos'=>$ingresos,'searchText'=>$consulta]);
   	}

   }

   /* retornar a una vista */
   public function create()
   {
   		$personas=DB::table('persona')->where('tipo_persona','=','Proveedor')->get();
   		$articulos=DB::table('articulo as a')
   			->select(DB::raw('CONCAT(a.codigo," ",a.nombre)as articulo'),'a.idarticulo')
   			->where('a.estado','=','Activo')
   			->get();

   			return view('compras.ingreso.create',['personas'=>$personas,'articulos'=>$articulos]);
   }

   /* almacenar el objeto del modelo categoria | tabla categoria de la BD  | validacion formrequest */
   public function store(IngresoFormRequest $request)
   {	
   		try {

   			DB::beginTransaction();

   			$ingreso=new Ingreso();
   			$ingreso->idproveedor=$request->get('idproveedor');
   			$ingreso->tipo_comprobante=$request->get('tipo_comprobante');
   			$ingreso->serie_comprobante=$request->get('serie_comprobante');
   			$ingreso->num_comprobante=$request->get('num_comprobante');
   			$mytime = Carbon::now('America/Lima');
   			$ingreso->fecha_hora=$mytime->toDateTimeString();
   			$ingreso->impuesto='18';
   			$ingreso->estado='A';
   			$ingreso->save();


   			$idarticulo = $request->get('idarticulo');
   			$cantidad = $request->get('cantidad');
   			$precio_compra = $request->get('cantidad');
   			$precio_venta = $request->get('precio_venta');


   			$contador = 0;

   			while ($contador < count($idarticulo)) {
   				
   				$detalle = new DetalleIngreso();
   				$detalle->idingreso = $ingreso->idingreso;
   				$detalle->idarticulo = $idarticulo[$contador];
   				$detalle->cantidad = $cantidad[$contador];
   				$detalle->precio_compra = $precio_compra[$contador];
   				$detalle->precio_venta = $precio_venta[$contador];
   				$detalle->save();

   				$contador = $contador +1;
   			}




   			DB::commit();
   			
   		} catch (Exception $e) {

   			DB::rollback();

   		}

   		return Redirect::to('compras/ingreso');

   		 /* direcciona al listado del almacen categoria */
   }

   /* recibe un parametro de una categoria | retorna una vista*/
   public function show($id)
   {
   		$ingreso=DB::table('ingreso as i')
   			->join('persona as p','i.idproveedor','=','p.idpersona')
   			->join('detale_ingreso as di','i.idproveedor','=','di.idingreso')
   			->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra)as total'))
   			->where('i.idingreso','=',$id)
   			->first();

   		$detalles=DB::table('detalle_ingreso as d')
   			->join('articulo as a ','d.idarticulo','=','a.idarticulo')
   			->select('a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta')
   			->where('d.ingreso','=',$id)
   			->get();

   		return view('compras.ingreso.show',['ingreso'=>$ingreso,'detalles'=>$detalles]);
   }


   /* recibe como parametro un ID | cambiar el estado de la categoria*/
   public function destroy($id)
   {
   		$ingreso=Ingreso::findOrFail($id);
   		$ingreso->estado='C';
   		$ingreso->update();
   		return Redirect::to('compras/ingreso');
   }
}
