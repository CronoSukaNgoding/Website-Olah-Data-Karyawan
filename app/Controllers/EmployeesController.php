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

    public function dropdown(){
        $positionID = $this->request->getVar('positionID');
        if($positionID){
            $data = $this->employee->where('positionID',$positionID)
            ->findAll();
        }else{
            $data = $this->employee
            ->findAll();
        }
        
        return $this->response->setJSON($data);
    }
}
