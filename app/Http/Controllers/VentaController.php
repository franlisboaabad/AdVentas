<?php

namespace adVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use adVentas\Http\Requests\VentaFormRequest;
use adVentas\Venta;
use adVentas\DetalleVenta;

use DB;

use Carbon\Carbon; 
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
{
      public function __construct()
   {

   }

   /*recibe como parametro un objeto del tipo request*/
   public function index(Request $request)
   {
      if ($request) {

         $query=trim($request->get('searchText'));
         $ventas=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
            ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            ->where('v.num_comprobante','LIKE','%'.$query.'%')
            ->orderBy('v.idventa','desc')
            ->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            ->paginate(7);

            return view('ventas.venta.index',['ventas'=>$ventas,'searchText'=>$query]);

      }
   }

   /* retornar a una vista */
   public function create()
   {
   		$personas=DB::table('persona')->where('tipo_persona','=','Cliente')->get();
   		$articulos=DB::table('articulo as a')
            ->join('detalle_ingreso as di','di.idarticulo','a.idarticulo')
            ->select(DB::raw('CONCAT(a.codigo," ",a.nombre) as articulo'),'a.idarticulo','a.stock',DB::raw('avg(di.precio_venta) as precio_promedio'))
            ->where('a.estado','=','Activo')
            ->where('a.stock','>',0)
            ->groupBy('articulo','a.idarticulo','a.stock')
            ->get();

   			return view('ventas.venta.create',['personas'=>$personas,'articulos'=>$articulos]);
   }

   /* almacenar el objeto del modelo categoria | tabla categoria de la BD  | validacion formrequest */
   public function store(VentaFormRequest $request)
   {	
   		try {

   			DB::beginTransaction();

   			$venta=new Venta();
   			$venta->idcliente=$request->get('idcliente');
   			$venta->tipo_comprobante=$request->get('tipo_comprobante');
   			$venta->serie_comprobante=$request->get('serie_comprobante');
   			$venta->num_comprobante=$request->get('num_comprobante');
            $venta->total_venta=$request->get('total_venta');

   			$mytime = Carbon::now('America/Lima');
   			$venta->fecha_hora=$mytime->toDateTimeString();
   			$venta->impuesto='18';
   			$venta->estado='A';
   			$venta->save();


   			$idarticulo = $request->get('idarticulo');
   			$cantidad = $request->get('cantidad');
   			$descuento = $request->get('descuento');
   			$precio_venta = $request->get('precio_venta');


   			$contador = 0;

   			while ($contador < count($idarticulo)) {
   				
   				$detalle = new DetalleVenta();
   				$detalle->idventa = $venta->idventa;
   				$detalle->idarticulo = $idarticulo[$contador];
   				$detalle->cantidad = $cantidad[$contador];
   				$detalle->descuento = $descuento[$contador];
   				$detalle->precio_venta = $precio_venta[$contador];
   				$detalle->save();

   				$contador = $contador +1;
   			}




   			DB::commit();
   			
   		} catch (Exception $e) {

   			DB::rollback();

   		}

   		return Redirect::to('ventas/venta');

   		 /* direcciona al listado del almacen categoria */
   }

   /* recibe un parametro de una categoria | retorna una vista*/
   public function show($id)
   {
   		$venta=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
            ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            ->where('v.idventa','=',$id)
            ->first();

         $detalles=DB::table('detalle_venta as dv')
            ->join('articulo as art','art.idarticulo','=','dv.idarticulo')
            ->select('art.nombre as articulo','dv.precio_venta','dv.cantidad','dv.descuento')
            ->where('dv.idventa','=',$id)
            ->get();

            return view('ventas.venta.show',['venta'=>$venta,'detalles'=>$detalles]);
   }


   /* recibe como parametro un ID | cambiar el estado de la categoria*/
   public function destroy($id)
   {
   		$venta=Venta::findOrFail($id);
   		$venta->estado='C';
   		$venta->update();
   		return Redirect::to('ventas/venta');
   }
}
