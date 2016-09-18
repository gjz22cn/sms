<?php
  if(isset($_REQUEST[session_name()])) {
    // There is a session already available
    //session_start();
  } else {
    session_name('crc');
    session_start();
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
	<HEAD>
		<TITLE>
			[SMS: Profile]
		</TITLE>
    <SCRIPT src="../scripts/tools.js" language="JavaScript" type="text/javascript"></SCRIPT>
		<!--LINK HREF="../styles/crc_page_style.css" REL="stylesheet" TYPE="text/css"-->
		<LINK HREF="../styles/crc_main.css" REL="stylesheet" TYPE="text/css">
	</HEAD>
	<BODY>
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
					if (isset($_GET['func']) && 
						(($_GET['func'] == 'studentlist') || ($_GET['func'] == 'editstudent'))) {
						include "data/crc_edit_profile_main.html";	
					} else {
						include "data/crc_profile_main.html";
					}
					?>
				</TR>
				<!-- The Page Footer -->
				<TR CLASS="OUTER">
					<?php
						include "data/crc_page_footer_band.html";
					?>
				</TR>
			</TABLE>

		</CENTER>
	</BODY>
</HTML>
