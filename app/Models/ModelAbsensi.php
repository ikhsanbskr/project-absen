<?php

namespace App\Models;

use CodeIgniter\Database\MySQLi\Builder;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Model;

class ModelAbsensi extends Model
{
    protected $table      = 'absensi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'checkin', 'checkout', 'lokasi', 'foto', 'userid', 'status', 'keterangan', 'id'];

    public function getAll()
    {
        $builder = $this->db->table('absensi');
        $builder->select('*, absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getStaff()
    {
        $builder = $this->db->table('absensi');
        $builder->select('*, absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where('jabatan !=', 'Marketing');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getMarketing()
    {
        $builder = $this->db->table('absensi');
        $builder->select('*, absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where('jabatan', 'Marketing');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getDate($min, $max)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('*, absensi.status as absenstatus, absensi.id as absenid');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->orderBy('tanggal ASC', 'nama ASC');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getDateStaff($min, $max, $nama)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('*, absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('jabatan !=', 'Marketing');
        $builder->like('nama', $nama);
        $builder->orderBy('tanggal ASC', 'nama ASC');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getDateMarketing($min, $max, $nama)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('*, absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('jabatan', 'Marketing');
        $builder->like('nama', $nama);
        $builder->orderBy('tanggal ASC', 'nama ASC');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getPresenceToday()
    {
        $builder = $this->db->table('absensi');
        $builder->select('*');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where('tanggal', date('Y-m-d'));
        $builder->where('absensi.status !=', 'Kosong');
        $builder->where('absensi.status !=', 'Izin');
        $builder->where('jabatan !=', 'Marketing');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getLateToday()
    {
        $builder = $this->db->table('absensi');
        $builder->select('*');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where('tanggal', date('Y-m-d'));
        $builder->where('absensi.status', 'Terlambat');
        $builder->where('jabatan !=', 'Marketing');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getPermitToday()
    {
        $builder = $this->db->table('absensi');
        $builder->select('*');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where('tanggal', date('Y-m-d'));
        $builder->where('absensi.status', 'Izin');
        $query = $builder->get();
        return $query->getResult();
    }

    public function countSumarry($min, $max, $nama)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('absensi.status !=', 'Libur');
        $builder->where('absensi.status !=', 'Kosong');
        $builder->where('absensi.status !=', 'Izin');
        $builder->like('nama', $nama);
        $query = $builder->countAllResults();
        return $query;
    }

    public function countLate($min, $max, $nama)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('jabatan !=', 'Marketing');
        $builder->where('absensi.status', 'Terlambat');
        $builder->like('nama', $nama);
        $query = $builder->countAllResults();
        return $query;
    }

    public function countAbsent($min, $max, $nama)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('jabatan !=', 'Marketing');
        $builder->where('absensi.status', 'Alpa');
        $builder->like('nama', $nama);
        $query = $builder->countAllResults();
        return $query;
    }

    public function countPermit($min, $max, $nama)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('jabatan !=', 'Marketing');
        $builder->where('absensi.status', 'Izin');
        $builder->like('nama', $nama);
        $query = $builder->countAllResults();
        return $query;
    }

    public function countHoliday($min, $max, $nama)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('jabatan !=', 'Marketing');
        $builder->where('absensi.status', 'Libur');
        $builder->like('nama', $nama);
        $query = $builder->countAllResults();
        return $query;
    }

    public function countNull($min, $max, $nama)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('absensi.status', 'Kosong');
        $builder->like('nama', $nama);
        $query = $builder->countAllResults();
        return $query;
    }

    public function countSumarryAll($min, $max, $userid)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('userid', $userid);
        $builder->where('absensi.status !=', 'Libur');
        $builder->where('absensi.status !=', 'Kosong');
        $builder->where('absensi.status !=', 'Izin');
        $query = $builder->countAllResults();
        return $query;
    }

    public function countLateAll($min, $max, $userid)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('userid', $userid);
        $builder->where('absensi.status', 'Terlambat');
        $query = $builder->countAllResults();
        return $query;
    }

    public function countAbsentAll($min, $max, $userid)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('userid', $userid);
        $builder->where('absensi.status', 'Alpa');
        $query = $builder->countAllResults();
        return $query;
    }

    public function countPermitAll($min, $max, $userid)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('userid', $userid);
        $builder->where('absensi.status', 'Izin');
        $query = $builder->countAllResults();
        return $query;
    }

    public function countHolidayAll($min, $max, $userid)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('userid', $userid);
        $builder->where('absensi.status', 'Libur');
        $query = $builder->countAllResults();
        return $query;
    }

    public function countNullAll($min, $max, $userid)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('userid', $userid);
        $builder->where('absensi.status', 'Kosong');
        $query = $builder->countAllResults();
        return $query;
    }

    public function countStatistic($min, $max)
    {
        $sql = "tanggal BETWEEN '$min' AND '$max'";
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where(new RawSql($sql));
        $builder->where('absensi.status !=', 'Kosong');
        $builder->where('absensi.status !=', 'Izin');
        $query = $builder->countAllResults();
        return $query;
    }

    public function countStaffToday()
    {
        $builder = $this->db->table('absensi');
        $builder->select('*, absensi.status as absenstatus');
        $builder->where('userid', user()->id);
        $builder->where('jabatan !=', 'Marketing');
        $builder->where('tanggal', date('Y-m-d'));
        $builder->join('users', 'users.id = absensi.userid');
        $query = $builder->countAllResults();
        return $query;
    }

    public function countAllStaffToday()
    {
        $builder = $this->db->table('absensi');
        $builder->select();
        $builder->where('jabatan !=', 'Marketing');
        $builder->where('absensi.status !=', 'Izin');
        $builder->where('tanggal', date('Y-m-d'));
        $builder->where('absensi.status !=', 'Libur');
        $builder->where('absensi.status !=', 'Kosong');
        $builder->where('absensi.status !=', 'Izin');
        $builder->join('users', 'users.id = absensi.userid');
        $query = $builder->countAllResults();
        return $query;
    }

    public function countLateToday()
    {
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status');
        $builder->where('jabatan !=', 'Marketing');
        $builder->where('absensi.status', 'Terlambat');
        $builder->where('tanggal', date('Y-m-d'));
        $builder->join('users', 'users.id = absensi.userid');
        $query = $builder->countAllResults();
        return $query;
    }

    public function countPermitToday()
    {
        $builder = $this->db->table('absensi');
        $builder->select('absensi.status');
        $builder->where('jabatan !=', 'Marketing');
        $builder->where('absensi.status', 'Izin');
        $builder->where('tanggal', date('Y-m-d'));
        $builder->join('users', 'users.id = absensi.userid');
        $query = $builder->countAllResults();
        return $query;
    }

    public function countStaffNull($userid)
    {
        $builder = $this->db->table('absensi');
        $builder->select('*, absensi.status as absenstatus');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->where('userid', $userid);
        $builder->where('tanggal', date('Y-m-d'));
        $query = $builder->countAllResults();
        return $query;
    }

    public function getStaffToday()
    {
        $builder = $this->db->table('absensi');
        $builder->select('*, absensi.status as absenstatus');
        $builder->where('jabatan !=', 'Marketing');
        $builder->where('tanggal', date('Y-m-d'));
        $builder->join('users', 'users.id = absensi.userid');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getMarketingToday()
    {
        $builder = $this->db->table('absensi');
        $builder->select('*, absensi.status as absenstatus');
        $builder->where('jabatan', 'Marketing');
        $builder->where('tanggal', date('Y-m-d'));
        $builder->join('users', 'users.id = absensi.userid');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getLast()
    {
        $builder = $this->db->table('absensi');
        $builder->selectMax('id');
        $builder->selectMin('checkout');
        $builder->where('userid', user()->id);
        $builder->where('tanggal', date('Y-m-d'));
        $query = $builder->get();
        // $query = $this->db->query("SELECT * FROM absensi WHERE id=(SELECT max(id) FROM absensi) AND userid =" . user()->id . '');

        // $builder = $this->db->table('absensi');
        // $builder->select();
        // $builder->where('userid', user()->id);
        // $builder->where('userid !=', NULL);
        // $builder->orderBy('id', 'DESC');
        // $builder->limit(1);
        // $query = $builder->get();

        return $query->getRow();
    }

    public function selectLast($lastinput)
    {
        $builder = $this->db->table('absensi');
        $builder->select('checkout, lokasi, keterangan');
        $builder->where('id', $lastinput);
        $query = $builder->get();
        return $query->getRow();
    }

    public function activityReport($tanggal)
    {
        $builder = $this->db->table('Absensi');
        $builder->select('*');
        $builder->join('users', 'users.id = absensi.userid');
        $builder->join('daily_activity', 'daily_activity.userid = absensi.userid');
        $builder->where('daily_activity.tanggal', $tanggal);
        $query = $builder->get();
        return $query->getResult();
    }
}
