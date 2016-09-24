DROP TABLE IF EXISTS `crc_attendance`;
CREATE TABLE `crc_attendance` (
  `attendance_id` int(11) NOT NULL auto_increment,
  `attendance_student_schedule_id` int(11) NOT NULL default '0',
  `attendance_date_id` int(11) NOT NULL default '0',
  `attendance_check` char(1) NOT NULL default 'A',
  PRIMARY KEY  (`attendance_id`)
) ENGINE=MyISAM auto_increment=75 ;

DROP TABLE IF EXISTS `crc_courses`;
CREATE TABLE `crc_courses` (
  `course_id` int(11) NOT NULL auto_increment,
  `course_name` varchar(100) NOT NULL default '',
  `course_desc` varchar(255) default '',
  `course_active` tinyint(1) NOT NULL default '0',
  `course_fee` int(11) NOT NULL default '0',
  PRIMARY KEY  (`course_id`,`course_name`)
) ENGINE=MyISAM auto_increment=13 ;

DROP TABLE IF EXISTS `crc_date`;
CREATE TABLE `crc_date` (
  `date_id` int(11) NOT NULL auto_increment,
  `date_day` char(2) NOT NULL default '',
  `date_month` char(2) NOT NULL default '',
  `date_year` varchar(4) NOT NULL default '',
  PRIMARY KEY  (`date_id`)
) ENGINE=MyISAM auto_increment=14 ;

DROP TABLE IF EXISTS `crc_feedback`;
CREATE TABLE `crc_feedback` (
  `feedback_id` int(11) NOT NULL auto_increment,
  `feedback_profile_id` int(11) NOT NULL default '0',
  `feedback_schedule_id` int(11) NOT NULL default '0',
  `feedback_date` timestamp NOT NULL,
  `feedback_active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`feedback_id`),
  KEY `feedback_profile_id` (`feedback_profile_id`,`feedback_schedule_id`)
) ENGINE=MyISAM COMMENT='This table is facility to store feddback information from st' auto_increment=20 ;

DROP TABLE IF EXISTS `crc_feedback_answers`;
CREATE TABLE `crc_feedback_answers` (
  `feedback_answers_id` int(11) NOT NULL auto_increment,
  `feedback_answers_feedback_id` int(11) NOT NULL default '0',
  `feedback_answers_questions_id` int(11) NOT NULL default '0',
  `feedback_answers_answer` text NOT NULL,
  `feedback_answers_active` tinyint(4) NOT NULL default '0',
  `feedback_answers_comments` text NOT NULL,
  PRIMARY KEY  (`feedback_answers_id`)
) ENGINE=MyISAM auto_increment=449 ;

DROP TABLE IF EXISTS `crc_feedback_questions`;
CREATE TABLE `crc_feedback_questions` (
  `feedback_questions_id` int(11) NOT NULL auto_increment,
  `feedback_questions_question` text NOT NULL,
  `feedback_questions_active` tinyint(1) NOT NULL default '0',
  `feedback_questions_type` varchar(100) NOT NULL default 'COMMENT',
  `feedback_questions_category` varchar(100) NOT NULL default 'COMMENTS',
  `feedback_questions_sequence` int(11) NOT NULL default '0',
  PRIMARY KEY  (`feedback_questions_id`),
  KEY `SEQUENCE` (`feedback_questions_sequence`)
) ENGINE=MyISAM auto_increment=29 ;

INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (1, 'I feel that I have gained new skills and knowledge.', 0, 'OPTION', 'GENERAL', 1);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (2, 'I will recommend the course to other member(s).', 0, 'OPTION', 'GENERAL', 2);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (3, 'I believe the skills that I have learned will help.', 0, 'OPTION', 'GENERAL', 3);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (4, 'The course material was easy to read.', 0, 'OPTION', 'GENERAL', 4);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (5, 'I will be able to use the course materials as a reference.', 0, 'OPTION', 'GENERAL', 5);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (6, 'I felt totally comfortable during the course.', 0, 'OPTION', 'GENERAL', 6);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (7, 'The lesson time frame was appropriate for the course.', 0, 'OPTION', 'GENERAL', 7);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (8, 'My expectations for the course were met.', 0, 'OPTION', 'GENERAL', 8);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (9, 'I understood the course objectives clearly.', 0, 'OPTION', 'OBJECTIVE', 9);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (10, 'I did achieve the course objectives.', 0, 'OPTION', 'OBJECTIVE', 10);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (11, 'The topics presented in the course were relevant to my work.', 0, 'OPTION', 'OBJECTIVE', 11);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (12, 'The course was structured in a logical way.', 0, 'OPTION', 'OBJECTIVE', 12);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (13, 'The course was easy to follow.', 0, 'OPTION', 'OBJECTIVE', 13);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (14, 'The course was interesting and enjoyable.', 0, 'OPTION', 'OBJECTIVE', 14);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (15, 'The concepts and techniques used were explained clearly.', 0, 'OPTION', 'PRESENTATION', 15);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (16, 'I was encouraged to actively participate during the course.', 0, 'OPTION', 'PRESENTATION', 16);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (17, 'My individual questions/problems discussed were satisfactorily answered.', 0, 'OPTION', 'PRESENTATION', 17);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (18, 'The presentation style of the instructor was satisfactory.', 0, 'OPTION', 'PRESENTATION', 18);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (19, 'The instructor\'s knowledge of the subject was satisfactory.', 0, 'OPTION', 'PRESENTATION', 19);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (20, 'The course was well paced.', 0, 'OPTION', 'PRESENTATION', 20);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (21, 'Please comment on what you liked about the course.', 0, 'COMMENT', 'COMMENTS', 21);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (22, 'What improvements would you suggest for this course.', 0, 'COMMENT', 'COMMENTS', 22);
INSERT INTO `crc_feedback_questions` (`feedback_questions_id`, `feedback_questions_question`, `feedback_questions_active`, `feedback_questions_type`, `feedback_questions_category`, `feedback_questions_sequence`) VALUES (23, 'Please provide any additional comments not covered.', 0, 'COMMENT', 'COMMENTS', 23);

DROP TABLE IF EXISTS `crc_profiles`;
CREATE TABLE `crc_profiles` (
  `profile_id` int(11) NOT NULL auto_increment,
  `profile_uid` varchar(100) NOT NULL default '',
  `profile_pwd` varchar(40) NOT NULL default '',
  `profile_email` varchar(100) NOT NULL default '',
  `profile_role_id` int(11) NOT NULL default '0',
  `profile_active` tinyint(1) NOT NULL default '0',
  `profile_rdn` varchar(100) default 'ou=don mills,ou=toronto,ou=ontario,ou=canada,o=crc world',
  `profile_date` timestamp NOT NULL,
  PRIMARY KEY  (`profile_id`,`profile_uid`,`profile_email`)
) ENGINE=MyISAM auto_increment=24 CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO `crc_profiles` (`profile_id`, `profile_uid`, `profile_pwd`, `profile_email`, `profile_role_id`, `profile_active`, `profile_rdn`) VALUES (1, 'admin', SHA1('admin'), 'admin@domain.com',  1, 0, 'ou=don mills,ou=toronto,ou=ontario,ou=canada,o=crc world');

DROP TABLE IF EXISTS `crc_roles`;
CREATE TABLE `crc_roles` (
  `role_id` int(11) NOT NULL auto_increment,
  `role_name` varchar(100) NOT NULL default '',
  `role_desc` varchar(255) NOT NULL default '',
  `role_active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`role_id`,`role_name`)
) ENGINE=MyISAM auto_increment=4 ;

INSERT INTO `crc_roles` (`role_id`, `role_name`, `role_desc`, `role_active`) VALUES (1, 'Administrator', 'CRC Administrator role', 1);
INSERT INTO `crc_roles` (`role_id`, `role_name`, `role_desc`, `role_active`) VALUES (2, 'Teacher', 'CRC Teacher role', 1);
INSERT INTO `crc_roles` (`role_id`, `role_name`, `role_desc`, `role_active`) VALUES (3, 'Student', 'CRC Student role', 1);

DROP TABLE IF EXISTS `crc_rooms`;
CREATE TABLE `crc_rooms` (
  `room_id` int(11) NOT NULL auto_increment,
  `room_name` varchar(100) NOT NULL default '',
  `room_desc` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`room_id`)
) ENGINE=MyISAM auto_increment=3 ;

DROP TABLE IF EXISTS `crc_schedule`;
CREATE TABLE `crc_schedule` (
  `schedule_id` int(11) NOT NULL auto_increment,
  `schedule_course_id` int(11) NOT NULL default '0',
  `schedule_start_date` date NOT NULL default '2010-01-01',
  `schedule_end_date` date NOT NULL default '2010-01-01',
  `schedule_day_time` varchar(30) NOT NULL default 'M,W [8:00PM - 10:00PM]',
  `schedule_status` varchar(100) NOT NULL default 'Tentative',
  `schedule_room_id` int(11) NOT NULL default '2',
  `schedule_active` tinyint(1) NOT NULL default '0',
  `schedule_venue_id` int(11) NOT NULL default '1',
  PRIMARY KEY  (`schedule_id`)
) ENGINE=MyISAM auto_increment=15 ;

DROP TABLE IF EXISTS `crc_sessions`;
CREATE TABLE `crc_sessions` (
  `session_oid` int(11) NOT NULL auto_increment,
  `session_id` varchar(255) NOT NULL default '',
  `session_uid` varchar(15) NOT NULL default '',
  `session_pwd` varchar(15) NOT NULL default '',
  `session_dn` varchar(255) NOT NULL default '',
  `session_time` timestamp NOT NULL,
  PRIMARY KEY  (`session_oid`)
) ENGINE=MyISAM auto_increment=460 ;

DROP TABLE IF EXISTS `crc_states`;
CREATE TABLE `crc_states` (
  `state_id` int(11) NOT NULL auto_increment,
  `state_name` varchar(50) NOT NULL default '',
  `state_desc` text NOT NULL,
  PRIMARY KEY  (`state_id`)
) ENGINE=MyISAM auto_increment=6 ;

DROP TABLE IF EXISTS `crc_student_schedule`;
CREATE TABLE `crc_student_schedule` (
  `student_schedule_id` int(11) NOT NULL auto_increment,
  `student_schedule_profile_id` int(11) NOT NULL default '0',
  `student_schedule_schedule_id` int(11) NOT NULL default '0',
  `student_schedule_paid` char(1) NOT NULL default 'U',
  `student_schedule_amount` int(11) NOT NULL default '0',
  `student_schedule_questions` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`student_schedule_id`)
) ENGINE=MyISAM auto_increment=37 ;

DROP TABLE IF EXISTS `crc_teacher_schedule`;
CREATE TABLE `crc_teacher_schedule` (
  `teacher_schedule_id` int(11) NOT NULL auto_increment,
  `teacher_schedule_profile_id` int(11) NOT NULL default '0',
  `teacher_schedule_schedule_id` int(11) NOT NULL default '0',
  `teacher_schedule_evaluation` int(11) NOT NULL default '0',
  PRIMARY KEY  (`teacher_schedule_id`)
) ENGINE=MyISAM auto_increment=8 ;

DROP TABLE IF EXISTS `crc_venue`;
CREATE TABLE `crc_venue` (
  `venue_id` int(11) NOT NULL auto_increment,
  `venue_name` varchar(100) NOT NULL default '',
  `venue_desc` varchar(100) NOT NULL default '',
  `venue_shortname` varchar(8) NOT NULL default '',
  PRIMARY KEY  (`venue_id`)
) ENGINE=MyISAM auto_increment=2 ;

DROP TABLE IF EXISTS `crc_bi`;
CREATE TABLE `crc_bi` (
  `bi_id` int(11) NOT NULL auto_increment,
  `bi_uid` int(11) NOT NULL default '0',
  `bi_name` varchar(16) NOT NULL default '',
  `bi_birth` varchar(16) NOT NULL default '1950-1',
  `bi_fwd` varchar(16) NOT NULL default '1970-1',
  `bi_no` varchar(64) NOT NULL default '',
  `bi_gs` varchar(128) NOT NULL default '',
  `bi_major` varchar(128) NOT NULL default '',
  `bi_cpro` varchar(128) NOT NULL default '',
  `bi_cpos` varchar(64) NOT NULL default '部门技术质量工程师',
  `bi_psca` varchar(64) NOT NULL default '无',
  `bi_ppscore` float(6,2) NOT NULL default '0',
  `bi_edu` varchar(64) NOT NULL default '其他',
  `bi_eduscore` float(6,2) NOT NULL default '0',
  `bi_cwy` varchar(64) NOT NULL default '无',
  `bi_wti` varchar(64) NOT NULL default '其他',
  `bi_wtiscore` float(6,2) NOT NULL default '0',
  `bi_owy` varchar(64) NOT NULL default '无',
  `bi_eng` varchar(8) NOT NULL default '否',
  `bi_engscore` float(6,2) NOT NULL default '0',
  `bi_wyscore` float(6,2) NOT NULL default '0',
  `bi_bim` varchar(16) NOT NULL default '无',
  `bi_bimscore` float(6,2) NOT NULL default '0',
  `bi_cer` varchar(64) NOT NULL default '无',
  `bi_cer2` varchar(4) NOT NULL default '否',
  `bi_cerscore` float(6,2) NOT NULL default '0',
  `bi_act` varchar(8) NOT NULL default '0',
  `bi_actscore` float(6,2) NOT NULL default '0',
  `bi_actdesc` varchar(1024) NOT NULL default '',
  `bi_tscore` float(6,2) NOT NULL default '0',
  PRIMARY KEY  (`bi_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `crc_rap`;
CREATE TABLE `crc_rap` (
  `rap_id` int(11) NOT NULL auto_increment,
  `rap_uid` int(11) NOT NULL default '0',
  `rap_date` varchar(64) NOT NULL default '',
  `rap_level` varchar(32) NOT NULL default '无',
  `rap_category` varchar(8) NOT NULL default '罚',
  `rap_reason` varchar(512) NOT NULL default '',
  `rap_score` int(4) NOT NULL default '0',
  `rap_entity` varchar(256) NOT NULL default '',
  PRIMARY KEY  (`rap_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `crc_assess`;
CREATE TABLE `crc_assess` (
  `assess_id` int(11) NOT NULL auto_increment,
  `assess_uid` int(11) NOT NULL default '0',
  `assess_lyar` varchar(32) NOT NULL default '其他',
  `assess_lyarscore` float(6,2) NOT NULL default '0',
  `assess_nxkr` int(4) NOT NULL default '0',
  `assess_nxkrscore` float(6,2) NOT NULL default '0',
  `assess_tdzzjs` varchar(64) NOT NULL default '无',
  `assess_tdzzjsscore` float(6,2) NOT NULL default '0',
  `assess_tdxm` varchar(256) NOT NULL default '',
  `assess_tscore` float(6,2) NOT NULL default '0',
  PRIMARY KEY  (`assess_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `crc_workex`;
CREATE TABLE `crc_workex` (
  `workex_id` int(11) NOT NULL auto_increment,
  `workex_uid` int(11) NOT NULL default '0',
  `workex_dure` varchar(64) NOT NULL default '',
  `workex_year` int(4) NOT NULL default '0',
  `workex_position` varchar(64) NOT NULL default '无',
  `workex_desc` varchar(1024) NOT NULL default '',
  `workex_score` int(4) NOT NULL default '0',
  `workex_comment` varchar(512) NOT NULL default '',
  PRIMARY KEY  (`workex_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `crc_projex`;
CREATE TABLE `crc_projex` (
  `projex_id` int(11) NOT NULL auto_increment,
  `projex_uid` int(11) NOT NULL default '0',
  `projex_dure` varchar(64) NOT NULL default '',
  `projex_pname` varchar(128) NOT NULL default '',
  `projex_level` varchar(64) NOT NULL default '无',
  `projex_position` varchar(64) NOT NULL default '无',
  `projex_ext1` int(4) NOT NULL default '0',
  `projex_score` int(4) NOT NULL default '0',
  `projex_comment` varchar(64) NOT NULL default '部分经历(不计分)',
  PRIMARY KEY  (`projex_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `crc_tereex`;
CREATE TABLE `crc_tereex` (
  `tereex_id` int(11) NOT NULL auto_increment,
  `tereex_uid` int(11) NOT NULL default '0',
  `tereex_date` varchar(64) NOT NULL default '',
  `tereex_name` varchar(128) NOT NULL default '',
  `tereex_level` varchar(32) NOT NULL default '无',
  `tereex_position` varchar(64) NOT NULL default '其他研究人员',
  `tereex_content` varchar(1024) NOT NULL default '',
  `tereex_score` int(4) NOT NULL default '0',
  `tereex_comment` varchar(512) NOT NULL default '',
  PRIMARY KEY  (`tereex_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;


DROP TABLE IF EXISTS `crc_bidex`;
CREATE TABLE `crc_bidex` (
  `bidex_id` int(11) NOT NULL auto_increment,
  `bidex_uid` int(11) NOT NULL default '0',
  `bidex_date` varchar(64) NOT NULL default '',
  `bidex_pname` varchar(128) NOT NULL default '',
  `bidex_level` varchar(32) NOT NULL default '无',
  `bidex_position` varchar(32) NOT NULL default '参与',
  `bidex_content` varchar(1024) NOT NULL default '',
  `bidex_score` int(4) NOT NULL default '0',
  `bidex_result` varchar(32) NOT NULL default '陪标',
  PRIMARY KEY  (`bidex_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `crc_sten`;
CREATE TABLE `crc_sten` (
  `sten_id` int(11) NOT NULL auto_increment,
  `sten_uid` int(11) NOT NULL default '0',
  `sten_date` varchar(64) NOT NULL default '',
  `sten_level` varchar(32) NOT NULL default '无',
  `sten_level2` varchar(32) NOT NULL default '三等奖',
  `sten_role` varchar(64) NOT NULL default '项目技术工程师',
  `sten_name` varchar(256) NOT NULL default '',
  `sten_score` int(4) NOT NULL default '0',
  `sten_entity` varchar(256) NOT NULL default '',
  PRIMARY KEY  (`sten_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `crc_sgzzsjj`;
CREATE TABLE `crc_sgzzsjj` (
  `sgzzsjj_id` int(11) NOT NULL auto_increment,
  `sgzzsjj_uid` int(11) NOT NULL default '0',
  `sgzzsjj_date` varchar(64) NOT NULL default '',
  `sgzzsjj_level` varchar(32) NOT NULL default '无',
  `sgzzsjj_level2` varchar(32) NOT NULL default '其他奖',
  `sgzzsjj_name` varchar(256) NOT NULL default '',
  `sgzzsjj_score` int(4) NOT NULL default '0',
  `sgzzsjj_comment` varchar(32) NOT NULL default '优秀专利奖',
  PRIMARY KEY  (`sgzzsjj_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `crc_sfgc`;
CREATE TABLE `crc_sfgc` (
  `sfgc_id` int(11) NOT NULL auto_increment,
  `sfgc_uid` int(11) NOT NULL default '0',
  `sfgc_acceptdate` varchar(64) NOT NULL default '',
  `sfgc_acceptunit` varchar(256) NOT NULL default '',
  `sfgc_level` varchar(32) NOT NULL default '无',
  `sfgc_role` varchar(32) NOT NULL default '其他技术人员',
  `sfgc_pname` varchar(256) NOT NULL default '',
  `sfgc_score` int(4) NOT NULL default '0',
  `sfgc_comment` varchar(512) NOT NULL default '',
  PRIMARY KEY  (`sfgc_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `crc_patent`;
CREATE TABLE `crc_patent` (
  `patent_id` int(11) NOT NULL auto_increment,
  `patent_uid` int(11) NOT NULL default '0',
  `patent_grantdate` varchar(64) NOT NULL default '',
  `patent_no` varchar(256) NOT NULL default '',
  `patent_category` varchar(32) NOT NULL default '无',
  `patent_role` varchar(32) NOT NULL default '无',
  `patent_name` varchar(256) NOT NULL default '',
  `patent_score` int(4) NOT NULL default '0',
  `patent_comment` varchar(512) NOT NULL default '',
  PRIMARY KEY  (`patent_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `crc_conmethod`;
CREATE TABLE `crc_conmethod` (
  `conmethod_id` int(11) NOT NULL auto_increment,
  `conmethod_uid` int(11) NOT NULL default '0',
  `conmethod_date` varchar(64) NOT NULL default '',
  `conmethod_no` varchar(256) NOT NULL default '',
  `conmethod_level` varchar(32) NOT NULL default '无',
  `conmethod_role` varchar(64) NOT NULL default '项目技术工程师',
  `conmethod_name` varchar(256) NOT NULL default '',
  `conmethod_score` int(4) NOT NULL default '0',
  `conmethod_comment` varchar(512) NOT NULL default '',
  PRIMARY KEY  (`conmethod_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `crc_gccy`;
CREATE TABLE `crc_gccy` (
  `gccy_id` int(11) NOT NULL auto_increment,
  `gccy_uid` int(11) NOT NULL default '0',
  `gccy_date` varchar(64) NOT NULL default '',
  `gccy_category` varchar(64) NOT NULL default '用户满意工程',
  `gccy_level` varchar(32) NOT NULL default '无',
  `gccy_role` varchar(64) NOT NULL default '其他技术质量人员',
  `gccy_pname` varchar(256) NOT NULL default '',
  `gccy_score` int(4) NOT NULL default '0',
  `gccy_comment` int(4) NOT NULL default '0',
  PRIMARY KEY  (`gccy_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;


DROP TABLE IF EXISTS `crc_qcta`;
CREATE TABLE `crc_qcta` (
  `qcta_id` int(11) NOT NULL auto_increment,
  `qcta_uid` int(11) NOT NULL default '0',
  `qcta_winningdate` varchar(64) NOT NULL default '',
  `qcta_entity` varchar(256) NOT NULL default '0',
  `qcta_level` varchar(32) NOT NULL default '无',
  `qcta_role` varchar(64) NOT NULL default '项目技术工程师',
  `qcta_name` varchar(256) NOT NULL default '',
  `qcta_score` int(4) NOT NULL default '0',
  `qcta_comment` varchar(512) NOT NULL default '',
  PRIMARY KEY  (`qcta_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
