<?php
	//******************************************************
	// This modulle defines all the contants needed
	// by the application. The constants include:
	// APP_, ERR_ and LOG_ delimiters.
	//******************************************************
	
	//******************************************************
	// MYSQL_ Constants (mysql server and database access)
	//******************************************************
	define('MYSQL_SERVER', 'localhost');	
	define('MYSQL_PORT', '3306');	
	define('MYSQL_DB', 'crcdb');
	//define('MYSQL_USER', 'bogdan');	
	//define('MYSQL_PASS', 'ewigkeit');	
	define('MYSQL_USER', 'sms');	
	define('MYSQL_PASS', '1234');	

	//******************************************************
	// APP_ Constants
	//******************************************************
	define('APP_PROJECTNAME', 'Staff Management System');
	define('APP_DIVISION', 'SMS');
	define('APP_DEVELOPMENT_LEAD', 'SMS Team');
	define('APP_VERSION', '2.0.0');
	define('APP_CONTACT_NAME', 'James');
	define('APP_CONTACT_EMAIL', 'gjz22cn@gmail.com');
	define('APP_COPYRIGHT', 'This application is copyright &copy; 2016. Use of any code in part or whole without the written concent of SMS Team is prohibited and against the law.');
	define('APP_PATH', '/sms/');	

	//******************************************************
	// MYSQL_ Constants (other)
	//******************************************************
	
	define('MYSQL_SESSIONS_TBL', 'crcdb.crc_sessions');
	define('MYSQL_PROFILES_TBL', 'crcdb.crc_profiles');
	define('MYSQL_ROLES_TBL', 'crcdb.crc_roles');
	define('MYSQL_ATTENDANCE_TBL', 'crcdb.crc_attendance');
	define('MYSQL_COURSES_TBL', 'crcdb.crc_courses');
	define('MYSQL_DATE_TBL', 'crcdb.crc_date');
	define('MYSQL_ROOMS_TBL', 'crcdb.crc_rooms');
	define('MYSQL_SCHEDULE_TBL', 'crcdb.crc_schedule');
	define('MYSQL_STUDENT_SCHEDULE_TBL', 'crcdb.crc_student_schedule');
	define('MYSQL_TEACHER_SCHEDULE_TBL', 'crcdb.crc_teacher_schedule');
	define('MYSQL_VENUE_TBL', 'crcdb.crc_venue');
	define('MYSQL_FEEDBACK_TBL', 'crcdb.crc_feedback');
	define('MYSQL_FEEDBACK_QUESTIONS_TBL', 'crcdb.crc_feedback_questions');
	define('MYSQL_FEEDBACK_ANSWERS_TBL', 'crcdb.crc_feedback_answers');
	define('MYSQL_KH_TBL', 'crcdb.crc_kh');
	define('MYSQL_KHMGMT_TBL', 'crcdb.crc_khmgmt');
	define('MYSQL_BI_TBL', 'crcdb.crc_bi');
    define('MYSQL_RAP_TBL', 'crcdb.crc_rap');
    define('MYSQL_ASSESS_TBL', 'crcdb.crc_assess');
    define('MYSQL_WORKEX_TBL', 'crcdb.crc_workex');
    define('MYSQL_PROJEX_TBL', 'crcdb.crc_projex');
    define('MYSQL_TEREEX_TBL', 'crcdb.crc_tereex');
    define('MYSQL_BIDEX_TBL', 'crcdb.crc_bidex');
    define('MYSQL_STEN_TBL', 'crcdb.crc_sten');
    define('MYSQL_SGZZSJJ_TBL', 'crcdb.crc_sgzzsjj');
    define('MYSQL_SFGC_TBL', 'crcdb.crc_sfgc');
    define('MYSQL_PATENT_TBL', 'crcdb.crc_patent');
    define('MYSQL_CONMETHOD_TBL', 'crcdb.crc_conmethod');
    define('MYSQL_GCCY_TBL', 'crcdb.crc_gccy');
    define('MYSQL_QCTA_TBL', 'crcdb.crc_qcta');


	//******************************************************
	// ERR_ Constants
	//******************************************************
	define('ERR_LDAP_MISSING_SERVER_NUM', '10000');
	define('ERR_LDAP_MISSING_SERVER_DESC', 'Missing LDAP server name. Call set_serverinfo() to provide servername and port.');
	define('ERR_LDAP_MISSING_PORT_NUM', '10001');
	define('ERR_LDAP_MISSING_PORT_DESC', 'Missing LDAP server port number. Call set_serverinfo() to provide servername and port.');
	define('ERR_LDAP_MISSING_USERNAME_NUM', '10002');
	define('ERR_LDAP_MISSING_USERNAME_DESC', 'Missing LDAP username. Call set_userinfo() to provide servername and port.');
	define('ERR_LDAP_MISSING_PASSWORD_NUM', '10003');
	define('ERR_LDAP_MISSING_PASSWORD_DESC', 'Missing LDAP password. Call set_userinfo() to provide servername and port.');
	define('ERR_LDAP_CONNECT_NUM', '10004');
	define('ERR_LDAP_CONNECT_DESC', 'LDAP connection error. The connection has been lost or does not exists, call fn_connect() to (re)connect.');
	define('ERR_LDAP_DISCONNECT_NUM', '10005');
	define('ERR_LDAP_DISCONNECT_DESC', 'Error disconnecting from LDAP server. The connection has been lost or does not exists.');
	define('ERR_LDAP_MISSING_DN_NUM', '10006');
	define('ERR_LDAP_MISSING_DN_DESC', 'Missing RDN. Enter the RDN using fn_dninfo().');	
	
	define('ERR_MYSQL_MISSING_SERVER_NUM', '20000');
	define('ERR_MYSQL_MISSING_SERVER_DESC', 'Missing MySQL server name. Call set_serverinfo() to provide servername and port.');
	define('ERR_MYSQL_MISSING_PORT_NUM', '20001');
	define('ERR_MYSQL_MISSING_PORT_DESC', 'Missing MySQL server port number. Call set_serverinfo() to provide servername and port.');
	define('ERR_MYSQL_DISCONNECT_NUM', '20005');
	define('ERR_MYSQL_DISCONNECT_DESC', 'Error disconnecting from MySQL server. The connection has been lost or does not exists.');	

	define('ERR_LOGIN_NOUSER_NUM', '50000');
	define('ERR_LOGIN_NOUSER_DESC', '用户不存在,请确认用户名和密码是否正确!');
	define('ERR_PROFILE_NOROLE_NUM', '50001');
	define('ERR_PROFILE_NOROLE_DESC', 'No user found by the provided role id.');
	define('ERR_PROFILE_NOPROFILE_NUM', '50002');
	define('ERR_PROFILE_NOPROFILE_DESC', 'Could not retreive profile information for user with this role id.');
	define('ERR_PROFILE_UPDATE_NUM', '50003');
	define('ERR_PROFILE_UPDATE_DESC', 'Could not update profile information for user with this role id.');
	define('ERR_REGISTER_ADD_NUM', '50004');
	define('ERR_REGISTER_ADD_DESC', 'Could not register user profile information.');
	define('ERR_FEEDBACK_QUESTIONS_NOSECTIONS_NUM', '50005');
	define('ERR_FEEDBACK_QUESTIONS_NOSECTIONS_DESC', 'Could not find any evaluation sections.');
	define('ERR_FEEDBACK_ADD_NUM', '50006');
	define('ERR_FEEDBACK_ADD_DESC', 'Could not add entry into the feedback table.');
	define('ERR_FEEDBACK_UPDATE_NUM', '50007');
	define('ERR_FEEDBACK_UPDATE_DESC', 'Could not update entry into the student_schedule table.');
	define('ERR_REGISTER_USEREXISTS_NUM', '50008');
	define('ERR_REGISTER_USEREXISTS_DESC', 'The email adress you have provided already exists!');

	//******************************************************
	// LOG_ Constants
	//******************************************************
	//TODO

?>


