<?php
	// Include the CRC Object class that needs to
	// extended by all classes. This is the super
	// class.
	include_once('crc_constants.mod.php');
	include_once('crc_object.cls.php');
	include_once('crc_mysql.cls.php');

	//******************************************
	// Name: crc_object
	//******************************************
	//
	// Desc: The Admin Object
	// Developer: SMS team
	// Email: cristeab@gmail.com
	// Date: September 22th, 2010
	// Version: 1.0.0
	//
	// Copyright
	// =========
	// This code is copyright, use in part or
	// whole is prohibited without a written
	// concent to the developer.
	//******************************************

	class crc_admin extends crc_object {

		var $m_sql;
		var $m_data;
		var $m_status;		
		var $m_active;
		var $m_profileid;
		var $m_email;
		var $m_studentlist;
		
		function crc_admin($debug) {
			//******************************************
			// Initialization by constructor
			//******************************************
			$this->classname = 'crc_admin';
			$this->classdescription = 'Handle course administration.';
			$this->classversion = '1.0.0';
			$this->classdate = 'September 22th, 2016';
			$this->classdevelopername = 'James';
			$this->classdeveloperemail = 'gjz22cn@hotmail.com';
			$this->_DEBUG = $debug;
			
			$this->m_data['cname'] = '';
			$this->m_data['cdesc'] = '';
			$this->m_data['daytime'] = '';
			$this->m_data['roomname'] = '';
			$this->m_data['syear'] = '';
			$this->m_data['smonth'] = '';
			$this->m_data['sday'] = '';
			$this->m_data['eyear'] = '';
			$this->m_data['emonth'] = '';
			$this->m_data['eday'] = '';
			
			$this->m_data['fname'] = '';
			$this->m_data['lname'] = '';
			$this->m_data['gender'] = 'male';
			$this->m_data['email'] = '';
			$this->m_data['lcode'] = '0040';
			$this->m_data['lprefix'] = '0000';
			$this->m_data['lpostfix'] = '000000';

			if ($this->_DEBUG) {
				echo "DEBUG {crc_admin::constructor}: The class \"crc_admin\" was successfuly created. <br>";
				echo "DEBUG {crc_admin::constructor}: Running in debug mode. <br>";
			}

		}

		function fn_setcourse($post) {
			return false;
		}

		function fn_getcourseid($db, $course) {
			return 0;
		}

		function fn_getroomid($db, $room) {
			return 0;
		}
		
		function fn_getscheduleid($db, $courseid) {
            return 0;
		}
		
		function fn_getcourselist($db) {
            return null;
		}

		function fn_getteacherlist($db) {
            return null;
		}		

		function fn_getstudentlist($db) {
			
			//******************************************
			// Get registered student list
			//******************************************
			
			if ($this->_DEBUG) {
				echo "DEBUG {crc_admin::fn_getstudentlist}: Getting registered student list<br>";
			}

			$closedb = false;
			if($db == null) {
				$db = new crc_mysql($this->_DEBUG);
				$db->fn_connect();
				$closedb = true;
			}
			if ($db->m_mysqlhandle != false) {
				$this->m_sql = 'select profile_uid ' .
								'from ' . MYSQL_PROFILES_TBL . ' as p' . 
								' where (profile_active = "0") and ' .
								'(profile_role_id = "3") ' .
								'order by p.profile_lastname';
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);											
				if (mysql_num_rows($resource) > 0) {					
					$index = 0;
					$this->m_studentlist = '';					
					while ($row = mysql_fetch_array($resource)) {						
						$this->m_studentlist[$index]['lastfirstname'] = $row[0];//lastname, firstname
						$this->m_studentlist[$index]['profileuid'] = $row[0];
						$index++;
					}
				} else {
					$this->m_studentlist = null;
					if ($this->_DEBUG) {
						echo 'ERROR {crc_admin::fn_getstudentlist}: The sql command returned nothing.<br>';
					}
				}
				if ($closedb == true) {
					$db->fn_freesql($resource);
					$db->fn_disconnect();
				}
				return $this->m_studentlist;
			} else {
				if ($closedb == true) {
					$db->fn_disconnect();
				}
				return null;
			}
		}		
		
		function fn_initstaffbi($db, $profileid) {
            $result = false;

			if ($this->_DEBUG) {
				echo "DEBUG {crc_admin::fn_initstaffbi}: init base info for user " . $profileid . "<br>";
			}

			if ($db->m_mysqlhandle != false) {
				$this->m_sql = 'insert into ' . MYSQL_BI_TBL .
                    '(bi_uid) select "' . $profileid .
                    '" from dual where not exists (select bi_uid from ' . MYSQL_BI_TBL .
                    ' where bi_uid="' . $profileid . '")';

				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_errno() != 0) {
					if ($this->_DEBUG) {
						echo 'ERROR {crc_admin::fn_initstaffbi}: Could not init base info. <br>';
					}
					$db->fn_freesql($resource);
                } else {
                    $result = true;
                }
			}

            return $result;
		}

		function fn_getprofileid($db, $username) {
			//******************************************
			// Get profile ID
			//******************************************

			if ($this->_DEBUG) {
				echo "DEBUG {crc_admin::fn_getprofileid}: Retreiving the schedule id for " . $username . "<br>";
			}

			if ($db->m_mysqlhandle != false) {

				$this->m_sql = 'select profile_id from ' . MYSQL_PROFILES_TBL .
							    ' where (profile_uid= "' . $username . '")';

				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_num_rows($resource) > 0) {
					$row = mysql_fetch_row($resource);
					$this->m_profileid = $row[0];
				} else {
					$this->m_profileid = 0;
					if ($this->_DEBUG) {
						echo 'ERROR {crc_admin::fn_getprofileid}: The sql command returned nothing. <br>';
					}
				}
				return $this->m_profileid;
			} else {
				return 0;
			}
		}
		
		function fn_setstudent($post) {

			if ($this->_DEBUG) {
				echo "DEBUG {crc_admin::fn_setstaff}: Setting student information <br>";
			}
				
			$db = new crc_mysql($this->_DEBUG);
			$db->fn_connect();
			$result = true;
			if ($db->m_mysqlhandle != false) {
				if(isset($post['username'])) {
					$this->m_username = $post['username'];
				} else {
					$this->m_username = "";
				}
				if(isset($post['email'])) {
					$this->m_email = $post['email'];
				} else {
					$this->m_email = "";
				}
				$this->m_data['username'] = $this->m_username;
				$this->m_data['email'] = $this->m_email;

				if( $this->m_username == "" ) {
					if ($this->_DEBUG) {
						echo 'ERROR {crc_admin::fn_setstaff}: username is empty.<br>';
					}
					$db->fn_disconnect();
					$this->lasterrmsg = "First or last name is empty";
					return false;
				}
				
				//check for user name
				$this->m_sql = 'select * ' .
							'from ' . MYSQL_PROFILES_TBL . 
							' where (profile_uid = "' . $this->m_username .	'")';
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_num_rows($resource) == 0) {
					//insert student
					$this->m_sql = 'insert into ' . MYSQL_PROFILES_TBL . '(' .
									'profile_uid, ' .
									'profile_email, ' .
									'profile_role_id, profile_rdn) ' .
									'values("' . $this->m_username .
									'","' . $this->m_email .
									'","3","ou=don mills,ou=toronto,ou=ontario,ou=canada,o=crc world")';
					$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
					if (mysql_affected_rows() <= 0) {
						if ($this->_DEBUG) {
							echo 'ERROR {crc_admin::fn_setstaff}: Could not insert student information. <br>';
						}
						$db->fn_freesql($resource);
						$db->fn_disconnect();
						$this->lasterrmsg = "Could not insert student information";
						return false;
					}

					//initialize m_profileid
					$this->fn_getprofileid($db, $this->m_username);
					if ($this->m_profileid == 0) {
						if ($this->_DEBUG) {
							echo 'ERROR {crc_admin::fn_setstaff}: Could not get profile id. <br>';
						}
						$db->fn_freesql($resource);
						$db->fn_disconnect();
						$this->lasterrmsg = "Could not get profile id";
						return false;
                    } else {
                        $result = $this->fn_initstaffbi($db, $this->m_profileid);
                        if (!$result) {
                            if ($this->_DEBUG) {
                                echo 'ERROR {crc_admin::fn_setstaff}: Could not init staff bi. <br>';
                            }
                            $db->fn_freesql($resource);
                            $db->fn_disconnect();
                            $this->lasterrmsg = "Could not init staff bi.";
                            return false;
                        }
                    }
				} else {
					if ($this->_DEBUG) {
						echo 'ERROR {crc_admin::fn_setstaff}: User ' . $this->m_username . ' already exists in database.<br>';
					}
					$this->lasterrmsg = "User " . $this->m_username . " already exists in database.";
					$result = false;
				}
				
				$db->fn_freesql($resource);
				$db->fn_disconnect();
			} else {
				$db->fn_disconnect();
			}
			return $result;
		}
		
		function fn_setstudentschedule($db, $post, $profileid) {
            return false;
		}
	}
?>
