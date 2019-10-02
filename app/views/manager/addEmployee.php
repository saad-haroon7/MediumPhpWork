<?php
session_start();
if(!isset($_SESSION['user'])){
    header('location: /public/login/index');
}
include '../app/models/Department.php';
include '../app/models/Role.php';
include '../app/models/Employee.php';
?>
<!DOCTYPE html>
<head>
    <title>Add Employee</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app/views/style.css">
</head>
<body>
<div class="center">
        <h1>Add Employee</h1>
    <form action="/public/manager/addEmployee" method="post" class="addEmployeeForm" enctype="multipart/form-data">
        <img src="/app/views/logo.png" width="200" height="200"><br>
        <input type="text" name="empname" placeholder="Employee Name" value=""><br>
        <input type="tel" name="salary" placeholder="Salary" value=""><br>
        <input type="email" name="email" placeholder="Email" value=""><br>
        <select name="department">
            <option disabled selected hidden>Select Department</option>
            <?php
                $dept = new Department();
                $result = $dept->getDepartments();
                foreach ($result as $element){
                echo "<option value=".$element["id"].">".$element['department_name']."</option>";
            }
        ?>
        </select>
        <select name="manager">
            <option disabled selected hidden>Select Manager</option>
            <?php
                $man = new Employee();
                $result = $man->getAllManagers();
                foreach ($result as $element){
                    echo "<option value=".$element["id"].">".$element['employee_name']."</option>";
                }
            ?>
        </select>
        <select name="role">
            <option disabled selected hidden>Select Role</option>
            <?php
                $roles = new Role();
                $result = $roles->getAllRoles();
                foreach ($result as $element){
                    echo "<option value=".$element["id"].">".$element['role']."</option>";
                }
            ?>
        </select>
        <input type="file" name="prPic" id="prPic" accept="image/*" onchange="readURL(this)"><br>
        <img src="" id="profilePic" width="50"/><br>
        <input type="submit" value="Add Employee" name="addEmployee">
    </form>
</div>

<script src="/app/js/jquery-3.4.1.min.js"></script>
<script src="/app/js/main.js"></script>
</body>