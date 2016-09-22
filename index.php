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
    <?php
    	include_once('classes/crc_constants.mod.php');
    ?>
		<TITLE>
			[SMS: Welcome to the SMS Website]
		</TITLE>
		<LINK HREF="styles/crc_main.css" REL="stylesheet" TYPE="text/css">
		<SCRIPT src="../scripts/tools.js" language="JavaScript" type="text/javascript"></SCRIPT>
	</HEAD>
	<BODY>
		<CENTER>
			<TABLE width="100%">
				<!-- The Page Header -->
				<TR CLASS="OUTER">
					<?php
						include "pages/data/crc_page_header_band.html";
					?>
				</TR>

				<!-- The Page Content -->
				<TR CLASS="OUTER">
					<?php
						echo '<meta http-equiv="refresh"' . 'content="0;URL=pages/crc_login.php">';
					?>
				</TR>
				<!-- The Page Footer -->
				<TR CLASS="OUTER">
					<?php
						include "pages/data/crc_page_footer_band.html";
					?>
				</TR>
			</TABLE>

		</CENTER>
	</BODY>
</HTML>
