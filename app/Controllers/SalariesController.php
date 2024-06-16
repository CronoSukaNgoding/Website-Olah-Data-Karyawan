<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SalariesController extends BaseController
{
    public function index()
    {
        if($this->sesi->get('role')== 1){
            $data =[
                'title' => 'Salary List'
            ];
            return view('Dashboard/Salary/index', $data);
        }else{
            $userID = $this->sesi->get('user_id');
            $checkDataEmployee = $this->user->select('employees.id as employeeID')->where('users.id', $userID)
            ->join('employees','employees.userID = users.id')
            ->first();
            $data =[
                'title' => 'Salary List',
                'employeeID' => $checkDataEmployee->employeeID
            ];
            return view('Dashboard/Salary/indexEmployee', $data);
        }
        
    }

    public function create()
    {
        $data =[
            'title' => 'Salary Create'
        ];
        return view('Dashboard/Salary/create', $data);
    }

    public function save()
    {
        $isValid = [
            'positionID' => 'required',
        ];
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('dashboard/salary/create');
        }
        $isBonus =  $this->request->getVar('useBonus');

        $positionID = $this->request->getVar('positionID');
        $employeeID  = $this->request->getVar('employeeID');
        $salary = $this->position->select('*')
        ->where('positions.id',$positionID)->first();
        
        try {
            $bonus = ((float) $salary->bonus_rate / 100) *((float) $salary->basic_salary) ;
            $tax = (float) $salary->basic_salary * 0.05;
            if($isBonus == 1){
                $data = [
                    'id' => $this->uuid,
                    'employeeID' => $employeeID,
                    'gradeID' => $salary->grade,
                    'salary_date' => $this->request->getVar('salary_date'),
                    'basic_salary' => $salary->basic_salary,
                    'bonus' => $bonus,
                    'tax' => $tax,
                    'total_salary' => (float) $salary->basic_salary + $bonus - $tax,
                ];
            }else{
                $data = [
                    'id' => $this->uuid,
                    'employeeID' => $employeeID,
                    'gradeID' => $salary->grade,
                    'salary_date' => $this->request->getVar('salary_date'),
                    'basic_salary' => $salary->basic_salary,
                    'bonus' => 0,
                    'tax' => $tax,
                    'total_salary' => (float) $salary->basic_salary - $tax,
                ];
            }
            
            
            $daftar = $this->salary->insert($data);
            
        
            $this->sesi->setFlashdata('sukses', 'Selamat Anda Berhasil Membuat akun');
            return redirect()->to('/dashboard/salary');
       } catch (\Exception $e) {
            dd($e);
            $e->getMessage();
            $this->sesi->setFlashdata('sukses', 'Anda Gagal Mendaftar');
            return redirect()->to('/dashboard/salary/create');
       }

    }

    public function list($startDate = null,$endDate= null, $employeeID= null){
        $param = $_REQUEST;
        $TEST = [];

        $query_builder = $this->salary->select('*, salaries.created_at as tglBuat')
            ->join('employees', 'salaries.employeeID = employees.id')
            ->join('positions', 'positions.grade = salaries.gradeID');

        if(isset($param['employeeID']) && !empty($param['employeeID'])){
            $query_builder->where('employees.id', $param['employeeID']);
        }

        if(isset($param['startDate']) && !empty($param['startDate'])) {
            $query_builder->where("salaries.salary_date BETWEEN '{$param['startDate']}' AND '{$param['endDate']}'");
        }
        $TEST = $query_builder->findAll();
        
        if ($TEST) {
            $data = [
                "draw" => null,
                "recordsTotal" => count($TEST),
                "recordsFiltered" => count($TEST),
                "data" => $TEST,
            ];

            return $this->response->setJSON(['response'=> $data, 'param'=> $param]);
        } else {
            return $this->response->setStatusCode(200)->setJSON(['error' => 'No data found']);
        }
    }

    public function getTotal(){
        $positionID = $this->request->getVar('positionID');
        $employeeID  = $this->request->getVar('employeeID');
        $data = $this->position->select('*, employees.id as employeeID')
        ->join('employees','employees.positionID = positions.id')
        ->where('positions.id',$positionID)->where('employees.positionID',$positionID)->first();
        return $this->response->setJSON($data);
    }

    public function edit($id){
        $dataUser = $this->salary->select('*')
        ->join('employees','salaries.employeeID = employees.id')
        ->join('positions','positions.grade = salaries.gradeID')
        ->where('salaries.id',$id)->first();
        $data =[
            'dataUser' => $dataUser,
            'title'=>'Salary Edit'
        ];
        return view('Dashboard/Salary/edit', $data);
    }

    public function update($id)
    {
        $isValid = [
            'employeeID' => 'required',
            'salary_date' => 'required',
            'basic_salary' => 'required',
            'bonus' => 'required',
            'tax' => 'required',
            'total_salary' => 'required'
        ];
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('dashboard/salary/create');
        }
        $username = $this->request->getVar('username');
            $data=[
                'employeeID'=>$this->request->getVar('employeeID'),
                'salary_date'=>$this->request->getVar('salary_date'),
                'basic_salary'=>$this->request->getVar('basic_salary'),
                'bonus' => $this->request->getVar('bonus'),
                'tax' => $this->request->getVar('tax'),
                'total_salary' => $this->request->getVar('total_salary'),
            ];
            // dd($data);
            try {
                $daftar = $this->user->update($id,$data);
                $this->sesi->setFlashdata('sukses', 'Selamat Anda Berhasil Mengedit data user');
                return redirect()->to('/dashboard/salary');
       } catch (\Exception $e) {
            dd($e);
            $e->getMessage();
            $this->sesi->setFlashdata('sukses', 'Anda Gagal Mendaftar');
            return redirect()->to('/dashboard/salary/create');
       }

    }

    public function delete($id){
       try {
            $this->salary->delete($id);
            $this->sesi->setFlashdata('sukses', 'Selamat Anda Berhasil Menghapus data user');
            return redirect()->to('/dashboard/salary');
        } catch (\Exception $e) {
            dd($e);
       }
    }
}
