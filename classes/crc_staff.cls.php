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

        var $m_tscores;
        var $m_tables=array('bi','rap','assess','workex','projex','tereex','bidex','sten','sgzzsjj','sfgc','patent','conmethod','gccy','qcta');
        var $m_tempscore;
		
		
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

            foreach ($this->m_tables as $table) {
                $this->m_tscores[$table . '_tscore'] = 0;
            }

            $this->m_tscores['score0'] = 0;
            $this->m_tscores['score1'] = 0;
            $this->m_tscores['score2'] = 0;
            $this->m_tscores['score3'] = 0;
            $this->m_tscores['score4'] = 0;
			
            $this->m_uid = 0;

			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::constructor}: The class \"crc_staff\" was successfuly created. <br>";
				echo "DEBUG {crc_staff::constructor}: Running in debug mode. <br>";
			}

		}

        function fn_getmysqltblandkeysbytablename($table) {
            /* TODO: gen from mysql table itself? */
            if ($table == "bi") {
                $this->m_mysqltable = MYSQL_BI_TBL;
                $this->m_keys= array('bi_name','bi_birth','bi_fwd','bi_no','bi_gs','bi_major','bi_cpro','bi_cpos','bi_psca',
                    'bi_ppscore','bi_edu','bi_eduscore','bi_cwy','bi_wti','bi_wtiscore','bi_owy','bi_eng','bi_engscore',
                    'bi_wyscore','bi_bim','bi_bimscore','bi_cer','bi_cer2','bi_cerscore','bi_act','bi_actscore','bi_actdesc','bi_tscore');
            } else if ($table == "rap") {
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

        function fn_calcstaffscore($pid) {
			if ($this->_DEBUG) {
				echo "DEBUG {crc_staff::fn_calcstaffscore}: Get baseinfo data. <br>";
			}

            $db = new crc_mysql($this->_DEBUG);
            $db->fn_connect();
			if ($db->m_mysqlhandle == 0) {
                $this->lasterrmsg = "db->m_mysqlhandle is null!";
                return false;
            }

            foreach ($this->m_tables as $table) {
                if ($this->fn_calcscoretable($db, $pid, $table) == false) {
                    $db->fn_disconnect();
                    return false;
                }
            }
            $db->fn_disconnect();
            $this->lasterrmsg = "";
            $this->m_tscores['score1'] = $this->m_tscores['bi_tscore']+$this->m_tscores['rap_tscore'];
            $this->m_tscores['score2'] = $this->m_tscores['assess_tscore'];
            $this->m_tscores['score3'] = $this->m_tscores['workex_tscore']+$this->m_tscores['projex_tscore']+
                $this->m_tscores['tereex_tscore']+$this->m_tscores['bidex_tscore'];
            $this->m_tscores['score4'] = $this->m_tscores['sten_tscore']+$this->m_tscores['sgzzsjj_tscore']+
                $this->m_tscores['sfgc_tscore']+$this->m_tscores['patent_tscore']+
                $this->m_tscores['conmethod_tscore']+$this->m_tscores['gccy_tscore'];
                $this->m_tscores['qcta_tscore'];
            $this->m_tscores['score0'] = $this->m_tscores['score1'] + $this->m_tscores['score2'] + $this->m_tscores['score3'] + $this->m_tscores['score4'] ;
            return true;
        }

        function fn_calctablescore($table, $row) {
            $resultext=null;
            $score = 0;
            if ($table == "bi") {
                $ppscore = '{"项目总工":{"特大型":8,"大型":6,"中小型":4},"项目质量总监":{"特大型":6,"大型":4,"中小型":3}}';
                $eduscore = '{"博士及以上":5, "硕士":4, "本科":3, "大专及以下":1}';
                $gnscore = '{"12年以上":10,"8-12年（不含）":8,"4-8年（不含）":6,"4年以下":4}';
                $gnscore1 = '{"12年以上":4,"8-12年（不含）":3,"4-8年（不含）":2,"4年以下":1}';
                $zcscore = '{"教授级高工":10,"高级工程师":8,"中级工程师":5}';
                $bimscore = '{"一级":5,"二级":10,"三级":20}';

                $ppscore = json_decode($ppscore, true);
                $eduscore = json_decode($eduscore, true);
                $gnscore = json_decode($gnscore, true);
                $gnscore1 = json_decode($gnscore1, true);
                $zcscore = json_decode($zcscore, true);
                $bimscore = json_decode($bimscore, true);

                $score1=0;$score2=0;
                $pps_score=0;$edu_score=0;$gn_score=0;$zc_score=0;$eng_score=0;$bim_score=0;$cer_score=0;$act_score=0;

                if (isset($ppscore[$row['bi_cpos']])) {
                    if (isset($ppscore[$row['bi_cpos']][$row['bi_psca']])) {
                        $pps_score = [$row['bi_cpos']][$row['bi_psca']];
                    }
                }

                if (isset($eduscore[$row['bi_edu']])) {
                    $edu_score = $eduscore[$row['bi_edu']];
                }

                if (isset($gnscore[$row['bi_cwy']])) {
                    $score1 = $gnscore[$row['bi_cwy']];
                }
                if (isset($gnscore1[$row['bi_owy']])) {
                    $score2 = $gnscore1[$row['bi_owy']];
                }
                $gn_score = $score1 + $score2;

                if (isset($zcscore[$row['bi_wti']])) {
                    $zc_score = $zcscore[$row['bi_wti']];
                }

                if ($row['bi_eng'] == "是") {
                    $eng_score = 3;
                }

                if (isset($bimscore[$row['bi_bim']])) {
                    $bim_score = $bimscore[$row['bi_bim']];
                }

                if ($row['bi_cer'] != "无") {
                    if ($row['bi_cer2'] == "是") {
                        $cer_score = 7;
                    } else {
                        $cer_score = 6;
                    }
                }

                $act_score = $row['bi_act'];

                $score = $pps_score+$edu_score+$gn_score+$zc_score+$eng_score+$bim_score+$cer_score+$act_score;

                $resultext = 'bi_ppscore="' . $pps_score . '",bi_eduscore="' . $edu_score . '",bi_wyscore="' . $gn_score .
                    '",bi_wtiscore="' . $zc_score . '",bi_engscore="' . $eng_score . '",bi_bimscore="' . $bim_score . 
                    '",bi_cerscore="' . $cer_score . '",bi_actscore="' . $act_score . '"';
            } else if ($table == "rap") {
                $sv='{"国家级":10, "省部级":8, "地市级":6, "公司级":2}';
                $sv = json_decode($sv, true);

                if (isset($sv[$row[3]])) {
                    $score = $sv[$row[3]];
                }
                if ($row[4] == "罚") {
                    $score = 0 - $score;
                }
            } else if ($table == "assess") {
                $lyarscore = '{"A":10, "B":6}';
                $tdzzjsscore = '{"提前转正1人":2, "提前转正2人及以上":3, "晋升1人":5, "晋升2人及以上":8}';
                $lyarscore = json_decode($lyarscore, true);
                $tdzzjsscore = json_decode($tdzzjsscore, true);
                $score1=0;$score2=0;$score3=0;

                if (isset($lyarscore[$row['assess_lyar']])) {
                    $score1 = $lyarscore[$row['assess_lyar']];
                }

                $score2 = $row['assess_nxkr'];

                if (isset($tdzzjsscore[$row['assess_tdzzjs']])) {
                    $score3 = $tdzzjsscore[$row['assess_tdzzjs']];
                }

                $score = $score1 + $score2 + $score3;

                $resultext = 'assess_lyarscore="' . $score1 . '",assess_nxkrscore="' . $score2 . '",assess_tdzzjsscore="' . $score3 . '"';

            } else if ($table == "workex") {
                $kv='{"部门正职":2,"部门副职":1}';
                $kv = json_decode($kv, true);
                $k=0;
                $s = $row[3];
                if (isset($kv[$row[4]])) {
                    $k = $kv[$row[4]];
                }
                $score = $s * $k;
            } else if ($table == "projex") {
                if ($row[8] == '完整经历') {
                    $sv='{"项目总工":{"特大型":10,"大型":8,"中小型":6},
                         "项目副总工/质量总监":{"特大型":6,"大型":4,"中小型":3},
                         "项目部门经理":{"特大型":4,"大型":3,"中小型":2},
                         "项目技术/质量工程师":{"特大型":2,"大型":2,"中小型":1}}';
                    $sv = json_decode($sv, true);
                    if (isset($sv[$row[5]])) {
                        if (isset($sv[$row[5]][$row[4]])) {
                            $score = $sv[$row[5]][$row[4]];
                        }
                    }
                }
            } else if ($table == "tereex") {
                $sv='{"课题负责人":{"国家级":8,"省部级":6,"地市级":4,"公司级":2},
                     "课题骨干":{"国家级":4,"省部级":3,"地市级":2,"公司级":1},
                     "其他参与人员":{"国家级":2,"省部级":2,"地市级":1,"公司级":1}}';
                $sv = json_decode($sv, true);
                if (isset($sv[$row[5]])) {
                    if (isset($sv[$row[5]][$row[4]])) {
                        $score = $sv[$row[5]][$row[4]];
                    }
                }
            } else if ($table == "bidex") {
                $sv='{"主持":{"特大型":5,"大型":4,"中小型":3},
                    "骨干":{"特大型":3,"大型":2,"中小型":2},
                    "参与":{"特大型":1,"大型":1,"中小型":1}}';
                $sv = json_decode($sv, true);
                if (isset($sv[$row[5]])) {
                    if (isset($sv[$row[5]][$row[4]])) {
                        $score = $sv[$row[5]][$row[4]];
                    }
                }
            } else if ($table == "sten") {
                if ($row[3] == "国家级") {
                    $sv='{"项目总工":{"一等奖":20,"二等奖":14,"三等奖":10},
                        "项目技术部经理":{"一等奖":15,"二等奖":10,"三等奖":7},
                        "项目技术工程师":{"一等奖":10,"二等奖":8,"三等奖":5}}';
                    $sv = json_decode($sv, true);
                    if (isset($sv[$row[5]])) {
                        if (isset($sv[$row[5]][$row[4]])) {
                            $score = $sv[$row[5]][$row[4]];
                        }
                    }
                } else if ($row[3] == "省部级") {
                    $sv='{"项目总工":{"一等奖":7,"二等奖":6,"三等奖":5},
                        "项目技术部经理":{"一等奖":5,"二等奖":4,"三等奖":3},
                        "项目技术工程师":{"一等奖":4,"二等奖":3,"三等奖":2}}';
                    $sv = json_decode($sv, true);
                    if (isset($sv[$row[5]])) {
                        if (isset($sv[$row[5]][$row[4]])) {
                            $score = $sv[$row[5]][$row[4]];
                        }
                    }
                } else if ($row[3] == "地市级") {
                    $sv='{"项目总工":{"一等奖":3,"二等奖":2,"三等奖":1},
                        "项目技术部经理":{"一等奖":2,"二等奖":1,"三等奖":1},
                        "项目技术工程师":{"一等奖":1,"二等奖":1,"三等奖":1}}';
                    $sv = json_decode($sv, true);
                    if (isset($sv[$row[5]])) {
                        if (isset($sv[$row[5]][$row[4]])) {
                            $score = $sv[$row[5]][$row[4]];
                        }
                    }
                }
            } else if ($table == "sgzzsjj") {
                $sv='{"一等奖":{"总公司级":4,"局级":3,"公司级":2},
                    "其他奖":{"总公司级":2,"局级":1,"公司级":1}}';
                $sv = json_decode($sv, true);
                if (isset($sv[$row[4]])) {
                    if (isset($sv[$row[4]][$row[3]])) {
                        $score = $sv[$row[4]][$row[3]];
                    }
                }
            } else if ($table == "sfgc") {
                $sv='{"项目总工":{"国家级":5,"省部级":3,"地市级":2},
                    "其他技术人员":{"国家级":3,"省部级":2,"地市级":1}}';
                $sv = json_decode($sv, true);
                if (isset($sv[$row[5]])) {
                    if (isset($sv[$row[5]][$row[4]])) {
                        $score = $sv[$row[5]][$row[4]];
                    }
                }
            } else if ($table == "patent") {
                $sv='{"前两位":{"发明":6,"实用新型/外观设计":2},
                    "三四位":{"发明":3,"实用新型/外观设计":1}}';
                $sv = json_decode($sv, true);
                if (isset($sv[$row[5]])) {
                    if (isset($sv[$row[5]][$row[4]])) {
                        $score = $sv[$row[5]][$row[4]];
                    }
                }
            } else if ($table == "conmethod") {
                $sv='{"前两位":{"国家级":4,"省部级":3,"地市级":2,"公司级":1}}';
                $sv = json_decode($sv, true);
                if (isset($sv[$row[5]])) {
                    if (isset($sv[$row[5]][$row[4]])) {
                        $score = $sv[$row[5]][$row[4]];
                    }
                }
            } else if ($table == "gccy") {
                $sv='{"项目总工/质量总监":{"鲁班奖":10,"国家级":8,"省部级":4,"地市级":2},
                     "其他技术质量人员":{"鲁班奖":5,"国家级":4,"省部级":2,"地市级":1}}';
                $sv = json_decode($sv, true);
                if (isset($sv[$row[5]])) {
                    if (isset($sv[$row[5]][$row[4]])) {
                        $score = $sv[$row[5]][$row[4]];
                    }
                }
                if ($row[3] != "优质工程") {
                    $k = 0.5;
                    $score = $score * $k;
                }
            } else if ($table == "qcta") {
                $sv='{"项目总工/质量总监":{"国家级":4,"省部级":3,"地市级":2,"公司级":1},
                     "发布人":{"国家级":3,"省部级":2,"地市级":1,"公司级":1},
                     "其他参与人员":{"国家级":2,"省部级":1,"地市级":1,"公司级":1}}';
                $sv = json_decode($sv, true);
                if (isset($sv[$row[5]])) {
                    if (isset($sv[$row[5]][$row[4]])) {
                        $score = $sv[$row[5]][$row[4]];
                    }
                }
            }
            $this->m_tempscore = $score;
            $result = $table . '_score="' . $score . '"';
            if ($resultext) {
                $result = $result . ',' . $resultext;
            }
            return $result;
        }


        function fn_calcscoretable($db, $pid, $table) {
            if($db == null) {
                $this->lasterrmsg = "db is null!";
                return false;
            }

            if ($db->m_mysqlhandle == 0) {
                $this->lasterrmsg = "db->m_mysqlhandle is null!";
                return false;
            }

            if ($this->fn_getmysqltblandkeysbytablename($table) == false) {
                if ($this->_DEBUG) {
                    echo "DEBUG {crc_staff::fn_calcscoretable}: unknown table name:" . $table . ". <br>";
                }
                $this->lasterrmsg = "unknown table name: " . $table;
                return false;
            }

            $this->m_sql = 'select * ' . 'from ' . $this->m_mysqltable . ' where ' . $table . '_uid="' . $pid . '"';
            $resource = $db->fn_runsql(MYSQL_DB, $this->m_sql);			
            if (mysql_errno() != 0) {
                $this->lasterrnum = $db->lasterrnum;
                $this->lasterrmsg = $db->lasterrmsg;
                $db->fn_freesql($resource);
                return false;
            }

            $tscore=0;

            while ($row = mysql_fetch_array($resource)) {
                $updatestr = $this->fn_calctablescore($table, $row);
                $tscore += $this->m_tempscore;
                $this->m_sql = 'update ' . $this->m_mysqltable . ' set ' . $updatestr . ' where ' . $table . '_id="' . $row[0] . '"';
				$resource1 = $db->fn_runsql(MYSQL_DB, $this->m_sql);
                if (mysql_errno() != 0) {
					$this->lasterrnum = $db->lasterrnum;
					$this->lasterrmsg = $db->lasterrmsg;
					$db->fn_freesql($resource);
                    return false;
                }
                $db->fn_freesql($resource1);
            }
            $db->fn_freesql($resource);

            $this->m_tscores[$table . '_tscore'] = $tscore;

            return true;
        }

		function fn_setbi($post) {
			//******************************************
			// Update the base information
			//******************************************
            return;
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
            return;
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
            return;
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
            return;
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
            return;
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
            return;
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
