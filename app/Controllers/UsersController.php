<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UsersController extends BaseController
{
    public function index()
    {
        if($this->sesi->get('role')== 1 || $this->sesi->get('role')== 2){
            $data =[
                'title' => 'Users List'
            ];
            return view('Dashboard/UserManagement/index', $data);
        }else{
            $this->sesi->setFlashdata('error', 'Anda Tidak Mempunyai Hak Akses');
            return redirect()->to('/dashboard');
        }
        
    }

    public function create()
    {
        if($this->sesi->get('role')== 1 || $this->sesi->get('role')== 2){
            $data =[
                'title' => 'Users Create'
            ];
            return view('Dashboard/UserManagement/create', $data);
        }else{
            $this->sesi->setFlashdata('error', 'Anda Tidak Mempunyai Hak Akses');
            return redirect()->to('/dashboard');
        }        
    }

    public function save()
    {
        $isValid = [
            'username' => 'required',
            'password' => 'required|min_length[6]',
            'name' => 'required',
            'nip' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'birth_date' => 'required',
            'hire_date' => 'required',
            'positionID' => 'required',
            'status' => 'required',
        ];
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('dashboard/userManagement/create');
        }
        $username = $this->request->getVar('username');
        $data=[
            'id'=>$this->uuid,
            'name'=>$this->request->getVar('name'),
            'email'=>$this->request->getVar('email'),
            'role_id'=>$this->request->getVar('role_id'),
            'password' => \password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'username'=>$username
        ];
        // dd($data);
        try {
            $daftar = $this->user->insert($data);
            $cekiduser = $this->user->where('username',$username )->first();
            $datakaryawan = [
                'id' => $this->uuid,
                'userID' => $cekiduser->id,
                'nip' => $this->request->getVar('nip'),
                'first_name' => $this->request->getVar('first_name'),
                'last_name' => $this->request->getVar('last_name'),
                'address' => $this->request->getVar('address'),
                'birth_date' => $this->request->getVar('birth_date'),
                'hire_date' => $this->request->getVar('hire_date'),
                'positionID' => $this->request->getVar('positionID'),
                'status' => $this->request->getVar('status'),
            ];
            // dd($datakaryawan);
            $svpelanggan = $this->employee->insert($datakaryawan);
            
            $this->sesi->setFlashdata('sukses', 'Selamat Anda Berhasil Membuat akun');
            return redirect()->to('/dashboard/userManagement');
       } catch (\Exception $e) {
            dd($e);
            $e->getMessage();
            $this->sesi->setFlashdata('sukses', 'Anda Gagal Mendaftar');
            return redirect()->to('/dashboard/userManagement/create');
       }

    }

    public function list(){
        $data = $this->user->select('users.*, groupRole.name as roleName')->join('groupRole','groupRole.id = users.role_id')->findAll();
        return $this->response->setJSON($data);
    }

    public function edit($id){
        if($this->sesi->get('role')== 1 || $this->sesi->get('role')== 2){
            $dataUser = $this->user->select('*,users.name as userName, groupRole.name as roleName')
            ->join('employees','employees.userID = users.id')
            ->join('positions','positions.id = employees.positionID')
            ->join('groupRole','groupRole.id = users.role_id')
            ->where('users.id',$id)->first();
            $data =[
                'dataUser' => $dataUser,
                'title'=>'User Edit'
            ];
            return view('Dashboard/UserManagement/edit', $data);
        }else{
            $this->sesi->setFlashdata('error', 'Anda Tidak Mempunyai Hak Akses');
            return redirect()->to('/dashboard');
        } 
        
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
            'hire_date' => 'required',
            'positionID' => 'required',
            'status' => 'required',
        ];
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('dashboard/userManagement/create');
        }
        $username = $this->request->getVar('username');
            $data=[
                'name'=>$this->request->getVar('name'),
                'email'=>$this->request->getVar('email'),
                'role_id'=>$this->request->getVar('role_id'),
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
                    'hire_date' => $this->request->getVar('hire_date'),
                    'positionID' => $this->request->getVar('positionID'),
                    'status' => $this->request->getVar('status'),
                ];
                $svpelanggan = $this->employee->update($cekidkaryawan->id,$datakaryawan);
                
                $this->sesi->setFlashdata('sukses', 'Selamat Anda Berhasil Mengedit data user');
                return redirect()->to('/dashboard/userManagement');
       } catch (\Exception $e) {
            dd($e);
            $e->getMessage();
            $this->sesi->setFlashdata('sukses', 'Anda Gagal Mendaftar');
            return redirect()->to('/dashboard/userManagement/create');
       }

    }

    public function delete($id){
       try {
        $cekidkaryawan = $this->employee->where('userID',$id )->first();
        $this->employee->delete($cekidkaryawan->id);
        $this->user->delete($id);
        $this->sesi->setFlashdata('sukses', 'Selamat Anda Berhasil Menghapus data user');
        return redirect()->to('/dashboard/userManagement');
       } catch (\Exception $e) {
            dd($e);
       }
    }
}
