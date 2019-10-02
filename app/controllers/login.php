<?php
session_start();
class Login extends Controller {
    public function index(){
        $this->view('login/index');
    }
    public function loginUser(){
        $user = $this->model('User');
        $user->setUsername($_POST['username']);
        $user->setPassword($_POST['password']);
        $validUser = $user->validateUser($_POST['username']);
        if(!$validUser){
            echo "Invalid Credentials";
            header('location: public/login/index');
        }
        $_SESSION['user'] = $validUser[0];
        $_SESSION['role'] = $user->getRole($validUser['employee_id'])[0];
        $_SESSION['emp'] = $validUser['employee_id'];
        if($_SESSION['role'] == 'HR Manager' || $_SESSION['role'] == 'BOSS'){
            header('location: /public/manager/showEmployees/');
        }else{
            header('location: /public/employee/markAttendanceForm/'.$_SESSION['emp']);
        }
    }
}