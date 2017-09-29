<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Pagamento extends Model
{
    protected $table = "tipo_pagamento"; 

    protected $primaryKey = 'tipPagCod';
}
