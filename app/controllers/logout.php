<?php
session_start();
class Logout extends Controller {
    public function index(){
        if(isset($_SESSION['user'])){
            session_destroy();
            header('location: /public/login/index');
        }
    }
}