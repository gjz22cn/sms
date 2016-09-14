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
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="content-language" content="zh-CN" />
    <?php
    	include_once('../classes/crc_constants.mod.php');
    ?>
    <TITLE>
        [SMS: STAFF]
    </TITLE>
    <SCRIPT src="../scripts/tools.js" language="JavaScript" type="text/javascript"></SCRIPT>
    <!--LINK HREF="../styles/crc_page_style.css" REL="stylesheet" TYPE="text/css"-->
    <LINK HREF="../styles/crc_main.css" REL="stylesheet" TYPE="text/css">
</HEAD>
<?php
if($_GET['method'] == 'workex') {
    include "data/crc_staff_workex.html";
} else if($_GET['method'] == 'addstudent') {
} else {
    include "data/crc_unknown_main.html";
}						
?>
