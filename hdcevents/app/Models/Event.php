<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    
    use HasFactory;

    protected $casts = [
        'items' => 'array' //dizendo que o campo 'items' é um array e não string
    ];

    protected $dates = ['date']; //dizendo que o campo 'date' é do tipo date

    protected $guarded = [];
    //tudo que foi enviado pelo 'post' pode ser atualizado sem nenhuma restrição

    public function user()
    {
        return $this->belongsTo('App\Models\User');
        //belongsTo(): pertence à UM 'usuario'
    }

    //Dizendo que o evento tem muitos usuários
    public function users()
    {
        return $this->belongsToMany('App\Models\User'); //belongsToMany: pertence à muitos
    }

}
