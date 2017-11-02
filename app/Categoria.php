<?php

namespace adVentas;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';

    protected $primaryKey='idcategoria';

    public $timestamps=false;

    protected $fillable =[

    	'nombre',
    	'descripcion',
    	'estado'

    ];

}
