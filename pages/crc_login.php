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
		<TITLE>
			[SMS: Login]
		</TITLE>
        <?php
    	    include_once('../classes/crc_constants.mod.php');
    	    include_once('../common/crc_head_common.php');
        ?>
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
