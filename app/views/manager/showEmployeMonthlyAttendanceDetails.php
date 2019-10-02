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
<div class="centerEmpTable">
        <h1>Monthly <?php echo $data['monthlyReport'][0]['status_name'] ?> Statuses</h1>
    <div>
        <form action="/public/manager/monthlyReportForm" id="reportForm">
            <select name="Months" id="reportSelect" disabled>
                <option selected hidden value="<?php echo $data['monthlyReport']['monthNum']?>"><?php echo $data['monthlyReport']['monthName']?></option>
            </select>
        </form>
    </div>
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
            $size = sizeof($data['monthlyReport']);
            for($i = 0; $i < $size - 2; $i++){?>
                <tr>
                    <td><?php echo $data['monthlyReport'][$i]['empname'] ?></td>
                    <td><?php echo $data['monthlyReport'][$i]['time_in']?></td>
                    <td><?php echo $data['monthlyReport'][$i]['time_out'] ?></td>
                    <td><?php echo $data['monthlyReport'][$i]['date'] ?></td>
                    <td><?php echo $data['monthlyReport'][$i]['status_name'] ?></td>
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