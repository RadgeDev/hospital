              <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consumo_model extends CI_Model {
  
  public function buscar($fechainicio= FALSE,$inicio = FALSE, $cantidadregistro = FALSE,$fechafin=FALSE,$bodega=FALSE)
  
  {
  $query = $this->db-> query("SET lc_time_names = 'es_CL'");
  $this->db->select('Year(fecha) AS ano,MONTHNAME(CONCAT(fecha)) AS mes ,fecha,cod_producto ,bincard.nombre,cod_bodega,bodegas.nombre as nombrebodega, Sum(salida) as totales');
  $this->db->from('bincard'); /*I assume that film was the table name*/
  $this->db->join('producto', 'producto.cod_interno_prod = bincard.cod_producto');
  $this->db->join('bodegas', 'bodegas.cod_bodegas = producto.cod_bodega');
  $this->db->where("cod_bodega",$bodega);
  $this->db->where("fecha BETWEEN '$fechainicio' AND '$fechafin'");
   $this->db->having('totales > 0');
  if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
      $this->db->limit($cantidadregistro,$inicio);
  }
  $this->db->group_by('cod_producto'); 
 $this->db->group_by('mes'); 
 $this->db->order_by('fecha', 'desc');
  $consulta = $this->db->get();
  return $consulta->result();
  }

}//fin de clase