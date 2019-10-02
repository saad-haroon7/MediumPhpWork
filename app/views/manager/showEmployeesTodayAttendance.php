<?php session_start();
if(!isset($_SESSION['user'])){
    header('location: /public/login/index');
}?>
<!DOCTYPE html>
<html>
<head>
    <title>Show Employees</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app/views/style.css">
</head>
<body>
<header>
    <img src="/app/views/logo.png" width="75" height="75">
    <ul>
        <?php if($_SESSION['role'] == 'HR Manager'){?>
            <li><a href="/public/employee/markAttendanceForm/<?php echo $_SESSION['emp']?>">Mark Attendance</a></li>
        <?php } ?>
        <li><a href="/public/manager/addEmployeeForm/">Add Employee</a></li>
        <li><a href="/public/manager/showEmployees/">Show Employee</a></li>
        <li><a href="/public/manager/EmployeesTodayAttendance/">Show Employee Attendance</a></li>
        <li><a href="/public/manager/monthlyReportForm/">Monthly Reports</a></li>
        <?php
        if(isset($_SESSION['user'])){
            echo '<li><a href="/public/logout/index/">Logout</a></li>';
        }
        ?>
    </ul>
</header>
<div class="centerEmpTable">
    <table class="showEmployees">
        <thead>
        <tr>
            <th>
                Empname
            </th>
            <th>
                Time In
            </th>
            <th>
                Time Out
            </th>
            <th>
                Date
            </th>
            <th>
                Status
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $size = sizeof($data['todayAttendance']);
        for($i = 0; $i < $size; $i++){?>
            <tr>
                <td><?php echo $data['todayAttendance'][$i]['empname'] ?></td>
                <td><?php echo $data['todayAttendance'][$i]['time_in']?></td>
                <td><?php echo $data['todayAttendance'][$i]['time_out'] ?></td>
                <td><?php echo $data['todayAttendance'][$i]['date'] ?></td>
                <td><?php echo $data['todayAttendance'][$i]['status_name'] ?></td>
            </tr>
        <?php }
        ?>
        </tbody>
    </table>
</div>

<script src="/app/js/jquery-3.4.1.min.js"></script>
<script src="/app/js/main.js"></script>
</body>
</html>