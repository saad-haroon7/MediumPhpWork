<?php session_start();
if(!isset($_SESSION['user'])){
    header('location: /public/login/index');
}?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app/views/style.css">
    <link rel="stylesheet" href="/app/font-awesome/css/font-awesome.min.css">

</head>
<body>
<header>
    <img src="/app/views/logo.png" width="75" height="75">
    <ul>
<?php
if($_SESSION['role'] == 'HR Manager' || $_SESSION['role'] == 'BOSS'){
    if($_SESSION['role'] == 'HR Manager'){?>
            <li><a href="/public/employee/markAttendanceForm/<?php echo $_SESSION['emp']?>">Mark Attendance</a></li>
        <?php }
    ?>
            <li><a href="/public/manager/addEmployeeForm/">Add Employee</a></li>
            <li><a href="/public/manager/showEmployees/">Show Employee</a></li>
            <li><a href="/public/manager/EmployeesTodayAttendance/">Show Employee Attendance</a></li>
            <li><a href="/public/home/index/">Monthly Reports</a></li>
            <?php
            if(isset($_SESSION['user'])){
                echo '<li><a href="/public/logout/index/">Logout</a></li>';
            }else{
                header('location: /public/login/index');
            }
            ?>
    <?php
}else { ?>
            <li><a href="/public/employee/markAttendanceForm/<?php echo $_SESSION['emp']?>">Mark Attendance</a></li>
            <?php
            if(isset($_SESSION['user'])){
                echo '<li><a href="/public/logout/index/">Logout</a></li>';
            }else{
                header('location: /public/login/index');
            }
            ?>
<?php }?>
    </ul>
</header>
<div class="attendanceDiv">
    <span class="message"><?php echo $data['message']?></span>
    <form action="/public/employee/markAttendance/<?php echo $data['empNo'] ?>" method="post" class="attendanceForm">
        <h1>Mark Attendance</h1>
        <span class="error"></span>
        <div class="attendanceField">
            <label for="timeIn">Time In:</label>
            <input type="time" name="timeIn" id="timeIn" value="<?php echo $data['details']['time_in'] ?>" readonly>
            <i class="fa fa-clock-o fa-2x" id="timeInn" aria-hidden="true"></i><br>
        </div>

        <div class="attendanceField">
            <label for="timeOut">Time Out:</label>
            <input type="time" name="timeOut" id="timeOut" value="<?php echo $data['details']['time_out'] ?>" readonly>
            <i class="fa fa-clock-o fa-2x" id="timeOutt" aria-hidden="true"></i><br>
        </div>
        <div class="attendanceField">
            <label for="todayDate"> Current Date:</label>
            <input type="date" name="todayDate" id="todayDate" value="<?php echo $data['details']['time_in']?>" readonly>
        </div>
        <input type="submit" value="Mark Attendance" id="markAttendance">
    </form>
</div>
<script src="/app/js/jquery-3.4.1.min.js"></script>
<script src="/app/js/main.js"></script>
</body>
</html>