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
    	include_once(dirname(__FILE__) . '/../classes/crc_constants.mod.php');
    ?>
		<TITLE>
			[SMS: install]
		</TITLE>
    <SCRIPT src="../scripts/tools.js" language="JavaScript" type="text/javascript"></SCRIPT>
		<LINK HREF="../styles/crc_main.css" REL="stylesheet" TYPE="text/css">
	</HEAD>
	<BODY>
		<CENTER>
			<TABLE width="100%">
				<!-- The Page Header -->
				<TR CLASS="OUTER">
					<?php
						include dirname(__FILE__) . "/../pages/data/crc_page_header_band.html";
					?>
				</TR>

				<!-- The Page Content -->
				<TR CLASS="OUTER">
					<?php
						include dirname(__FILE__) . "/../pages/data/crc_db_setup_main.html";
					?>
				</TR>
				<!-- The Page Footer -->
				<TR CLASS="OUTER">
					<?php
						include dirname(__FILE__) . "/../pages/data/crc_page_footer_band.html";
					?>
				</TR>
			</TABLE>
		</CENTER>
	</BODY>
</HTML>

