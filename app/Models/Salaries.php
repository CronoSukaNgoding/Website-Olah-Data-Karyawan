<?php

namespace App\Models;

use CodeIgniter\Model;

class Salaries extends Model
{
    protected $table            = 'salaries';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'employeeID',
        'salary_date',
        'positionID',
        'bonus',
        'gradeID',
        'tax',
        'total_salary',
    ];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
