<?php
if(isset($_REQUEST[session_name()])) {
    // There is a session already available
    session_start();
} else {
    session_name('crc');
    session_start();
}
include_once('../classes/crc_login.cls.php');
//include_once('../classes/crc_register.cls.php');
//include_once('../classes/crc_profile.cls.php');
//include_once('../classes/crc_schedule.cls.php');
//include_once('../classes/crc_courses.cls.php');
//include_once('../classes/crc_teacher.cls.php');
//include_once('../classes/crc_evaluation.cls.php');
//include_once('../classes/crc_admin.cls.php');
include_once('../classes/crc_staff.cls.php');

if($_GET['method'] == 'staff') {
    //$staff = new crc_staff(false);
    $staff = new crc_staff(true);
    if($_GET['func'] == 'getbi') {
        $baseinfo = $staff->fn_getbione($_GET['bi_uid']);
        if ($baseinfo) {
            $baseinfo['ret'] = 0;
            echo 'getbiresult=' . json_encode($baseinfo);
        } else {
            echo 'getbiresult={"ret":8008, "retstr":"获取基本情况信息失败!"}';
        }
    } else if($_GET['func'] == 'setbi') {
        $result = $staff->fn_setbi($_POST);
        if($result == false) {
            echo 'setbiresult={"ret":8008, "retstr":"修改基本情况信息失败!"}';
        } else {
            echo 'setbiresult={"ret":0, "retstr":"修改成功!"}';
        }
    }
} else {
}
?>
