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
	// Desc: The Staff Object
	// Version: 1.0.0
	//
	//******************************************

	class crc_staff extends crc_object {

		var $m_sql;
		var $m_profileid;
		var $m_uid;		
		var $m_roleid;
		var $m_alldata;
		var $m_workexdata;
		var $m_startmonth;
		var $m_endmonth;
		var $m_status;		

		var $m_data;
		var $m_courseid;
		var $m_coursename;
		var $m_coursedesc;
		var $m_startdate;
		var $m_enddate;
		var $m_daytime;
		var $m_roomid;
		var $m_roomname;
		var $m_roomdesc;
		var $m_active;
		var $m_venueid;
		var $m_coursefee;
		var $m_scheduleid;
		var $m_evaluation;
		
		var $m_firstname;
		var $m_lastname;
		var $m_gender;
		var $m_email;
		var $m_phone;
		
		var $m_courselist;
		var $m_teacherlist;
		var $m_studentlist;
		
		function crc_staff($debug) {
			//******************************************
			// Initialization by constructor
			//******************************************
			$this->classname = 'crc_staff';
			$this->classdescription = 'Handle staff actions.';
			$this->classversion = '1.0.0';
			$this->classdate = 'September 22th, 2010';
			$this->classdevelopername = 'james';
			$this->classdeveloperemail = 'gjz22cn@hotmail.com';
			$this->_DEBUG = $debug;
			
            $this->m_uid = 0;
            $this->m_workexdata['action'] = 'add';
            $this->m_workexdata['workex_id'] = '';
            $this->m_workexdata['workex_uid'] = '';
			$this->m_workexdata['syear'] = '';
			$this->m_workexdata['smonth'] = '';
			$this->m_workexdata['eyear'] = '';
			$this->m_workexdata['emonth'] = '';
			$this->m_workexdata['workex_year'] = '';
			$this->m_workexdata['workex_position'] = '';
			$this->m_workexdata['workex_desc'] = '';
			$this->m_workexdata['workex_score'] = '';
			$this->m_workexdata['workex_comment'] = '';

			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::constructor}: The class \"crc_staff\" was successfuly created. <br>";
				echo "DEBUG {crc_staff::constructor}: Running in debug mode. <br>";
			}

		}

		function fn_getuserinfo($username) {

			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_getuserinfo}: Retreiving the userinfo for " . $username . "<br>";
			}

            $db = new crc_mysql($this->_DEBUG);
            $db->fn_connect();

			if ($db->m_mysqlhandle != false) {
				$this->m_sql = 'select profile_id,profile_uid,profile_role_id from ' . MYSQL_PROFILES_TBL .
							    ' where (profile_uid="' . $username . '")';
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_num_rows($resource) > 0) {
					$row = mysql_fetch_row($resource);
					$this->m_profileid = $row[0];
					$this->m_uid = $row[1];
					$this->m_roleid = $row[2];
                    return true;
				} else {
					$this->m_profileid = 0;
					if ($this->_DEBUG) {
						echo 'ERROR {crc_staff::fn_getuserinfo}: The sql command returned nothing. <br>';
					}
				}
			}

            $db->fn_freesql($resource);
            $db->fn_disconnect();
            return false;
		}

        function fn_getalldata($uid) {
			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_getalldata}: Get all data. <br>";
			}

			$closedb = false;
			if($db == null) {
				$db = new crc_mysql($this->_DEBUG);
				$db->fn_connect();
				$closedb = true;
			}
			if ($db->m_mysqlhandle != 0) {
				$this->m_sql = 'select * ' .
								'from ' . MYSQL_WORKEX_TBL . 
								' where (workex_uid = "' . $uid . '")';
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_num_rows($resource) > 0) {
                    $this->m_alldata['workex'] = array();
                    $index=0;
                    while($row=mysql_fetch_array($resource)){
                        $this->m_alldata['workex'][$index]=$row;
                        $index++;
                    }
				} else {
					if ($this->_DEBUG) {
						echo 'ERROR {crc_admin::fn_getworkexentry}: The sql command returned nothing. <br>';
					}
				}
				if ($closedb == true) {
					$db->fn_freesql($resource);
					$db->fn_disconnect();
				}
			} else {
				if ($closedb == true) {
					$db->fn_disconnect();
				}
				return null;
			}
            return $this->m_alldata;
        }

        function fn_getbione($pid) {
			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_getbione}: Get baseinfo data. <br>";
			}

            $db = new crc_mysql($this->_DEBUG);
            $db->fn_connect();
            $result = null;
            $closedb = true;
			if ($db->m_mysqlhandle != 0) {
				$this->m_sql = 'select * ' .
								'from ' . MYSQL_BI_TBL . 
								' where (bi_uid="' . $pid . '")';
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_num_rows($resource) > 0) {
                    if($row=mysql_fetch_array($resource)){
                        $result=$row;
                    }
				} else {
					if ($this->_DEBUG) {
						echo 'ERROR {crc_admin::fn_getbione}: The sql command returned nothing. <br>';
					}
				}
				if ($closedb == true) {
					$db->fn_freesql($resource);
					$db->fn_disconnect();
				}
			} else {
				if ($closedb == true) {
					$db->fn_disconnect();
				}
			}
            return $result;
        }

		function fn_setbi($post) {
			//******************************************
			// Update the base information
			//******************************************
			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_setbi}: Setting base information <br>";
			}

            if(!isset($post['baseinfo'])) {
				$this->lasterrmsg = "Missing param!";
                return false;
            }

            if (!isset($post['bi_uid'])) {
				$this->lasterrmsg = "Missing param!";
                return false;
            }

            $bi = json_decode($post["baseinfo"], true);
            $setstr = '';

			$db = new crc_mysql($this->_DEBUG);
			$db->fn_connect();
			$result = false;
			if ($db->m_mysqlhandle != false) {
                $pnames=array('bi_name', 'bi_birth', 'bi_fwd', 'bi_no', 'bi_gs', 'bi_major', 'bi_cpro', 'bi_cpos', 'bi_psca', 'bi_edu', 
                    'bi_cwy', 'bi_wti', 'bi_owy', 'bi_eng', 'bi_bim', 'bi_cer', 'bi_cer2', 'bi_act', 'bi_actdesc');

                foreach ($pnames as $pname){ 
                    if(array_key_exists($pname, $bi)) {
                        $setstr = $setstr . ',' . $pname . '="' . $bi[$pname] . '"';
                    }
                }
				$this->m_status = 'In progress';
				
				//set information
                $this->m_sql = 'update ' . MYSQL_BI_TBL . ' set ' . substr($setstr, 1) .
                        ' where bi_uid="' . $post['bi_uid'] . '"';
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);			
				if (mysql_errno() != 0) {
					if ($this->_DEBUG) {
						echo 'ERROR {crc_staff::fn_setbi}: Could not set base information. <br>';
					}
					$db->fn_freesql($resource);
					$db->fn_disconnect();
					$this->lasterrmsg = "Could not set base information";					
					return false;
				}
                $result = true;
				
				$db->fn_freesql($resource);
				$db->fn_disconnect();
			} else {
				$db->fn_disconnect();
				$this->lasterrmsg = "Cannot connect to MySQL database";
			}
			return $result;
        }

		function fn_setworkex($post) {
			//******************************************
			// Update the workex information
			//******************************************

			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_setworkex}: Setting workex information <br>";
			}

            if(!isset($post['action']) || !isset($post['workex_uid'])) {
				$this->lasterrmsg = "Missing param!";
                return false;
            }

            if ($post['action'] != 'edit' && $post['action'] != 'add') {
				$this->lasterrmsg = "Invalid param value!" . $post['action'];
                return false;
            }

            if ($post['action'] == 'edit' && !isset($post['workex_id']) ) {
				$this->lasterrmsg = "Missing param!";
                return false;
            }

			$db = new crc_mysql($this->_DEBUG);
			$db->fn_connect();
			$result = true;
			if ($db->m_mysqlhandle != false) {
				if(isset($post['syear']) && isset($post['smonth'])) {
					$this->m_startmonth = $post['syear'] . '.' . $post['smonth'];
					$this->m_workexdata['syear'] = $post['syear'];
					$this->m_workexdata['smonth'] = $post['smonth'];
				} else {
					$this->m_startmonth = "";
					$this->m_workexdata['syear'] = "";
					$this->m_workexdata['smonth'] = "";
				}
				if(isset($post['eyear']) && isset($post['emonth'])) {
					$this->m_endmonth = $post['eyear'] . '.' . $post['emonth'];
					$this->m_workexdata['eyear'] = $post['eyear'];
					$this->m_workexdata['emonth'] = $post['emonth'];
				} else {
					$this->m_endmonth = "";
					$this->m_workexdata['eyear'] = "";
					$this->m_workexdata['emonth'] = "";
				}
				if(isset($post['workex_year'])) {
					$this->m_workexdata['workex_year'] = $post['workex_year'];
				} else {
					$this->m_workexdata['workex_year'] = "";
				}
				if(isset($post['workex_position'])) {
					$this->m_workexdata['workex_position'] = $post['workex_position'];
				} else {
					$this->m_workexdata['workex_position'] = "";
				}
				if(isset($post['workex_desc'])) {
					$this->m_workexdata['workex_desc'] = $post['workex_desc'];
				} else {
					$this->m_workexdata['workex_desc'] = "";
				}
				if(isset($post['workex_score'])) {
					$this->m_workexdata['workex_score'] = $post['workex_score'];
				} else {
					$this->m_workexdata['workex_score'] = "";
				}
				if(isset($post['workex_comment'])) {
					$this->m_workexdata['workex_comment'] = $post['workex_comment'];
				} else {
					$this->m_workexdata['workex_comment'] = "";
				}
				$this->m_status = 'In progress';
				
				//this data should be restored if something goes wrong
				
				if( ($this->m_workexdata['workex_year'] == "") || 
				    ($this->m_workexdata['syear'] == "") ||
				    ($this->m_workexdata['smonth'] == "") ||
				    ($this->m_workexdata['eyear'] == "") ||
				    ($this->m_workexdata['emonth'] == "") ||
				    ($this->m_workexdata['workex_position'] == "") ||
				    ($this->m_workexdata['workex_desc'] == "") ) {
					return false;
				}

                $this->m_workexdata['workex_dure'] = $this->m_startmonth . '~' . $this->m_endmonth;

				//set information
                if ($post['action'] == 'add') {
                    $this->m_sql = 'insert into ' . MYSQL_WORKEX_TBL . '(' .
                        'workex_uid, workex_dure, ' .
                        'workex_year, workex_position, ' .
                        'workex_desc, workex_score, workex_comment) ' .
                        'values("' . $post['workex_uid'] . '","' . 
                        $this->m_workexdata['workex_dure'] . '","' . 
                        $this->m_workexdata['workex_year'] . '","' . 
                        $this->m_workexdata['workex_position'] . '","' . 
                        $this->m_workexdata['workex_desc'] . '","' . 
                        $this->m_workexdata['workex_score'] . '","' . 
                        $this->m_workexdata['workex_comment'] . '")';
                }
                else {
                    $this->m_sql = 'update ' . MYSQL_WORKEX_TBL . ' set ' .
                        'workex_dure="' . $this->m_workexdata['workex_dure'] . 
                        '",workex_year="' . $this->m_workexdata['workex_year'] . 
                        '",workex_position="' . $this->m_workexdata['workex_position'] . 
                        '",workex_desc="' . $this->m_workexdata['workex_desc'] . 
                        '",workex_score="' . $this->m_workexdata['workex_score'] . 
                        '",workex_comment="' . $this->m_workexdata['workex_comment'] . 
                        '" where workex_id="' . $post['workex_id'] . '" and workex_uid="' . $post['workex_uid'] . '"';
                }
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);			
				if (mysql_errno() != 0) {
					if ($this->_DEBUG) {
						echo 'ERROR {crc_staff::fn_setworkex}: Could not update/insert workex information. <br>';
					}
					$db->fn_freesql($resource);
					$db->fn_disconnect();
					$this->lasterrmsg = "Could not update/insert workec information";					
					return false;
				}
				
				$db->fn_freesql($resource);
				$db->fn_disconnect();
			} else {
				$db->fn_disconnect();
				$result = false;
				$this->lasterrmsg = "Cannot connect to MySQL database";
			}
			return $result;
        }

        function fn_getworkexentry($workex_uid, $workex_id) {
			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_getworkexentry}: Get one workex entry <br>";
			}

            $this->m_workexdata['workex_id'] = $workex_id;
            $this->m_workexdata['workex_uid'] = $workex_uid;

			$closedb = false;
			if($db == null) {
				$db = new crc_mysql($this->_DEBUG);
				$db->fn_connect();
				$closedb = true;
			}
			if ($db->m_mysqlhandle != 0) {
				$this->m_sql = 'select * ' .
								'from ' . MYSQL_WORKEX_TBL . 
								' where (workex_uid = "' . $workex_uid . '" and workex_id = "' . $workex_id . '" ) ';
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_num_rows($resource) > 0) {
					$index = 0;
					while ($row = mysql_fetch_array($resource)) {
                        if($index>0) {
                            if ($this->_DEBUG) {
                                echo 'ERROR {crc_admin::fn_getworkexentry}: More than one entry in workex table. <br>';
                            }
                            break;
                        }
						$this->m_workexdata['workex_id']    = $row[0];
						$this->m_workexdata['workex_uid']   = $row[1];
						$this->m_workexdata['workex_dure']  = $row[2];
						$this->m_workexdata['workex_year']  = $row[3];
						$this->m_workexdata['workex_position']  = $row[4];
						$this->m_workexdata['workex_desc']  = $row[5];
						$this->m_workexdata['workex_score'] = $row[6];
						$this->m_workexdata['workex_comment']  = $row[7];
                        $dure = $this->m_workexdata['workex_dure'];
                        $index1 = strpos($dure, ".");
                        $index2 = strpos($dure, "~");
                        $this->m_workexdata['syear'] = substr($dure, 0, $index1);
                        $this->m_workexdata['smonth'] = substr($dure, $index1+1, $index2-$index1-1);
                        $dure = substr($this->m_workexdata['workex_dure'], $index2+1);
                        $index1 = strpos($dure, ".");
                        $this->m_workexdata['eyear'] = substr($dure, 0, $index1);
                        $this->m_workexdata['emonth'] = substr($dure, $index1+1);
						$index++;
					}
				} else {
					if ($this->_DEBUG) {
						echo 'ERROR {crc_admin::fn_getworkexentry}: The sql command returned nothing. <br>';
					}
				}
				if ($closedb == true) {
					$db->fn_freesql($resource);
					$db->fn_disconnect();
				}
                return $this->m_workexdata;
			} else {
				if ($closedb == true) {
					$db->fn_disconnect();
				}
				return null;
			}
        }

        function fn_deleteworkexentry($workex_uid, $workex_id) {
			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_deleteworkexentry}: delete one workex entry <br>";
			}

            $this->m_workexdata['workex_id'] = $workex_id;
            $this->m_workexdata['workex_uid'] = $workex_uid;

			$closedb = false;
			if($db == null) {
				$db = new crc_mysql($this->_DEBUG);
				$db->fn_connect();
				$closedb = true;
			}
			if ($db->m_mysqlhandle != 0) {
				$this->m_sql = 'delete from ' . MYSQL_WORKEX_TBL . 
								' where (workex_uid = "' . $workex_uid . '" and workex_id = "' . $workex_id . '" ) ';
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
                if (mysql_errno() != 0) {
					if ($this->_DEBUG) {
						echo 'ERROR {crc_admin::fn_deleteworkexentry}: The sql command failed. <br>';
					}
                    $result = false;
				} else {
                    $result = true;
                }
				if ($closedb == true) {
					$db->fn_freesql($resource);
					$db->fn_disconnect();
				}
                return $result;
			} else {
				if ($closedb == true) {
					$db->fn_disconnect();
				}
				return false;
			}
        }

	}
?>
