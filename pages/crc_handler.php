<?php
if(isset($_REQUEST[session_name()])) {
	// There is a session already available
	//session_start();
} else {
	session_name('crc');
	session_start();
}
include_once('../classes/crc_login.cls.php');
include_once('../classes/crc_profile.cls.php');
include_once('../classes/crc_schedule.cls.php');
include_once('../classes/crc_courses.cls.php');
include_once('../classes/crc_teacher.cls.php');
include_once('../classes/crc_evaluation.cls.php');
include_once('../classes/crc_admin.cls.php');
include_once('../classes/crc_staff.cls.php');
include_once('../classes/crc_dbsetup.cls.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<TITLE><?php				
if (isset($_GET['method'])) {
	$title = "SMS: Method->" . $_GET['method'];
}
if (isset($_GET['func'])) {
	$title = $title . " Function->" . $_GET['func'];
}
$title = $title . ". Please wait...";
print '[' . $title . ']';
?></TITLE>
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

	<tr>
		<td align="center"><br>
		<br>
		</th>
	
	</tr>

	<!-- The Page Content -->
	<?php	

	if (isset($_GET['method'])) {

		echo '<table class="tbl">';
		echo '<tr align="center"><td class="error"><b>' . $title . '</b></td></tr>';
		echo '</table>';

		if ($_GET['method'] == 'login') {
			$login = new crc_login(false);
			$result = $login->fn_login($_POST);
			if ($result == false) {
				$_SESSION['msg'] = $login->lasterrmsg;
				echo '<meta http-equiv="refresh" content="0;URL=crc_login.php?' . session_name() . '=' . session_id() . '&uid=' . $_POST['username'] . '">';
			} else {
				$_SESSION['uid'] = $login->m_uid;
				$_SESSION['name'] = $login->m_name;
				$_SESSION['profileid'] = $login->m_profileid;
				$_SESSION['roleid'] = $login->m_roleid;
                $_SESSION['data'] = "";
                $_SESSION['workexdata'] = "";
                $_SESSION['profiledata'] = "";
                //$_SESSION['scheduledata'] = "";
                //$_SESSION['coursesdata'] = "";
                //$_SESSION['teacherscheduledata'] = "";
                //$_SESSION['teacherstudentsdata'] = "";
                //$_SESSION['teacherattendancegetdata'] = "";
                //$_SESSION['evaluation'] = "";
				$_SESSION['msg'] = "";
				$login->m_sess = session_id();
				$login->fn_session();
				echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_staff.php?method=score&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
			}
		} else if ($_GET['method'] == 'register') {
			$_SESSION['msg'] = "";
            $_SESSION['registerdata'] = "";
			if (isset($_GET['func'])) {
				if ($_GET['func'] == 'add') {
					$_SESSION['registerdata'] = $_POST;
					$profile= new crc_profile(true);
					$result = $profile->fn_setacc(true, $_POST);
					if ($result == false) {
						$_SESSION['msg'] = $register->lasterrmsg;
						echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_register.php?' . session_name() . '=' . session_id() . '&uid=' . $_POST['username'] . '">';
					} else {
						$_SESSION['registerdata'] = NULL;
						$_SESSION['msg'] = "注册成功请登录.";
						echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_login.php?' . session_name() . '=' . session_id() . '&uid=' . $_POST['username'] . '">';
					}
				} else {
					echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_unknown.php?' . session_name() . '=' . session_id() . '">';
				}
			} else {
				echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_register.php?' . session_name() . '=' . session_id() . '">';
			}
/* james add start */
		} else if ($_GET['method'] == 'staff') {
            //$staff = new crc_staff(false);
            $staff = new crc_staff(true);
            $staff->fn_getuserinfo($_GET['uid']);

            if ($staff->m_profileid == 0) {
                $_SESSION['msg'] = '无法获取用户(' .  $_GET['uid'] . ')的信息，请重新登陆！';
                echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_login.php">';
            } else {
                $_SESSION['profileid'] = $staff->m_profileid;
                $_SESSION['uid'] = $staff->m_uid;
                $_SESSION['roleid'] = $staff->m_roleid;

                if ($_GET['func'] == 'showaddworkex') {
                    $_SESSION['workexdata'] = $staff->m_workexdata;
                    $_SESSION['workexdata']['action'] = 'add';
                    $_SESSION['workexdata']['workex_uid'] = $staff->m_profileid;
                    echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_staff.php?method=workex&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
                } else if ($_GET['func'] == 'updateworkex') {
                    $result = $staff->fn_setworkex($_POST);
                    if($result == false) {
                        $_SESSION['msg'] = $staff->lasterrmsg;
                    } else {
                        if ($_POST['action'] == 'add') {
                            //$_SESSION['workexdata'] = '';
                            $_SESSION['workexdata']['action'] = 'add';
                            $_SESSION['msg'] = "添加成功";
                        } else {
                            $_SESSION['workexdata'] = $staff->fn_getworkexentry($_POST['action']['workex_uid'], $_POST['action']['workex_id']);
                            $_SESSION['workexdata']['action'] = 'edit';
                            $_SESSION['msg'] = "更新成功";
                        }
                    }
                    $_SESSION['workexdata']['workex_uid'] = $staff->m_profileid;
                    echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_staff.php?method=workex&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
                } else if ($_GET['func'] == 'showeditworkex') {
                    if (!isset($_GET['uid']) || !isset($_GET['workex_id']) || !isset($_GET['action'])) {
                    }
                    $_SESSION['workexdata'] = $staff->fn_getworkexentry($_GET['workex_uid'], $_GET['workex_id']);
                    $_SESSION['workexdata']['action'] = 'edit';
                    $_SESSION['workexdata']['workex_uid'] = $staff->m_profileid;
                    echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_staff.php?method=workex&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
                } else if ($_GET['func'] == 'deleteworkex') {
                    $result = $staff->fn_deleteworkexentry($_GET['workex_uid'], $_GET['workex_id']);
                    $_SESSION['staffdata'] = $staff->fn_getalldata($_GET['workex_uid']);
                    echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_staff.php?method=score&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
                } else if ($_GET['func'] == 'score') {
                    $_SESSION['staffdata'] = $staff->fn_getalldata($_SESSION['profileid']);
                    echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_staff.php?method=score&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
                } else if ($_GET['func'] == 'scoreadmin') {
                    echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_staff.php?method=score&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
                } else if ($_GET['func'] == 'scoreadminstatistics') {
                    echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_staff.php?method=showscorestatistics&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
                } else {
                //} else if ($_GET['func'] == 'rap' || $_GET['func'] == 'bidex' ) {
                    /* rap, bidex, projex */
                    /* TODO: all tables entry should be here */
                    if (isset($_GET['action'], $_GET['pid'], $_GET['did'])) {
                        $_SESSION['action'] = $_GET['action'];
                        $_SESSION['pid'] = $_GET['pid'];
                        $_SESSION['did'] = $_GET['did'];
                    } else {
                        $_SESSION['msg'] = "前端错误：缺少参数！";
                    }
                    echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_staff.php?method=' . $_GET['func'] . 
                        '&' . session_name() . '=' . session_id() . 
                        '&uid=' . $_SESSION['uid'] . 
                        '&action=' . $_SESSION['action'] . '&pid=' . $_SESSION['pid'] . '&did=' . $_SESSION['did'] . '">';
                }
            }
/* james add end */
		} else if ($_GET['method'] == 'profile') {
			if ($_GET['func'] == 'get') {
				$_SESSION['msg'] = "";
				$profile = new crc_profile(false);
				$_SESSION['profiledata'] = $profile->fn_getprofile($_SESSION['uid']);
				echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_profile.php?func=get&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
			} else if ($_GET['func'] == 'update') {
				$profile = new crc_profile(false);
				//$profile = new crc_profile(true);
				$result = $profile->fn_setprofile($_POST);

				if ($result == false) {
					$_SESSION['msg'] = $profile->lasterrmsg;
					echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_profile.php?' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
				} else {
					$_SESSION['profiledata'] = $profile->fn_getprofile($_SESSION['uid']);
					$_SESSION['msg'] = "Profile updated successfully!";
					echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_profile.php?' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
				}
			} else if ($_GET['func'] == 'studentlist') {
				$admin = new crc_admin(false);
				$admin->fn_getstudentlist(null);
				$_SESSION['teacherstudentsdata'] = $admin->m_studentlist;
				echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_profile.php?func=studentlist&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
			} else if ($_GET['func'] == 'editstudent') {
				$profile = new crc_profile(false);
				$profile->fn_getprofile($_GET['profileuid']);
				$_SESSION['profiledata'] = $profile->m_data;
				$admin = new crc_admin(false);
				$admin->fn_getcourselist(null);
				$_SESSION['coursesdata'] = $admin->m_courselist;
				$schedule = new crc_schedule(false);
				$schedule->fn_getschedule($profile->m_data[0], 3);
				$_SESSION['scheduledata'] = $schedule->m_data;
				echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_profile.php?func=editstudent&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
			} else if ($_GET['func'] == 'updatestudent') {
				$profile = new crc_profile(false);
				$result_profile = $profile->fn_setprofile($_POST, true);
				$admin = new crc_admin(false);
				$result_admin = $admin->fn_setstudentschedule(null, $_POST, $_POST['profileid']);
				if ($result_profile == false) {
					$_SESSION['msg'] = $profile->lasterrmsg;
					echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_profile.php?method=profile&func=editstudent&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
				} else if ($result_admin == false) {
					$_SESSION['msg'] = $admin->lasterrmsg;
					echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_profile.php?method=profile&func=editstudent&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
				} else {
					$_SESSION['msg'] = "\"" .  $_POST['username'] . "\" updated successfully!";
					echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_handler.php?method=profile&func=studentlist&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
				}
/* james add start */
			} else if ($_GET['func'] == 'accmgmt') {
                //$_SESSION['msg'] = $admin->lasterrmsg;
                echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_profile.php?method=profile&func=accmgmt&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
/* james add end */
			} else {
				echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_unknown.php?' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
			}
		} else if ($_GET['method'] == 'admin') {
			$_SESSION['msg'] = "";

			$admin = new crc_admin(false);
			$_SESSION['data'] = $admin->m_data;//common data: course and student
			if ($_GET['func'] == 'showaddcourse') {
				
				$_SESSION['teacherscheduledata'] = $admin->fn_getteacherlist(null);
				echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_admin.php?method=addcourse&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
				
			} else 	if ($_GET['func'] == 'addcourse') {
								
				$result = $admin->fn_setcourse($_POST);
				if($result == false) {
					$_SESSION['data'] = $admin->m_data;
					$_SESSION['msg'] = $admin->lasterrmsg;
				} else {
					$_SESSION['msg'] = "Course successfully added";
				}
				echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_admin.php?method=addcourse&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
				
			} else if ($_GET['func'] == 'showaddstudent') {
								
				$_SESSION['coursesdata'] = $admin->fn_getcourselist(null);				
				echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_admin.php?method=addstudent&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
								
			} else if ($_GET['func'] == 'addstudent') {
				
				$result = $admin->fn_setstudent($_POST);
				if($result == false) {
					$_SESSION['data'] = $admin->m_data;
					$_SESSION['msg'] = $admin->lasterrmsg;
				} else {
					$_SESSION['msg'] = "Student successfully added";
				}
				echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_admin.php?method=addstudent&' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
								
			} else if ($_GET['func'] == 'dbsetup') {
				
				$dbsetup = new crc_dbsetup(false);
				$result = $dbsetup->fn_dbsetup($_POST['database'], $_POST['password'], $_POST['username'], $_POST['userpassword']);
				if ($result == false) {
					$_SESSION['msg'] = $dbsetup->lasterrmsg;
				} else {
					$_SESSION['msg'] = "success";
				}
				echo '<meta http-equiv="refresh" content="0;URL=../mysql/setup.php?' . session_name() . '=' . session_id() . '">';
				
			} else {
				
				echo '<meta http-equiv="refresh" content="0;URL=crc_unknown.php?' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
				
			}

		} else if ($_GET['method'] == 'evaluation') {

			$_SESSION['msg'] = "";
			$evaluation = new crc_evaluation(false);

			if ($_GET['func'] == 'get') {
				
				$evaluation->fn_getquestions();
				$_SESSION['evaluation'] = $evaluation->m_data;
				echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_evaluation.php?' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '&course=' . $_GET['course'] . '">';

			} else if ($_GET['func'] == 'add') {

				if ($evaluation->fn_setquestions($_SESSION['profileid'], $_POST)) {
					$_SESSION['msg'] = "Thank you! You feedback is important to us and will be communicated accordingly.";
				} else {
					$_SESSION['msg'] = "Sorry, There was an error submittimg your feedback.";
				}
				echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_evaluation.php?' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '&course=' . $_GET['course'] . '">';
				
			} else if ($_GET['func'] == 'getanswers') {

				$_SESSION['evaluation'] = $evaluation->fn_getanswers($_GET['scheduleid']);
				$_SESSION['scheduledata'] = $evaluation->fn_getattendance($_GET['scheduleid']);				
				if (($_SESSION['evaluation'] != null) || ($_SESSION['scheduledata'] != null)) {
					$_SESSION['coursesdata'] = $evaluation->fn_getcoursename($_GET['scheduleid']);
					$_SESSION['data'] = $evaluation->m_studentnb;
				} else {
					$_SESSION['msg'] = "There are no statistics for this course";
				}
				echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_evaluation.php?' . session_name() . '=' . session_id() . '&func=stats">';			
				
			}

		} else if ($_GET['method'] == 'faq') {
			$_SESSION['msg'] = "";

			echo '<meta http-equiv="refresh"' . 'content="0;URL=../faq/index.php?' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';

		} else if ($_GET['method'] == 'events') {
			$_SESSION['msg'] = "";

			echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_events.php?' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';

		} else if ($_GET['method'] == 'team') {
			$_SESSION['msg'] = "";

			echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_team.php?' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';

		} else if ($_GET['method'] == 'help') {
			$_SESSION['msg'] = "";

			echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_help.php?' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';

		} else if ($_GET['method'] == 'logout') {
			$_SESSION['msg'] = "";

			session_unset();
			session_destroy();

			echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_login.php">';

		} else {
			$_SESSION['msg'] = "";
			echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_unknown.php?' . session_name() . '=' . session_id() . '&uid=' . $_SESSION['uid'] . '">';
		}

	} else {
		$_SESSION['msg'] = "";
		echo '<meta http-equiv="refresh"' . 'content="0;URL=crc_unknown.php?' . session_name() . '=' . session_id() . '">';
	}

	?>

	</TR>
</TABLE>

</CENTER>
</BODY>
</HTML>
