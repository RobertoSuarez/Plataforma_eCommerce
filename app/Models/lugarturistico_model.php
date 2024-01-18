<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;


class lugarturistico_model extends Model
{
    protected $table = 'lugar_turistico';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['subcategoria_id','nombre_lugar','descripcion','direccion','logo','imagenes_gif','puntuacion',
                                'telefono','anio','delivery','whatsapp','google_maps'];
    
    public function execQuery($Query){
        $query = $this->db->query($Query);
        return $query->getNumRows() > 0?$query:false;
     }
  
     public function findById($id)
     {
        return $this->asArray()->where(['id' => $id])->first();
     }

     
     public function getListado() {
        $sql = "SELECT Concat('r_',l.id) as dt_rowid, c.id as categoria_id, c.descripcion as categoria, sc.descripcion as subcategoria,
        Concat(l.nombre_lugar,'<br/>',l.descripcion) as detalle_lugar,   l.*
        FROM lugar_turistico l, subcategoria_lugar sc, categoria_lugar c
        WHERE sc.id = l.subcategoria_id and c.id = sc.categoria_id
        order by c.descripcion, sc.descripcion, l.nombre_lugar";
        $query = $this->execQuery($sql);
        if($query)
             return ['data' => $query->getResultArray()];
        else
            return false;
    }

   
    public function getLugarTuristico($ID)
    {
        $sql = "SELECT Concat('r_',l.id) as dt_rowid, c.id  as categoria_id,  c.descripcion as categoria, sc.descripcion as subcategoria, l.*
        FROM lugar_turistico l, subcategoria_lugar sc, categoria_lugar c
        WHERE sc.id = l.subcategoria_id and c.id = sc.categoria_id and l.id=$ID";
        $query = $this->execQuery($sql);
        if($query)
             return $query->getRowArray();
        else
            return false;

    }

    public function getListadoGrid($IDC, $IDSC) {
        $sql = "SELECT c.id as categoria_id, c.descripcion as categoria, sc.descripcion as subcategoria, l.*
        FROM lugar_turistico l, subcategoria_lugar sc, categoria_lugar c
        WHERE sc.id = l.subcategoria_id and c.id = sc.categoria_id ";
        if ($IDC>0)  $sql = $sql. " and c.id=$IDC ";
        if ($IDSC>0) $sql = $sql. " and sc.id=$IDSC ";

        $sql = $sql. " order by c.descripcion, sc.descripcion, l.nombre_lugar";
        $query = $this->execQuery($sql);
        if($query)
             return ['data' => $query->getResultArray()];
        else
            return false;
    }

}