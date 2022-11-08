<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKonfirmasi extends Model
{
  protected $table      = 'konfirmasi';
  protected $primaryKey = 'id';
  protected $allowedFields = ['id', 'tanggal', 'userid'];

  public function getAll()
  {
    $builder = $this->db->table('konfirmasi');
    $builder->select('*');
    $builder->join('users', 'users.id = konfirmasi.userid');
    $query = $builder->get();
    return $query->getResult();
  }

  public function deleteData($userid)
  {
    $builder = $this->db->table('konfirmasi');
    $builder->where('userid', $userid);
    $builder->delete();
  }
}
