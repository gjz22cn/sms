<?php
	// Include the CRC Object class that needs to
	// extended by all classes. This is the super
	// class.
	include_once('crc_constants.mod.php');
	include_once('crc_object.cls.php');
	include_once('crc_mysql.cls.php');

	//******************************************
	// Name: crc_profile
	//******************************************
	// Desc: The Profile Object
	//******************************************

	class crc_profile extends crc_object {

		var $m_roleid;
		var $m_uid;
		var $m_pwd;
		var $m_email;
		var $m_rdn;
		var $m_active;
		var $m_sql;
		var $m_data;
		
		function crc_profile($debug) {
			//******************************************
			// Initialization by constructor
			//******************************************
			$this->classname = 'crc_profile';
			$this->classdescription = 'Handle user profile.';
			$this->classversion = '1.0.0';
			$this->classdate = 'Sep 20th, 2016';
			$this->classdevelopername = 'James';
			$this->classdeveloperemail = 'gjz22cn@hotmail.com';
			$this->_DEBUG = $debug;

			if ($this->_DEBUG) {
				echo "DEBUG {crc_profile::constructor}: The class \"crc_profile\" was successfuly created. <br>";
				echo "DEBUG {crc_profile::constructor}: Running in debug mode. <br>";
			}

		}

		function fn_getprofile($uid) {
			//******************************************
			// Get the users profile information
			//******************************************						
			if ($this->_DEBUG) {
				echo "DEBUG {crc_profile::fn_getprofile}: Retreiving the profile of uid: " . $uid . ". <br>";
			}

			$this->m_data = null;			
			$db = new crc_mysql($this->_DEBUG);
			$dbhandle = $db->fn_connect();			
			if ($dbhandle != false) {

				$this->m_sql = 'select * ' . 
								'from ' . MYSQL_PROFILES_TBL . 
								' where (profile_uid = "' . $uid . '")';

				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_num_rows($resource) > 0) {
					$this->m_data = mysql_fetch_array($resource);
				} else {					
					$this->lasterrnum = ERR_PROFILE_NOPROFILE_NUM;
					$this->lasterrmsg = ERR_PROFILE_NOPROFILE_DESC;
					if ($this->_DEBUG) {
						echo 'ERROR {crc_profile::fn_getprofile}: The sql command returned nothing. <br>';
						echo 'ERROR {crc_profile::fn_getprofile}: Error number: ' . $this->lasterrnum . '. <br>';
						echo 'ERROR {crc_profile::fn_getprofile}: Error description: ' . $this->lasterrmsg . '. <br>';
					}
				}
				$db->fn_freesql($resource);
				$db->fn_disconnect();
				
			} else {
				$this->lasterrmsg = mysql_error();
				$this->lasterrnum = mysql_errno();
				if ($this->_DEBUG) {
					echo 'ERROR {crc_profile::fn_setprofile}: ' . $this->lasterrmsg . '.<br>';
				}
			}
			return $this->m_data;
		}

		function fn_setprofile($post, $keepuid = false) {
			//******************************************
			// Update the users profile information
			//******************************************
			if ($this->_DEBUG && isset($post['username'])) {
				echo "DEBUG {crc_profile::fn_updateprofile}: Updating the profile for \"" . $post['username'] . "\". <br>";
			}
			
			//checking input
			if (!isset($post['profileid'], $post['username'], $post['password'], $post['email'])) {
				$this->lasterrmsg = "Incomplete input";
				return false;		
			}
			if ($post['profileid'] == "") {
				$this->lasterrmsg = "Empty profile ID";
				return false;
			}
			if (($post['username'] == "") || ($post['password'] == "") ||
				($post['email'] == "")) {
					$this->lasterrmsg = "";
					return false;
			}			

			$result = false;
			$db = new crc_mysql($this->_DEBUG);
			$dbhandle = $db->fn_connect();
			if ($dbhandle != false) {
				//don't allow users with the same name
				$this->m_sql = 'select * ' . 
								'from ' . MYSQL_PROFILES_TBL . 
								' where (profile_uid= "' . $post['username'] . '")';
				$result = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_num_rows($result) > 0) {
					while ($row = mysql_fetch_array($result)) {
						if ($row[0] != $post['profileid']) {
							$this->lasterrmsg = 'The user ' . $post['username'] . ' already exists in database.';
							$db->fn_freesql($result);
							$db->fn_disconnect();
							return false;
						}						
					}
				}
				
				$this->m_sql = 'update ' . MYSQL_PROFILES_TBL .
								' SET profile_uid="' . $post['username'] . '", profile_pwd=SHA1("' . $post['password'] . '"), ' .
								'profile_email="' . $post['email'] . 
								'" where (profile_id = ' . $post['profileid'] . ')';
				$result = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if ($result) {
					if ($keepuid == false) {
						$_SESSION['uid'] = $post['username'];
					}
				} else {
					$this->lasterrnum = ERR_PROFILE_UPDATE_NUM;
					$this->lasterrmsg = ERR_PROFILE_UPDATE_DESC;
					if ($this->_DEBUG) {
						echo 'ERROR {crc_profile::fn_setprofile}: Could not update profile information for ' . $post['profileid'] . '<br>';
						echo 'ERROR {crc_profile::fn_setprofile}: Error number: ' . $this->lasterrnum . '. <br>';
						echo 'ERROR {crc_profile::fn_setprofile}: Error description: ' . $this->lasterrmsg . '. <br>';
					}
				}
			} else {
				$this->lasterrnum = mysql_errno();
				$this->lasterrmsg = mysql_error();
				if ($this->_DEBUG) {
					echo 'ERROR {crc_profile::fn_setprofile}: ' . $this->lasterrmsg . '.<br>';
				}
			}
			$db->fn_disconnect();
			return $result;
		}

		function fn_getaccs() {
			if ($this->_DEBUG) {
				echo "DEBUG {crc_profile::fn_getaccs}: Retreiving accs info. <br>";
			}

			$result = null;
			$db = new crc_mysql($this->_DEBUG);
			$dbhandle = $db->fn_connect();			
			if ($dbhandle != false) {
				$this->m_sql = 'select profile_id,profile_uid,profile_pwd,profile_email ' . 
                    'from ' . MYSQL_PROFILES_TBL;
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
						echo 'ERROR {crc_profile::fn_getaccs}: The sql command returned nothing. <br>';
					}
				}
				$db->fn_freesql($resource);
				$db->fn_disconnect();
			} else {
				$this->lasterrmsg = mysql_error();
				$this->lasterrnum = mysql_errno();
				if ($this->_DEBUG) {
					echo 'ERROR {crc_profile::fn_getaccs}: ' . $this->lasterrmsg . '.<br>';
				}
			}
			return $result;
        }

		function fn_setacc($isadd, $post) {
            $pid="0";
            $username="";
            $pwd="";
            $email="";

			if ($this->_DEBUG && isset($post['username'])) {
				echo "DEBUG {crc_profile::fn_setacc}: Updating the profile for \"" . $post['username'] . "\". <br>";
			}
			
			//checking input
			if (!isset($post['username'], $post['pwd'])) {
				$this->lasterrmsg = "Incomplete input";
				if ($this->_DEBUG) {
					echo 'ERROR {crc_profile::fn_setacc}: ' . $this->lasterrmsg . '.<br>';
				}
				return false;		
            } else {
                $username=$post['username'];
                $pwd=$post['pwd'];
            }

			if (isset($post['pid'])) {
                $pid = $post['pid'];
            }

            if ($isadd == false) {
                if ($pid == "") {
                    $this->lasterrmsg = "Empty profile ID";
                    if ($this->_DEBUG) {
                        echo 'ERROR {crc_profile::fn_setacc}: ' . $this->lasterrmsg . '.<br>';
                    }
                    return false;
                }
            }

			if (($username == "") ) {
                $this->lasterrmsg = "用户名不能为空";
				if ($this->_DEBUG) {
					echo 'ERROR {crc_profile::fn_setacc}: ' . $this->lasterrmsg . '.<br>';
				}
                return false;
			}

			if (isset($post['email'])) {
                $email=$post['email'];
			}



			$result = false;
			$db = new crc_mysql($this->_DEBUG);
			$dbhandle = $db->fn_connect();
			if ($dbhandle != false) {
				//don't allow users with the same name
				$this->m_sql = 'select * ' . 'from ' . MYSQL_PROFILES_TBL . ' where profile_uid= "' . $username . '"';
				$result = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_num_rows($result) > 0) {
					while ($row = mysql_fetch_array($result)) {
						if ($row[0] != $pid) {
							$this->lasterrmsg = 'The user ' . $username . ' already exists in database.';
                            if ($this->_DEBUG) {
                                echo 'ERROR {crc_profile::fn_setacc}: ' . $this->lasterrmsg . '.<br>';
                            }
							$db->fn_freesql($result);
							$db->fn_disconnect();
							return false;
						}
					}
				}
				
                if ($isadd) {
                    $this->m_sql = 'insert into ' . MYSQL_PROFILES_TBL . 
                                    '(profile_uid,profile_pwd,profile_email,profile_role_id, profile_rdn) ' .
									'values("' . $username . '",SHA1("' . $pwd . '"),"' . $email .
									'","3","ou=don mills,ou=toronto,ou=ontario,ou=canada,o=crc world")';
                } else {
                    if ($pwd == "******") {
                        $this->m_sql = 'update ' . MYSQL_PROFILES_TBL .
								' SET profile_uid="' . $username . '",profile_email="' . $email . 
                                '" where (profile_id = ' . $pid . ')';
                    } else {
                        $this->m_sql = 'update ' . MYSQL_PROFILES_TBL .
								' SET profile_uid="' . $username . '", profile_pwd=SHA1("' . $pwd . '"), ' .
								'profile_email="' . $email . 
                                '" where (profile_id = ' . $pid . ')';
                    }
                }
				$result = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if ($result) {
                    if ($this->fn_initstaffbi($db, $username) == false) {
                        $this->lasterrnum = ERR_REGISTER_ADD_NUM;
						$this->lasterrmsg = ERR_REGISTER_ADD_DESC;
						if ($this->_DEBUG) {
							echo 'ERROR {crc_profile::fn_setprofile}: Could create staff information. <br>';
							echo 'ERROR {crc_profile::fn_setprofile}: Error number: ' . $this->lasterrnum . '. <br>';
							echo 'ERROR {crc_profile::fn_setprofile}: Error description: ' . $this->lasterrmsg . '. <br>';
						}
                    } else {
                        $result = true;
                    }
				} else {
					$this->lasterrnum = ERR_PROFILE_UPDATE_NUM;
					$this->lasterrmsg = ERR_PROFILE_UPDATE_DESC;
					if ($this->_DEBUG) {
						echo 'ERROR {crc_profile::fn_setacc}: Could not update profile information for ' . $pid . '<br>';
						echo 'ERROR {crc_profile::fn_setacc}: Error number: ' . $this->lasterrnum . '. <br>';
						echo 'ERROR {crc_profile::fn_setacc}: Error description: ' . $this->lasterrmsg . '. <br>';
					}
				}
			} else {
				$this->lasterrnum = mysql_errno();
				$this->lasterrmsg = mysql_error();
				if ($this->_DEBUG) {
					echo 'ERROR {crc_profile::fn_setacc}: ' . $this->lasterrmsg . '.<br>';
				}
			}
			$db->fn_disconnect();
			return $result;
		}

		function fn_delacc($post) {
			if ($this->_DEBUG && isset($post['username'])) {
				echo "DEBUG {crc_profile::fn_delacc}: delete the profile for \"" . $post['username'] . "\". <br>";
			}
			
			//checking input
			if (!isset($post['pid'], $post['username'])) {
				$this->lasterrmsg = "Incomplete input";
				if ($this->_DEBUG) {
					echo 'ERROR {crc_profile::fn_delacc}: ' . $this->lasterrmsg . '.<br>';
				}
				return false;		
            }

			$result = false;
			$db = new crc_mysql($this->_DEBUG);
			$dbhandle = $db->fn_connect();
			if ($dbhandle != false) {
				//don't allow users with the same name
				$this->m_sql = 'delete from ' . MYSQL_PROFILES_TBL . 
								' where (profile_uid= "' . $post['username'] . '" and profile_id="' . $post['pid'] . '")';
				$result = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_errno() == 0) {
                    $result = true;
                } else {
                    $this->lasterrmsg = 'del' . $username . ' failed.' . mysql_error();
                    if ($this->_DEBUG) {
                        echo 'ERROR {crc_profile::fn_delacc}: ' . $this->lasterrmsg . '.<br>';
                    }
                }
			} else {
				$this->lasterrnum = mysql_errno();
				$this->lasterrmsg = mysql_error();
				if ($this->_DEBUG) {
					echo 'ERROR {crc_profile::fn_delacc}: ' . $this->lasterrmsg . '.<br>';
				}
			}
			$db->fn_disconnect();
			return $result;
		}

		function fn_initstaffbi($db, $username) {
            return true;
            $result = false;

			if ($this->_DEBUG) {
				echo "DEBUG {crc_profile::fn_initstaffbi}: init base info for user " . $profileid . "<br>";
			}

            if ($db->m_mysqlhandle == false) {
                return $result;
            }

            $this->m_sql = 'select profile_id from ' . MYSQL_PROFILES_TBL . ' where profile_uid="' . $username . '"';
            $resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
            if (mysql_num_rows($resource) > 0) {
                $row = mysql_fetch_row($resource);
                $profileid = $row[0];

				$this->m_sql = 'insert into ' . MYSQL_BI_TBL .
                    '(bi_uid) select "' . $profileid .
                    '" from dual where not exists (select bi_uid from ' . MYSQL_BI_TBL .
                    ' where bi_uid="' . $profileid . '")';

				$resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);
				if (mysql_errno() != 0) {
					if ($this->_DEBUG) {
						echo 'ERROR {crc_profile::fn_initstaffbi}: Could not init base info. <br>';
					}
					$db->fn_freesql($resource);
                } else {
                    $result = true;
                }
            } else {
                if ($this->_DEBUG) {
                    echo 'ERROR {crc_profile::fn_initstaffbi}: The sql command returned nothing. <br>';
                }
            }

            return $result;
		}
	}
?>
