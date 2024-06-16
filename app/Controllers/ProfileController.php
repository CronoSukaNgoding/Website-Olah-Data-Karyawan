<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    public function edit($id){
        $dataUser = $this->user->select('*,users.name as userName, groupRole.name as roleName')
        ->join('employees','employees.userID = users.id')
        ->join('positions','positions.id = employees.positionID')
        ->join('groupRole','groupRole.id = users.role_id')
        ->where('users.id',$id)->first();
        $data =[
            'dataUser' => $dataUser,
            'title'=>'Profile Edit'
        ];
        return view('Dashboard/Profil/edit', $data);
    }

    public function update($id)
    {
        $isValid = [
            'username' => 'required',
            'name' => 'required',
            'nip' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'birth_date' => 'required',

        ];
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('dashboard/profile/edit/'.$id);
        }
        $username = $this->request->getVar('username');
            $data=[
                'name'=>$this->request->getVar('name'),
                'email'=>$this->request->getVar('email'),
                'username'=>$username
            ];
            // dd($data);
            try {
                $daftar = $this->user->update($id,$data);
                $cekidkaryawan = $this->employee->where('userID',$id )->first();
                $datakaryawan = [
                    'userID' => $id,
                    'nip' => $this->request->getVar('nip'),
                    'first_name' => $this->request->getVar('first_name'),
                    'last_name' => $this->request->getVar('last_name'),
                    'address' => $this->request->getVar('address'),
                    'birth_date' => $this->request->getVar('birth_date'),
                ];
                $svpelanggan = $this->employee->update($cekidkaryawan->id,$datakaryawan);
                
                $this->sesi->setFlashdata('sukses', 'Selamat Anda Berhasil Mengedit data user');
                return redirect()->to('/dashboard');
       } catch (\Exception $e) {
            dd($e);
            $e->getMessage();
            $this->sesi->setFlashdata('sukses', 'Anda Gagal edit');
            return redirect()->to('/dashboard');
       }

    }
}
