function fn_showstatus(text) {
	window.status = text;
	setTimeout("window.status=''", 5000);
}

function verify(page) {
	if (page == "register") {
		if (register.username.value == "") {
			alert("Please enter a valid 'Username'!");
			register.username.focus();
		} else if (register.password.value == "") {
			alert("Please enter a valid 'Password'!");
			register.lname.focus();
		} else {
			register.submit();
		}
	} else if (page == "login") {
		if (login.username.value == "") {
			alert("Please enter a valid 'Username'!");
			login.username.focus();
		} else if (login.password.value == "") {
			alert("Please enter a valid 'Password'!");
			login.password.focus();
		} else {
			login.submit();
		}
	} else if (page == "profile") {
		if (profile.username.value == "") {
			alert("Please enter a valid 'Username'!");
			profile.username.focus();
		} else if (profile.password.value == "") {
			alert("Please enter a valid 'Password'!");
			profile.lname.focus();
		} else {
			profile.submit();
		}
	} else if (page == "editprofile") {
		if (editprofile.username.value == "") {
			alert("Please enter a valid username");
			editprofile.username.focus();
		} else if (editprofile.password.value == "") {
			alert("Please enter a valid password");
			editprofile.password.focus();
		} else {
			editprofile.submit();
		}
	} else if (page == "adminaddcourse") {
		if (adminaddcourse.cname.value == "") {
			alert("Please enter a valid 'Course Name'!");
			adminaddcourse.cname.focus();
		} else if (adminaddcourse.sday.value == "") {
			alert("Please enter a valid 'Start Day'!");
			adminaddcourse.sday.focus();
		} else if (adminaddcourse.smonth.value == "") {
			alert("Please enter a valid 'Start Month'!");
			adminaddcourse.smonth.focus();
		} else if (adminaddcourse.syear.value == "") {
			alert("Please enter a valid 'Start Year'!");
			adminaddcourse.syear.focus();
		} else if (adminaddcourse.eday.value == "") {
			alert("Please enter a valid 'End Day'!");
			adminaddcourse.eday.focus();
		} else if (adminaddcourse.emonth.value == "") {
			alert("Please enter a valid 'End Month'!");
			adminaddcourse.emonth.focus();
		} else if (adminaddcourse.eyear.value == "") {
			alert("Please enter a valid 'End Year'!");
			adminaddcourse.eyear.focus();
		}else if (adminaddcourse.daytime.value == "") {
			alert("Please enter a valid 'Day Time'!");
			adminaddcourse.daytime.focus();
		} else if (adminaddcourse.roomname.value == "") {
			alert("Please enter a valid 'Room'!");
			adminaddcourse.room.focus();
		} else {
			adminaddcourse.submit();
		}
	} else if (page == "editcourse") {
		if (editcourse.cname.value == "") {
			alert("Please enter a valid 'Course Name'!");
			editcourse.cname.focus();
		} else if (editcourse.sday.value == "") {
			alert("Please enter a valid 'Start Day'!");
			editcourse.sday.focus();
		} else if (editcourse.smonth.value == "") {
			alert("Please enter a valid 'Start Month'!");
			editcourse.smonth.focus();
		} else if (editcourse.syear.value == "") {
			alert("Please enter a valid 'Start Year'!");
			editcourse.syear.focus();
		} else if (editcourse.eday.value == "") {
			alert("Please enter a valid 'End Day'!");
			editcourse.eday.focus();
		} else if (editcourse.emonth.value == "") {
			alert("Please enter a valid 'End Month'!");
			editcourse.emonth.focus();
		} else if (editcourse.eyear.value == "") {
			alert("Please enter a valid 'End Year'!");
			editcourse.eyear.focus();
		}else if (editcourse.daytime.value == "") {
			alert("Please enter a valid 'Day Time'!");
			editcourse.daytime.focus();
		} else if (editcourse.roomname.value == "") {
			alert("Please enter a valid 'Room'!");
			editcourse.room.focus();
		} else {
			editcourse.submit();
		}		
	} else if (page == "adminaddstudent") {
		if (adminaddstudent.fname.value == "") {
			alert("Please enter a valid 'Given Name'!");
			adminaddstudent.fname.focus();
		} else if (adminaddstudent.lname.value == "") {
			alert("Please enter a valid 'Surname'!");
			adminaddstudent.fname.focus();
		} else {
			adminaddcourse.submit();
		}
	} else if (page == "dbsetup") {
		if (dbsetup.database.value == "") {
			alert("Please enter a database name");
			dbsetup.database.focus();
		} else if (dbsetup.password.value == "") {
			alert("Please enter a password for the root user of MySQL server");
			dbsetup.password.focus();
		} else if (dbsetup.username.value == "") {
			alert("Please enter the username of FreeSMS database");
			dbsetup.username.focus();
		} else if (dbsetup.userpassword.value == "") {
			alert("Please enter the password for user of FreeSMS database");
			dbsetup.userpassword.focus();
		} else {
			dbsetup.submit();
		}
	} else if (page == "staffworkex") {
        staffworkex.submit();
	} else {
		alert("unknown/unhandled page");
	}	
}

function autofilldata(data, type)
{
    var ff=document.forms[0];
    if (type == 0) {
        for (var i=0;i<ff.elements.length;i++) {
            var ee=ff.elements[i];

            if (ee.name == "button") {
                if (ee.type == "submit") {
                    ee.value = "添加";
                }
            }
            else if (!(ee.name in data)) {
                continue;
            }

            if ("INPUT" == ee.tagName) {
                if (ee.type == "hidden") {
                    ee.value = data[ee.name];
                }
            }
        }
    }
    else if (type == 1) {
        for (var i=0;i<ff.elements.length;i++) {
            var ee=ff.elements[i];

            if (ee.name == "button") {
                if (ee.type == "submit") {
                    ee.value = "修改";
                }
            }
            else if (!(ee.name in data)) {
                continue;
            }

            if ("INPUT" == ee.tagName) {
                if (ee.type == "text") {
                    ee.value = data[ee.name];
                }
                else if (ee.type == "hidden") {
                    ee.value = data[ee.name];
                }
            }
            else if ("TEXTAREA" == ee.tagName) {
                    ee.value = data[ee.name];
            }
            else if ("SELECT" == ee.tagName) {
                for (var j=0; j<ee.options.length; j++ ) {
                    if (ee.options[j].value == data[ee.name]) {
                        ee.selectedIndex=j;
                    }
                }
            }
        }
    }
}
