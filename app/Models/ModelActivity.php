<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelActivity extends Model
{
  protected $table      = 'daily_activity';
  protected $primaryKey = 'id';
  protected $allowedFields = ['tanggal_activity', 'aktifitas', 'last_update', 'userid'];

  public function getActivity($tanggal, $userid)
  {
    $builder = $this->db->table('daily_activity');
    $builder->select('*, daily_activity.id as activityid');
    $builder->join('users', 'users.id = daily_activity.userid');
    $builder->where('tanggal_activity', $tanggal);
    $builder->where('userid', $userid);
    $query = $builder->get();
    return $query->getResult();
  }

  public function getReport($tanggal)
  {
    $query = "SELECT * FROM `daily_activity` LEFT JOIN absensi ON DATE(daily_activity.tanggal_activity) = DATE(absensi.tanggal) JOIN users on daily_activity.userid = users.id WHERE daily_activity.userid = absensi.userid AND tanggal_activity = '$tanggal';";
    $query = $this->db->query($query);

    return $query->getResult();
  }

  public function countStaffActivity($userid)
  {
    $builder = $this->db->table('daily_activity');
    $builder->select('*, daily_activity.id as activityid');
    $builder->join('users', 'users.id = daily_activity.userid');
    $builder->where('tanggal_activity', date('Y-m-d'));
    $builder->where('userid', $userid);
    $query = $builder->countAllResults();
    return $query;
  }

  public function countActivityToday($userid, $tanggal)
  {
    $builder = $this->db->table('daily_activity');
    $builder->select('*, daily_activity.id as activityid');
    $builder->join('users', 'users.id = daily_activity.userid');
    $builder->where('tanggal_activity', $tanggal);
    $builder->where('userid', $userid);
    $query = $builder->countAllResults();
    return $query;
  }
}
