<?php

class Manager extends Controller {
    public function addEmployeeForm(){
        $manager = $this->view('manager/addEmployee');
    }
    public function addEmployee(){
        $name = date('dmYHis').str_replace(" ", "", basename($_FILES["prPic"]["name"]));
        $target = "../app/images/".$name;
        $tmp = $_FILES["prPic"]["tmp_name"];
        move_uploaded_file($tmp, $target);
        $newEmployee = $this->model('Employee');
        $newEmployee->setName($_POST['empname']);
        $newEmployee->setSalary($_POST['salary']);
        $newEmployee->setDept($_POST['department']);
        $newEmployee->setPic($name);
        $newEmployee->setManager($_POST['manager']);
        $newEmployee->setRole($_POST['role']);
        $newEmployee->setEmail($_POST['email']);
        $result = $newEmployee->addEmployee();
        $newEmployee->setEmpno($result);
        if($result > 0){
            $result = $newEmployee->addNewUserAccount($_POST['empname']);
            if($result == 1){
                header('location: /public/manager/showEmployees');
            }
        }else{
            echo 'Wrong Input, Try Again!';
        }
    }
    public function showEmployees(){
        $emp = $this->model('Employee');
        $employee = $emp->showEmployees();
        $this->view('manager/showEmployees',['employee'=>$employee]);
    }

    public function deleteEmployee($empno = ''){
        $employee = $this->model('Employee');
        $employee->setEmpno($empno);
        $result = $employee->deleteEmployee();
        if($result > 0){
            $employee->deleteUserAccount();
            header('location: /public/manager/showEmployees');
        }
    }

    public function editEmployeeForm($empno = ''){
        $employee = $this->model('Employee');
        $result = $employee->getEmployeeDetails($empno);
        if($result > 0){;
            $this->view('/manager/editEmployeeForm',['employee'=>$result]);
        }
    }

    public function editEmployee($empno = ''){
        $newEmployee = $this->model('Employee');
        $newEmployee->setEmpno($empno);
        $newEmployee->setName($_POST['empname']);
        $newEmployee->setSalary($_POST['salary']);
        $newEmployee->setDept($_POST['department']);
        $newEmployee->setManager($_POST['manager']);
        $newEmployee->setRole($_POST['role']);
        $newEmployee->setEmail($_POST['email']);
        if($_FILES['prPic']['name']){
            $name = date('dmYHis').str_replace(" ", "", basename($_FILES["prPic"]["name"]));
            $target = "../app/images/".$name;
            $tmp = $_FILES["prPic"]["tmp_name"];
            move_uploaded_file($tmp, $target);
            $newEmployee->setPic($name);
        }
        $result = $newEmployee->updateEmployee();
        if($result > 0){
           header('location: /public/manager/showEmployees');
        }else{
            echo 'Wrong Input, Try Again!';
        }
    }
    public function EmployeesTodayAttendance() {
        $attendanceData = $this->model('Attendance');
        $result = $attendanceData->getEmployeesTodayAttendance();
        $emp = $this->model('Employee');
        for ($i = 0 ; $i < sizeof($result); $i++){
            $empName = $emp->getEmployeeName($result[$i]['employee_id']);
            $result[$i]['empname'] = $empName;
            $result[$i]['status_name'] = $attendanceData->getStatusName($result[$i]['status']);
        }
        $this->view('manager/showEmployeesTodayAttendance',['todayAttendance'=>$result]);
    }
    public function monthlyReportForm(){
        $data = $this->model('Attendance');
        if($_GET['Months']){
            $month = $_GET['Months'];
        }else{
            $month = date('m');
        }
        $monthlyEmployees = $data->getMonthlyReport($month);
        $emp = $this->model('Employee');
        for ($i = 0 ; $i < sizeof($monthlyEmployees); $i++){
            $empName = $emp->getEmployeeName($monthlyEmployees[$i]['employee_id']);
            $monthlyEmployees[$i]['empname'] = $empName;
            $monthlyEmployees[$i]['status_name'] = $data->getStatusName($monthlyEmployees[$i]['status']);
        }
        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        $monthlyEmployees['monthNum'] = $month;
        $monthlyEmployees['monthName'] = $monthName;
        $this->view('/manager/monthlyReportForm',['monthlyReport'=>$monthlyEmployees]);
    }

    public function markLeave(){
        $late = $this->model('Employee');
        $lateEmployees = $late->getLateEmployeeToday();
        $markLeave = $this->model('Attendance');
        $notifyEmp = $this->model('Email');
        for($i = 0; $i < sizeof($lateEmployees); $i++){
            $empName = $late->getEmployeeName($lateEmployees[$i]['id']);
            if(date('H') >= 12){
                $markLeave->markLeave($lateEmployees[$i]['id']);
                $notifyEmp->notifyManager($lateEmployees[$i]['id']);
            }
            else
                if(date('H') >= 11){
                    $notifyEmp->notifyEmployee($lateEmployees[$i]['id'], $lateEmployees[$i]['email'], $lateEmployees[$i]['employee_name']);
            }
        }
        header('location: /public/manager/monthlyReportForm');
    }
    public function showAttendanceDetails($empno = '',$status = ''){
        $data = $this->model('Attendance');
        if($_GET['Months']){
            $month = $_GET['Months'];
        }else{
            $month = date('m');
        }
        $data->setEmpno($empno);
        $monthlyEmployees = $data->getEmployeeAttendanceDetails($status,$month);
        $emp = $this->model('Employee');
        for ($i = 0 ; $i < sizeof($monthlyEmployees); $i++){
            $empName = $emp->getEmployeeName($monthlyEmployees[$i]['employee_id']);
            $monthlyEmployees[$i]['empname'] = $empName;
            $monthlyEmployees[$i]['status_name'] = $data->getStatusName($monthlyEmployees[$i]['status']);
        }
        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        $monthlyEmployees['monthNum'] = $month;
        $monthlyEmployees['monthName'] = $monthName;
        $this->view('/manager/showEmployeMonthlyAttendanceDetails',['monthlyReport'=>$monthlyEmployees]);
    }
}