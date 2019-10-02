<?php

class Employee extends Controller {

    public function markAttendanceForm($empNo = '') {
        $attend = $this->model('Attendance');
        $attend->setEmpno($empNo);
        $details = $attend->getTodayAttendanceDetails();
        $this->view('/employee/attendanceForm',['empNo'=>$empNo,'details'=>$details,'message'=>$_GET['message']]);
    }

    public function markAttendance($empNo = '') {
        $timeIn = $_POST['timeIn'];
        $timeOut = $_POST['timeOut'];
        $todayDate = $_POST['todayDate'];
        $attend = $this->model('Attendance');
        $attend->setTimein($timeIn);
        $attend->setTimeout($timeOut);
        $attend->setDate($todayDate);
        $attend->setStatusid(substr($timeIn,0,2)>11?0:1);
        $attend->setEmpno($empNo);
        $result = $attend->markAttendance();
        if($result){
            header('location: /public/employee/markAttendanceForm/'.$empNo.'?message=Attendance Marked');
        }
    }

}