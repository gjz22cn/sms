<?php
  if(isset($_REQUEST[session_name()])) {
    // There is a session already available
    session_start();
  } else {
    session_name('crc');
    session_start();
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
    <TITLE>
        [SMS: STAFF]
    </TITLE>
    <?php
    	include_once('../classes/crc_constants.mod.php');
        include_once('../common/crc_head_common.php');
    ?>
</HEAD>
<?php
    if($_GET['method'] == 'workex') {
        include "data/crc_staff_workex.html";
    } else if($_GET['method'] == 'showall') {
        include "data/crc_staff_showall.html";
    } else {
        include "data/crc_unknown_main.html";
    }
?>
