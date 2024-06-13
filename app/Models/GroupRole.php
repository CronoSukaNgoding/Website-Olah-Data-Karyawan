<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupRole extends Model
{
    protected $table            = 'groupRole';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'name',
    ];


    // Dates
    protected $useTimestamps = false;
}
