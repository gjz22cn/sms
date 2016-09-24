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
		var $m_startmonth;
		var $m_endmonth;
		var $m_status;		
        var $m_mysqltable;
        var $m_keys;
		
		
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

			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::constructor}: The class \"crc_staff\" was successfuly created. <br>";
				echo "DEBUG {crc_staff::constructor}: Running in debug mode. <br>";
			}

		}

        function fn_getmysqltblandkeysbytablename($table) {
            if ($table == "rap") {
                $this->m_mysqltable = MYSQL_RAP_TBL;
                $this->m_keys= array('rap_date','rap_level','rap_category','rap_reason','rap_entity');
            } else if ($table == "assess") {
                $this->m_mysqltable = MYSQL_ASSESS_TBL;
                $this->m_keys= array('assess_lyar','assess_lyarscore','assess_nxkr','assess_nxkrscore','assess_tdzzjs','assess_tdzzjsscore','assess_tdxm');
            } else if ($table == "workex") {
                $this->m_mysqltable = MYSQL_WORKEX_TBL;
                $this->m_keys= array('workex_dure', 'workex_year', 'workex_position', 'workex_desc', 'workex_comment');
            } else if ($table == "projex") {
                $this->m_mysqltable = MYSQL_PROJEX_TBL;
                $this->m_keys= array('projex_dure', 'projex_pname', 'projex_level', 'projex_position', 'projex_ext1', 'projex_comment');
            } else if ($table == "tereex") {
                $this->m_mysqltable = MYSQL_TEREEX_TBL;
                $this->m_keys= array('tereex_date', 'tereex_name', 'tereex_level', 'tereex_position', 'tereex_content', 'tereex_comment');
            } else if ($table == "bidex") {
                $this->m_mysqltable = MYSQL_BIDEX_TBL;
                $this->m_keys= array('bidex_date','bidex_pname','bidex_level','bidex_position','bidex_content','bidex_result');
            } else if ($table == "sten") {
                $this->m_mysqltable = MYSQL_STEN_TBL;
                $this->m_keys= array('sten_date','sten_level','sten_level2','sten_role','sten_name','sten_entity');
            } else if ($table == "sgzzsjj") {
                $this->m_mysqltable = MYSQL_SGZZSJJ_TBL;
                $this->m_keys= array('sgzzsjj_date','sgzzsjj_level','sgzzsjj_level2','sgzzsjj_name','sgzzsjj_comment');
            } else if ($table == "sfgc") {
                $this->m_mysqltable = MYSQL_SFGC_TBL;
                $this->m_keys= array('sfgc_acceptdate','sfgc_acceptunit','sfgc_level','sfgc_role','sfgc_pname','sfgc_comment');
            } else if ($table == "patent") {
                $this->m_mysqltable = MYSQL_PATENT_TBL;
                $this->m_keys= array('patent_grantdate','patent_no','patent_category','patent_role','patent_name','patent_comment');
            } else if ($table == "conmethod") {
                $this->m_mysqltable = MYSQL_CONMETHOD_TBL;
                $this->m_keys= array('conmethod_date','conmethod_no','conmethod_level','conmethod_role','conmethod_name','conmethod_comment');
            } else if ($table == "gccy") {
                $this->m_mysqltable = MYSQL_GCCY_TBL;
                $this->m_keys= array('gccy_date','gccy_category','gccy_level','gccy_role','gccy_pname','gccy_comment');
            } else if ($table == "qcta") {
                $this->m_mysqltable = MYSQL_QCTA_TBL;
                $this->m_keys= array('qcta_winningdate','qcta_entity','qcta_level','qcta_role','qcta_name','qcta_comment');
            } else {
                return false;
            }

            return true;
        }

		function fn_gettableentry($mysqltable, $table, $pid, $did) {
			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_gettableentry table. }: Retreiving info table=" . $table . " pid=" . $pid . " id=" . $id . ". <br>";
			}

            $filterstr = $table . '_uid="' . $pid . '"';
            if ($did != 0) {
                $filterstr=$filterstr . ' and ' . $table . '_id="' . $did . '"';
            }

			$result = null;
			$db = new crc_mysql($this->_DEBUG);
			$dbhandle = $db->fn_connect();
			if ($dbhandle != false) {
				$this->m_sql = 'select * ' . 
                    'from ' . $mysqltable .
                    ' where ' . $filterstr;
                $resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
                if (mysql_num_rows($resource) > 0) {
                    $result['data'] = array();
					while ($row=mysql_fetch_array($resource)) {
                        $result['data'][] = $row;
                    }
                } else {
					$this->lasterrnum = ERR_PROFILE_NOPROFILE_NUM;
					$this->lasterrmsg = ERR_PROFILE_NOPROFILE_DESC;
					if ($this->_DEBUG) {
						echo 'ERROR {crc_staff::fn_gettableentry}: The sql command returned nothing. <br>';
					}
				}
				$db->fn_freesql($resource);
				$db->fn_disconnect();
			} else {
				$this->lasterrmsg = mysql_error();
				$this->lasterrnum = mysql_errno();
				if ($this->_DEBUG) {
					echo 'ERROR {crc_staff::fn_gettableentry}: ' . $this->lasterrmsg . '. <br>';
				}
			}
			return $result;
        }

		function fn_settableentry($post, $table) {
            $tuidname = $table . '_uid';
            $tidname = $table . '_id';

			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_settableentry}: Setting " . $table . " information. <br>";
			}

            if ($this->fn_getmysqltblandkeysbytablename($table) == false) {
                if ($this->_DEBUG) {
                    echo "DEBUG {crc_staff::fn_settableentry}: unknown table name:" . $table . ". <br>";
                }
                $this->lasterrmsg = "unknown table name: " . $table;
                return false;
            }

            if(!isset($post['action'], $post[$tuidname])) {
				$this->lasterrmsg = "Missing param!";
                return false;
            }

            if ($post['action'] != 'edit' && $post['action'] != 'add') {
				$this->lasterrmsg = "Invalid param value!" . $post['action'];
                return false;
            }

            if ($post['action'] == 'edit' && !isset($post[$tidname]) ) {
				$this->lasterrmsg = "Missing param: " . $tidname . "!";
                return false;
            }

			$db = new crc_mysql($this->_DEBUG);
			$db->fn_connect();
			$result = true;
			if ($db->m_mysqlhandle != false) {
				$this->m_status = 'In progress';
				
				//set information
                if ($post['action'] == 'add') {
                    $keystr = $tuidname;
                    $valstr=$post[$tuidname];
                    foreach ($this->m_keys as $key) {
                        if (isset($post[$key])) {
                            $keystr = $keystr . ', ' . $key;
                            $valstr = $valstr . ', "' . $post[$key] . '"';
                        }
                    }
                    $this->m_sql = 'insert into ' . $this->m_mysqltable . '(' . $keystr . ') values(' . $valstr . ')';
                } else {
                    $setstr='';
                    foreach ($this->m_keys as $key) {
                        if (isset($post[$key])) {
                            $setstr = $setstr . ',' . $key . '="' . $post[$key] . '"';
                        }
                    }
                    $this->m_sql = 'update ' . $this->m_mysqltable . 
                        ' set ' . substr($setstr, 1) .
                        ' where ' . $tidname .'="' . $post[$tidname] . '" and ' . $tuidname . '="' . $post[$tuidname] . '"';
                }
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_errno() != 0) {
					if ($this->_DEBUG) {
						echo "ERROR {crc_staff::fn_settableentry}: Could not update/insert " . $table . " information. <br>";
					}
					$db->fn_freesql($resource);
					$db->fn_disconnect();
					$this->lasterrmsg = "Could not update/insert " . $table . " information";
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

		function fn_updatetblentry($post, $table) {
            $isadd = false;
            $tuidname = $table . '_uid';
            $tidname = $table . '_id';

			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_updatetblentry}: Setting " . $table . " information. <br>";
			}

            if ($this->fn_getmysqltblandkeysbytablename($table) == false) {
                if ($this->_DEBUG) {
                    echo "DEBUG {crc_staff::fn_updatetblentry}: unknown table name:" . $table . ". <br>";
                }
                $this->lasterrmsg = "unknown table name: " . $table;
                return false;
            }

            if(!isset($post['action'], $post[$tuidname])) {
				$this->lasterrmsg = "Missing param!";
                return false;
            }

            if ($post['action'] != 'update') {
				$this->lasterrmsg = "Invalid param value!" . $post['action'];
                return false;
            }

            if (isset($post[$tidname])) {
                if ($post[$tidname] == 0) {
                    $isadd = true;
                }
            }

			$db = new crc_mysql($this->_DEBUG);
			$db->fn_connect();
			$result = true;
			if ($db->m_mysqlhandle != false) {
				$this->m_status = 'In progress';
				
				//set information
                if ($isadd) {
                    $keystr = $tuidname;
                    $valstr=$post[$tuidname];
                    foreach ($this->m_keys as $key) {
                        if (isset($post[$key])) {
                            $keystr = $keystr . ', ' . $key;
                            $valstr = $valstr . ', "' . $post[$key] . '"';
                        }
                    }
                    $this->m_sql = 'insert into ' . $this->m_mysqltable . '(' . $keystr . ') values(' . $valstr . ')';
                } else {
                    $setstr='';
                    foreach ($this->m_keys as $key) {
                        if (isset($post[$key])) {
                            $setstr = $setstr . ',' . $key . '="' . $post[$key] . '"';
                        }
                    }
                    $this->m_sql = 'update ' . $this->m_mysqltable . 
                        ' set ' . substr($setstr, 1) .
                        ' where ' . $tidname .'="' . $post[$tidname] . '" and ' . $tuidname . '="' . $post[$tuidname] . '"';
                }
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_errno() != 0) {
					if ($this->_DEBUG) {
						echo "ERROR {crc_staff::fn_updatetblentry}: Could not update/insert " . $table . " information. <br>";
					}
					$db->fn_freesql($resource);
					$db->fn_disconnect();
					$this->lasterrmsg = "Could not update/insert " . $table . " information";
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

        function fn_deltableentry($mysqltable, $table, $pid, $id) {
			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_deltableentry table. }: delete one " . $table . " entry pid=" . $pid . " id=" . $id . ". <br>";
			}

            if ( $pid == null || $id == null) {
				$this->lasterrmsg = "Missing param!";
                return false;
            }

			$result = false;
            $db = new crc_mysql($this->_DEBUG);
            $db->fn_connect();
            $result = false;
			if ($db->m_mysqlhandle != 0) {
				$this->m_sql = 'delete from ' . $mysqltable . 
								' where (' . $table . '_uid = "' . $pid . '" and ' . $table . '_id = "' . $id . '" ) ';
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
                if (mysql_errno() != 0) {
					if ($this->_DEBUG) {
						echo 'ERROR {crc_admin::fn_deltableentry}: The sql command failed. <br>';
					}
				} else {
                    $result = true;
                }
                $db->fn_freesql($resource);
			}
            $db->fn_disconnect();
            return $result;
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


		function fn_setrap($post) {
			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_setrap}: Setting rap information <br>";
			}

            if(!isset($post['action'], $post['rap_uid'])) {
				$this->lasterrmsg = "Missing param!";
                return false;
            }

            if ($post['action'] != 'edit' && $post['action'] != 'add') {
				$this->lasterrmsg = "Invalid param value!" . $post['action'];
                return false;
            }

            if ($post['action'] == 'edit' && !isset($post['rap_id']) ) {
				$this->lasterrmsg = "Missing param!";
                return false;
            }

			$db = new crc_mysql($this->_DEBUG);
			$db->fn_connect();
			$result = true;
			if ($db->m_mysqlhandle != false) {
				$this->m_status = 'In progress';
                $keys= array('rap_date','rap_level','rap_category','rap_reason','rap_entity');
				
				//set information
                if ($post['action'] == 'add') {
                    $keystr='rap_uid';
                    $valstr=$post['rap_uid'];
                    foreach ($keys as $key) {
                        if (isset($post[$key])) {
                            $keystr = $keystr . ', ' . $key;
                            $valstr = $valstr . ', "' . $post[$key] . '"';
                        }
                    }
                    $this->m_sql = 'insert into ' . MYSQL_RAP_TBL . '(' . $keystr . ') values(' . $valstr . ')';
                } else {
                    $setstr='';
                    foreach ($keys as $key) {
                        if (isset($post[$key])) {
                            $setstr = $setstr . ',' . $key . '="' . $post[$key] . '"';
                        }
                    }
                    $this->m_sql = 'update ' . MYSQL_RAP_TBL . 
                        ' set ' . substr($setstr, 1) .
                        ' where rap_id="' . $post['rap_id'] . '" and rap_uid="' . $post['rap_uid'] . '"';
                }
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_errno() != 0) {
					if ($this->_DEBUG) {
						echo 'ERROR {crc_staff::fn_setrap}: Could not update/insert rap information. <br>';
					}
					$db->fn_freesql($resource);
					$db->fn_disconnect();
					$this->lasterrmsg = "Could not update/insert rap information";
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

		function fn_setbidex($post) {
            $table = 'bidex';
            $tuidname = $table . '_uid';
            $tidname = $table . '_id';

			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_setbidex}: Setting bidex information <br>";
			}

            if(!isset($post['action'], $post[$tuidname])) {
				$this->lasterrmsg = "Missing param!";
                return false;
            }

            if ($post['action'] != 'edit' && $post['action'] != 'add') {
				$this->lasterrmsg = "Invalid param value!" . $post['action'];
                return false;
            }

            if ($post['action'] == 'edit' && !isset($post[$tidname]) ) {
				$this->lasterrmsg = "Missing param!";
                return false;
            }

			$db = new crc_mysql($this->_DEBUG);
			$db->fn_connect();
			$result = true;
			if ($db->m_mysqlhandle != false) {
				$this->m_status = 'In progress';
                $keys= array('bidex_date','bidex_pname','bidex_level','bidex_position','bidex_content','bidex_result');
				
				//set information
                if ($post['action'] == 'add') {
                    $keystr = $tuidname;
                    $valstr=$post[$tuidname];
                    foreach ($keys as $key) {
                        if (isset($post[$key])) {
                            $keystr = $keystr . ', ' . $key;
                            $valstr = $valstr . ', "' . $post[$key] . '"';
                        }
                    }
                    $this->m_sql = 'insert into ' . MYSQL_BIDEX_TBL . '(' . $keystr . ') values(' . $valstr . ')';
                } else {
                    $setstr='';
                    foreach ($keys as $key) {
                        if (isset($post[$key])) {
                            $setstr = $setstr . ',' . $key . '="' . $post[$key] . '"';
                        }
                    }
                    $this->m_sql = 'update ' . MYSQL_BIDEX_TBL . 
                        ' set ' . substr($setstr, 1) .
                        ' where ' . $tidname .'="' . $post[$tidname] . '" and ' . $tuidname . '="' . $post[$tuidname] . '"';
                }
				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_errno() != 0) {
					if ($this->_DEBUG) {
						echo 'ERROR {crc_staff::fn_setbidex}: Could not update/insert bidex information. <br>';
					}
					$db->fn_freesql($resource);
					$db->fn_disconnect();
					$this->lasterrmsg = "Could not update/insert bidex information";
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

		function fn_getsscoreslist() {
			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_getsscoreslist}: select list. <br>";
			}

			$result = null;
			$db = new crc_mysql($this->_DEBUG);
			$dbhandle = $db->fn_connect();			
			if ($dbhandle != false) {
				$this->m_sql = 'select bi_uid,bi_name,bi_no ' . 
                    'from ' . MYSQL_BI_TBL;
                $resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
                if (mysql_num_rows($resource) > 0) {
                    $result['data'] = array();
					while ($row=mysql_fetch_array($resource)) {
                        $result['data'][] = $row;
                    }
                } else {					
					$this->lasterrnum = ERR_PROFILE_NOPROFILE_NUM;
					$this->lasterrmsg = ERR_PROFILE_NOPROFILE_DESC;
					if ($this->_DEBUG) {
						echo 'ERROR {crc_staff::fn_getsscoreslist}: The sql command returned nothing. <br>';
					}
				}
				$db->fn_freesql($resource);
				$db->fn_disconnect();
			} else {
				$this->lasterrmsg = mysql_error();
				$this->lasterrnum = mysql_errno();
				if ($this->_DEBUG) {
					echo 'ERROR {crc_staff::fn_getsscoreslist}: ' . $this->lasterrmsg . '.<br>';
				}
			}
			return $result;
        }
	}
?>
