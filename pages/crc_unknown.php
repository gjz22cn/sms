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
			[SMS: Unknown Request]
		</TITLE>
		<LINK HREF="../styles/crc_main.css" REL="stylesheet" TYPE="text/css">
	</HEAD>
	<BODY>
		<CENTER>
			<TABLE CLASS="OUTER">
				<!-- The Page Header -->
				<TR CLASS="OUTER">
					<?php
						include "data/crc_page_header_band.html";
					?>
				</TR>
				<!-- The Page Content -->
				<TR CLASS="OUTER">
					<?php
						include "data/crc_unknown_main.html";
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

