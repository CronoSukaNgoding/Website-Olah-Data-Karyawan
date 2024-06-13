<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class EmployeesController extends BaseController
{
    public function index()
    {
        $data =[
            'title' => 'Employee List'
        ];
        return view('Dashboard/Employee/index', $data);
    }

    public function list(){
        $data = $this->employee->select('*, positions.name as positionName')
        ->join('positions','positions.id = employees.positionID')
        ->findAll();
        return $this->response->setJSON($data);
    }
}
