<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;


class Login extends BaseController
{
    public function index()
    {

        if(session()->get('logged_in')){
            return redirect()->to('/dashboard');
        }

        echo view('login');
    }

    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

       if($this->validate($rules)){

           $session = session();
           $model = new User();
           $username = $this->request->getVar('username');
           $password = $this->request->getVar('password');
           $data = $model->where('username', $username)->first();

           if(!$data){
               $session->setFlashdata('error', 'Salah Email');
               return redirect()->to('/');
           }

           $verify = password_verify($password, $data['password']);

           if(!$verify){
               $session->setFlashdata('error', 'Salah Password');
               return redirect()->to('/')->withInput();
           }

           $session_data = [
               'username' => $data['username'],
               'password' => $data['password'],
               'id'       => $data['id'],
               'logged_in'     => TRUE
           ];
           $session->set($session_data);
           return redirect()->to('/dashboard');

       }else{
           $data['validation'] = $this->validator;

           echo view('login', $data);
       }



    }

    public function logout(){
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}

