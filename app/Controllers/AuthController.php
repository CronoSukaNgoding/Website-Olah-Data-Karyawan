<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function index()
    {
        
        if($this->sesi->get('logged_in') == true){
            return redirect()->to('/dashboard');
        }else{
            $data =[
                'title' => 'Login Page'
            ];
            return view('Auth/login', $data);
        }
    }

    public function Login()
    {
        
        if($this->sesi->get('logged_in') == true){
            return redirect()->to('/dashboard');
        }else{
            return redirect()->to('/login');
        }
        
       
    }

    public function cekLogin(){
        $isValid = [
            'username' => 'required',
            'password' => 'required|min_length[6]',
        ];
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('login');
        }
       
        $user = $this->user->where("username", $this->request->getVar("username"))->first();
        
        
        if (!$user) {
            $this->sesi->setFlashdata('error', 'Username tidak ditemukan');
            return redirect()->to('/login');
        }else{
            $password = $this->request->getVar("password");
            $hash = $user->password;
            $cekPw = password_verify($password, $hash);
            if(!$cekPw){
                $this->sesi->setFlashdata('error', 'Password salah');
                return redirect()->to('/login');
            }else {
                $ses_data = [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'logged_in' => true,
                    'role' => $user->role_id
                ];

                $this->sesi->set($ses_data);
                $this->sesi->setFlashdata('sukses', 'Selamat Datang');
                return redirect()->to('/dashboard');
            }
        }
    }
     public function Logout(){
        $this->sesi->destroy();
        $this->sesi->setFlashdata('sukses', 'Anda berhasil logout');
        return redirect()->to('/login');
    }
}
