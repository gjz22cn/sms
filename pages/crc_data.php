<?php
if(isset($_REQUEST[session_name()])) {
    // There is a session already available
    session_start();
} else {
    session_name('crc');
    session_start();
}
include_once('../classes/crc_login.cls.php');
include_once('../classes/crc_profile.cls.php');
include_once('../classes/crc_staff.cls.php');

if ($_GET['method'] == 'staff') {
    $staff = new crc_staff(false);
    //$staff = new crc_staff(true);
    if ($_GET['func'] == 'calcscore') {
        $result = $staff->fn_calcstaffscore($_POST);
        if ($result) {
            $staff->m_tscores['ret'] = 0;
            $staff->m_tscores['action'] = 'calcscore';
            echo $_GET['func'] . 'result=' . json_encode($staff->m_tscores);
        } else {
            echo $_GET['func'] . 'result={"ret":8008, "action":"calcscore", "retstr":"' . $staff->lasterrmsg . '"}';
        }
    } else {
        if (isset($_GET['action'])) {
            $pid = 0; $did = 0;
            if (isset($_GET['pid'])) { $pid = $_GET['pid']; }
            if (isset($_GET['did'])) { $did = $_GET['did']; }
            if ($_GET['action'] == 'get') {
                $result= $staff->fn_gettableentry('crcdb.crc_' . $_GET['func'], $_GET['func'], $pid, $did);
                if ($result) {
                    $result['ret'] = 0;
                    $result['action'] = 'get';
                    echo $_GET['func'] . 'result=' . json_encode($result);
                } else {
                    echo $_GET['func'] . 'result={"ret":8008, "action":"get", "retstr":"' . $staff->lasterrmsg . '"}';
                }
            } else if ($_GET['action'] == 'del') {
                $result= $staff->fn_deltableentry('crcdb.crc_' . $_GET['func'], $_GET['func'], $pid, $did);
                if ($result == false) {
                    echo $_GET['func'] . 'result={"ret":8008, "action":"del", "retstr":"' . $staff->lasterrmsg . '"}';
                } else {
                    echo $_GET['func'] . 'result={"ret":0, "action":"del", "retstr":"删除成功!"}';
                }
            }
        } else if (isset($_POST['action'])) {
            if ($_POST['action'] == 'add' || $_POST['action'] == 'edit') {
                if ($_GET['func'] == 'khmgmt') {
                    $result = $staff->fn_setkhmgmt($_POST);
                } else {
                    $result = $staff->fn_settableentry($_POST, $_GET['func']);
                }
                if ($result == false) {
                    echo $_GET['func'] . 'result={"ret":8008, "action":"' . $_POST['action'] . '", "retstr":"' . $staff->lasterrmsg . '"}';
                } else {
                    echo $_GET['func'] . 'result={"ret":0, "action":"' . $_POST['action'] . '", "retstr":"修改成功!"}';
                }
            } else if ($_POST['action'] == 'update') {
                $result = $staff->fn_updatetblentry($_POST, $_GET['func']);
                if ($result == false) {
                    echo $_GET['func'] . 'result={"ret":8008, "retstr":"' . $staff->lasterrmsg . '"}';
                } else {
                    echo $_GET['func'] . 'result={"ret":0, "action":"' . $_POST['action'] .'", "retstr":"修改成功!"}';
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
