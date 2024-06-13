<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class RoleController extends BaseController
{
    public function dropdown()
    {
        $data = $this->role->get()->getResult();
        echo json_encode($data);
    }
}
