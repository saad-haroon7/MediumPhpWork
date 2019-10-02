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
            <li><a href="/public/manager/monthlyReportForm/">Monthly Reports</a></li>
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
<div class="centerEmpTable">
    <h1>Monthly Leave and Late Statuses</h1>
    <div>
        <form action="/public/manager/monthlyReportForm" id="reportForm">
            <select name="Months" id="reportSelect">
                <option selected hidden value="<?php echo $data['monthlyReport']['monthNum']?>"><?php echo $data['monthlyReport']['monthName']?></option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </form>
    </div>
    <table class="showEmployees">
        <thead>
        <tr>
            <th>
                Late
            </th>
            <th>
                Leave
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $size = sizeof($data['monthlyReport']);
        for($i = 0; $i < $size - 2; $i++){?>
                <?php if($data['monthlyReport'][$i]['status_name'] == 'Late'){?>
                    <tr>
                    <td><a href='/public/manager/showAttendanceDetails/<?php echo $data['monthlyReport'][$i]['employee_id']?>/<?php echo $data['monthlyReport'][$i]['status']?>?Months=<?php echo $data['monthlyReport']['monthNum']?>'>
                        <?php echo $data['monthlyReport'][$i]['empname'] ?></a></td>
                    <?php if($data['monthlyReport'][$i]['empname'] == $data['monthlyReport'][$i+1]['empname']){?>
                        <td><a href='/public/manager/showAttendanceDetails/<?php echo $data['monthlyReport'][$i+1]['employee_id']?>/<?php echo $data['monthlyReport'][$i+1]['status']?>?Months=<?php echo $data['monthlyReport']['monthNum']?>'>
                                <?php echo $data['monthlyReport'][$i+1]['empname'] ?></a></td>
                <?php }else {?> <td>No Leaves</td> <?php }?></tr>
                <?php $i++;}else{?>
                <tr>
                    <td>No Late</td>
                    <td><a href='/public/manager/showAttendanceDetails/<?php echo $data['monthlyReport'][$i]['employee_id']?>/<?php echo $data['monthlyReport'][$i]['status']?>?Months=<?php echo $data['monthlyReport']['monthNum']?>'>
                            <?php echo $data['monthlyReport'][$i]['empname'] ?></a></td>
                </tr>
                <?php }?>
        <?php }
        ?>
        </tbody>
    </table>
</div>
<script src="/app/js/jquery-3.4.1.min.js"></script>
<script src="/app/js/main.js"></script>
</body>
</html>