<?php
  if(isset($_REQUEST[session_name()])) {
    // There is a session already available
  } else {
    session_name('crc');
    session_start();
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
	<HEAD>
    <?php
    	include_once('../classes/crc_constants.mod.php');
    ?>
		<TITLE>
			[SMS: Login]
		</TITLE>
    <SCRIPT src="../scripts/tools.js" language="JavaScript" type="text/javascript"></SCRIPT>
		<!--LINK HREF="../styles/crc_page_style.css" REL="stylesheet" TYPE="text/css"-->
		<LINK HREF="../styles/crc_main.css" REL="stylesheet" TYPE="text/css">
	</HEAD>
	<BODY onload="javascript:login.username.focus();">
		<CENTER>
			<TABLE width="100%">
				<!-- The Page Header -->
				<TR CLASS="OUTER">
					<?php
						include "data/crc_page_header_band.html";
					?>
				</TR>

				<!-- The Page Content -->
				<TR CLASS="OUTER">
					<?php
						include "data/crc_login_main.html";
					?>
				</TR>
			</TABLE>
		</CENTER>
	</BODY>
</HTML>

