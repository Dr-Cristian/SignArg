<?php 
namespace App\Models;

use CodeIgniter\Model;

class ImgModel extends Model{
    protected $table      = 'imagen';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'ruta',
        'imagen',
        'nombre'
    ];
    public function saveImg($data){
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }
}