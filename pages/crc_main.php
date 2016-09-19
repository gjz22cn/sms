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
			[SMS: Main]
		</TITLE>
        <?php
            include_once('../classes/crc_constants.mod.php');
    	    include_once('../common/crc_head_common.php');
        ?>
	</HEAD>
	<BODY>
		<CENTER>
			<TABLE width="100%">
				<TR CLASS="OUTER">
					<?php
						include "data/crc_page_header_band.html";
					?>
				</TR>
				<!-- The Page Content -->
				<TR>
					<?php
						include "data/crc_main_main.html";
					?>
				</TR>
				<!-- The Page Footer -->
				<TR>
					<?php
						include "data/crc_page_footer_band.html";
					?>
				</TR>
			</TABLE>

		</CENTER>
	</BODY>
</HTML>
