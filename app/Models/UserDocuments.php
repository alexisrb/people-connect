<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserDocuments extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated'];

    protected $fillable = [
        'documento_de_identificación_oficial',
        'documento_del_comprobante_de_domicilio',
        'documento_de_no_antecedentes_penales',
        'documento_de_la_licencia_de_conducir',
        'documento_de_la_cedula_profesional',
        'documento_de_la_carta_de_pasante',
        'documento_del_curriculum_vitae',
        'documento_del_contrato',
        'documento_del_contrato',
        'documento_de_caratula_bancaria',
        'documento_de_cedula_fiscal',
        'documento_del_curp',
        'documento_del_requisicion_firmada',
        'documento_del_acta_de_nacimiento',
        'documento_del_seguro_social',
        'otros_documentos'

    ];

    //Uno a Uno
    public function user(){
        return $this->hasOne('App\Models\User');
    }
}
