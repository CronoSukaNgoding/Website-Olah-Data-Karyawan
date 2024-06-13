<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SalariesController extends BaseController
{
    public function index()
    {
        $data =[
            'title' => 'Salary List'
        ];
        return view('Dashboard/Salary/index', $data);
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
            'id'=>$this->uuid,
            'employeeID'=>$this->request->getVar('employeeID'),
            'salary_date'=>$this->request->getVar('salary_date'),
            'basic_salary'=>$this->request->getVar('basic_salary'),
            'bonus' => $this->request->getVar('bonus'),
            'tax' => $this->request->getVar('tax'),
            'total_salary' => $this->request->getVar('total_salary'),
        ];
        // dd($data);
        try {
            $daftar = $this->user->insert($data);
            $this->sesi->setFlashdata('sukses', 'Selamat Anda Berhasil Membuat akun');
            return redirect()->to('/dashboard/salary');
       } catch (\Exception $e) {
            dd($e);
            $e->getMessage();
            $this->sesi->setFlashdata('sukses', 'Anda Gagal Mendaftar');
            return redirect()->to('/dashboard/salary/create');
       }

    }

    public function list(){
        $data = $this->user->select('*')
        ->join('employees','salaries.employeeID = employees.id')
        ->findAll();
        return $this->response->setJSON($data);
    }

    public function edit($id){
        $dataUser = $this->user->select('*')
        ->join('employees','salaries.employeeID = employees.id')
        ->join('positions','positions.id = employees.positionID')
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
