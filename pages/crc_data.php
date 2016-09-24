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
include_once('../classes/crc_profile.cls.php');
//include_once('../classes/crc_schedule.cls.php');
//include_once('../classes/crc_courses.cls.php');
//include_once('../classes/crc_teacher.cls.php');
//include_once('../classes/crc_evaluation.cls.php');
//include_once('../classes/crc_admin.cls.php');
include_once('../classes/crc_staff.cls.php');

if ($_GET['method'] == 'staff') {
    //$staff = new crc_staff(false);
    $staff = new crc_staff(true);
    if ($_GET['func'] == 'getbi') {
        $baseinfo = $staff->fn_getbione($_GET['bi_uid']);
        if ($baseinfo) {
            $baseinfo['ret'] = 0;
            echo 'getbiresult=' . json_encode($baseinfo);
        } else {
            echo 'getbiresult={"ret":8008, "retstr":"获取基本情况信息失败!"}';
        }
    } else if ($_GET['func'] == 'setbi') {
        $result = $staff->fn_setbi($_POST);
        if ($result == false) {
            echo 'setbiresult={"ret":8008, "retstr":"修改基本情况信息失败!"}';
        } else { 
            echo 'setbiresult={"ret":0, "retstr":"修改成功!"}';
        }
    /*
    } else if ($_GET['func'] == 'setrap') {
        $result = $staff->fn_setrap($_POST);
        if ($result == false) {
            echo 'setrapresult={"ret":8008, "retstr":"' . $staff->lasterrmsg . '"}';
        } else {
            echo 'setrapresult={"ret":0, "action":"' . $_POST['action'] .'", "retstr":"修改成功!"}';
        }
    */
    } else {
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'get') {
                $result= $staff->fn_gettableentry('crcdb.crc_' . $_GET['func'], $_GET['func'], $_GET['pid'], $_GET['did']);
                if ($result) {
                    $result['ret'] = 0;
                    $result['action'] = 'get';
                    echo 'get' . $_GET['func'] . 'result=' . json_encode($result);
                } else {
                    echo 'get' . $_GET['func'] . 'result={"ret":8008, "retstr":"' . $staff->lasterrmsg . '"}';
                }
            } else if ($_GET['action'] == 'del') {
                $result= $staff->fn_deltableentry('crcdb.crc_' . $_GET['func'], $_GET['func'], $_GET['pid'], $_GET['did']);
                if ($result == false) {
                    echo 'del' . $_GET['func'] . 'result={"ret":8008, "retstr":"' . $staff->lasterrmsg . '"}';
                } else {
                    echo 'del' . $_GET['func'] . 'result={"ret":0, "action":"del", "retstr":"删除成功!"}';
                }
            }
        } else if (isset($_POST['action'])) {
            if ($_POST['action'] == 'add' || $_POST['action'] == 'edit') {
                $result = $staff->fn_settableentry($_POST, $_GET['func']);
                if ($result == false) {
                    echo 'set' . $_GET['func'] . 'result={"ret":8008, "retstr":"' . $staff->lasterrmsg . '"}';
                } else {
                    echo 'set' . $_GET['func'] . 'result={"ret":0, "action":"' . $_POST['action'] .'", "retstr":"修改成功!"}';
                }
            }
        }
    }
} else if ($_GET['method'] == 'admin') {
    if ($_GET['func'] == 'getaccs') {
        $profile = new crc_profile(true);
        $result = $profile->fn_getaccs();
        if ($result == null) {
            echo 'getaccsresult={"ret":8008, "retstr":"获取帐号信息失败!"}';
        } else {
            $result['ret'] = 0;
            echo 'getaccsresult=' . json_encode($result);
        }
    } else if ($_GET['func'] == 'addacc') {
        $profile = new crc_profile(true);
        $result = $profile->fn_setacc(true, $_POST);
        if ($result == false) {
            echo 'chgaccresult={"ret":8008, "retstr":"添加失败!"}';
        } else {
            echo 'chgaccresult={"ret":0, "action":"add", "retstr":"添加成功!"}';
        }
    } else if ($_GET['func'] == 'setacc') {
        $profile = new crc_profile(true);
        $result = $profile->fn_setacc(false, $_POST);
        if ($result == false) {
            echo 'chgaccresult={"ret":8008, "retstr":"修改失败!"}';
        } else {
            echo 'chgaccresult={"ret":0, "action":"set", "retstr":"修改成功!"}';
        }
    } else if ($_GET['func'] == 'delacc') {
        $profile = new crc_profile(true);
        $result = $profile->fn_delacc($_POST);
        if ($result == false) {
            echo 'chgaccresult={"ret":8008, "retstr":"删除失败!"}';
        } else {
            echo 'chgaccresult={"ret":0, "action":"del", "retstr":"删除成功!"}';
        }
    } else if ($_GET['func'] == 'getsscoreslist') {
        $staff = new crc_staff(true);
        $result = $staff->fn_getsscoreslist();
        if ($result == null) {
            echo 'getsscoreslistresult={"ret":8008, "retstr":"获取帐号信息失败!"}';
        } else {
            $result['ret'] = 0;
            echo 'getsscoreslistresult=' . json_encode($result);
        }
    }
} else {
}
?>
