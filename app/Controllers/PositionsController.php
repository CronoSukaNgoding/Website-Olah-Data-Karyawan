<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PositionsController extends BaseController
{
    public function index()
    {
        if($this->sesi->get('role')== 1 || $this->sesi->get('role')== 2){
            $data =[
                'title' => 'Position List'
            ];
            return view('Dashboard/Position/index', $data);
        }else{
            $this->sesi->setFlashdata('error', 'Anda Tidak Mempunyai Hak Akses');
            return redirect()->to('/dashboard');
        }
        
    }

    public function dropdown()
    {
        $data = $this->position->get()->getResult();
        echo json_encode($data);
    }

    public function create()
    {
        if($this->sesi->get('role')== 1 || $this->sesi->get('role')== 2){
             $data =[
                'title' => 'Salary Create'
            ];
            return view('Dashboard/Position/create', $data);
        }else{
            $this->sesi->setFlashdata('error', 'Anda Tidak Mempunyai Hak Akses');
            return redirect()->to('/dashboard');
        }
       
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
            return redirect()->to('dashboard/position/create');
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
            return redirect()->to('/dashboard/position');
       } catch (\Exception $e) {
            dd($e);
            $e->getMessage();
            $this->sesi->setFlashdata('sukses', 'Anda Gagal Mendaftar');
            return redirect()->to('/dashboard/position/create');
       }

    }

    public function list(){
        $data = $this->position
        ->findAll();
        return $this->response->setJSON($data);
    }

    public function edit($id){
        if($this->sesi->get('role')== 1 || $this->sesi->get('role')== 2){
            $dataPosition = $this->position
            ->where('positions.id',$id)->first();
            $data =[
                'dataPosition' => $dataPosition,
                'title'=>'Salary Edit'
            ];
            return view('Dashboard/Position/edit', $data);
        }else{
            $this->sesi->setFlashdata('error', 'Anda Tidak Mempunyai Hak Akses');
            return redirect()->to('/dashboard');
        }
        
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
            return redirect()->to('dashboard/position/create');
        }
        $basicSalary = $this->request->getVar('basic_salary');
        $bonusRate = $this->request->getVar('bonus_rate');

        // Convert the formatted values back to float
        // $basicSalary = (int) str_replace(['Rp', '.', ','], ['', '', ''], $basicSalary);
        $bonusRate = floatval(str_replace(',', '.', str_replace('.', '', $bonusRate)));

        $data=[
            'name'=>$this->request->getVar('name'),
            'grade'=>$this->request->getVar('grade'),
            'basic_salary'=>$basicSalary,
            'bonus_rate' => $bonusRate
        ];
        // dd($data);
        try {
            $daftar = $this->position->update($id,$data);
            $this->sesi->setFlashdata('sukses', 'Selamat Anda Berhasil Mengedit data user');
            return redirect()->to('/dashboard/position');
       } catch (\Exception $e) {
            dd($e);
            $e->getMessage();
            $this->sesi->setFlashdata('sukses', 'Anda Gagal Mendaftar');
            return redirect()->to('/dashboard/position/create');
       }

    }

    public function delete($id){
       try {
            $this->position->delete($id);
            $this->sesi->setFlashdata('sukses', 'Selamat Anda Berhasil Menghapus data user');
            return redirect()->to('/dashboard/position');
        } catch (\Exception $e) {
            dd($e);
       }
    }
}
