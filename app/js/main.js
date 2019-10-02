/*
   It read the cover pic url and show it
   on img tag
 */
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profilePic').attr('src', e.target.result);
            $('#profilePic').attr('height','50');
            $('#profilePic').val(e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}


$(document).ready(function(){

    (function () {
        var date = new Date().toISOString().substring(0, 10),
            field =$('#todayDate');
        field.val(date);
        console.log(field.val());
    })();

    $("#timeInn").click(function () {
        $('.error').css('display','none');
        if($("#timeOut").val()){
            $("#timeOut").val("");
        }
        var hours,minutes,seconds;
        var d = new Date($.now());
        if(d.getHours() < 10){
            hours = '0'+d.getHours()
        }else{
            hours = d.getHours();
        }
        if(d.getMinutes() < 10){
            minutes = '0'+d.getMinutes()
        }else {
            minutes = d.getMinutes();
        }
        if(d.getSeconds() < 10){
            seconds = '0'+d.getSeconds()
        }else {
            seconds = d.getSeconds();
        }
            d = hours+':'+minutes+':'+seconds;

        $("#timeIn").val(d);
    });
    $("#timeOutt").click(function () {
        if ($("#timeIn").val() === ''){
            $(".error").html('Insert Time-In First');
            return;
        }
        var hours,minutes,seconds;
        var d = new Date($.now());
        if(d.getHours() < 10){
            hours = '0'+d.getHours();
        }else{
            hours = d.getHours();
        }
        if(d.getMinutes() < 10){
            minutes = '0'+d.getMinutes();
        }else {
            minutes = d.getMinutes();
        }
        if(d.getSeconds() < 10){
            seconds = '0'+d.getSeconds();
        }else {
            seconds = d.getSeconds();
        }
        d = hours+':'+minutes+':'+seconds;
        $("#timeOut").val(d);
    });
    if( $("#timeIn").val() && $("#timeOut").val() && $("#todayDate").val()){
        $(".message").html('You have marked Attendance');
        $(".message").css('color','green');
        $("#timeInn").off("click");
        $("#timeOutt").off("click");
        $("#markAttendance").attr("disabled","true");
        $("#markAttendance").css('opacity',0.6);
        $("#timeInn").css('opacity',0.6);
        $("#timeOutt").css('opacity',0.6);
    }
    $("#reportSelect").change(function () {
        $("#reportForm").submit();
    })
    /*
show cover pic when change
*/
    $("#profilePic").change(function() {
        readURL(this);
    });

    $("header ul li a").click(function () {
        $(this).addClass('changed');
    });
});