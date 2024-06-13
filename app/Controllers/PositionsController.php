<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PositionsController extends BaseController
{
    public function index()
    {
        $data =[
            'title' => 'Position List'
        ];
        return view('Dashboard/Position/index', $data);
    }

    public function dropdown()
    {
        $data = $this->position->get()->getResult();
        echo json_encode($data);
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
            'name' => 'required',
            'grade' => 'required',
            'basic_salary' => 'required',
            'bonus_rate' => 'required'
        ];
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('dashboard/salary/create');
        }
        $data=[
            'id'=>$this->uuid,
            'name'=>$this->request->getVar('name'),
            'grade'=>$this->request->getVar('grade'),
            'basic_salary'=>$this->request->getVar('basic_salary'),
            'bonus_rate' => $this->request->getVar('bonus_rate'),
        ];
        // dd($data);
        try {
            $daftar = $this->position->insert($data);
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
        $data = $this->position
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
            'name' => 'required',
            'grade' => 'required',
            'basic_salary' => 'required',
            'bonus_rate' => 'required'
        ];
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('dashboard/salary/create');
        }
        $data=[
            'name'=>$this->request->getVar('name'),
            'grade'=>$this->request->getVar('grade'),
            'basic_salary'=>$this->request->getVar('basic_salary'),
            'bonus_rate' => $this->request->getVar('bonus_rate'),
        ];
        // dd($data);
        try {
            $daftar = $this->position->update($id,$data);
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
            $this->position->delete($id);
            $this->sesi->setFlashdata('sukses', 'Selamat Anda Berhasil Menghapus data user');
            return redirect()->to('/dashboard/salary');
        } catch (\Exception $e) {
            dd($e);
       }
    }
}
