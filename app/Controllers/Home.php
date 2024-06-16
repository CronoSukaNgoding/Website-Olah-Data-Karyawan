<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if($this->sesi->get('logged_in') == true){
            $data =[
                'title' => 'Dashboard'
            ];
            return view('Dashboard/index', $data);
        }else{
            return redirect()->to('/login');
        }
    }
}
