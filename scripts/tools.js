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
        adminaddcourse.submit();
	} else if (page == "editcourse") {
        editcourse.submit();
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
			alert("Please enter the username of SMS database");
			dbsetup.username.focus();
		} else if (dbsetup.userpassword.value == "") {
			alert("Please enter the password for user of SMS database");
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

function fillscores(data)
{
    for (var key in data) {
        if (key.indexOf("score") >= 0) {
            //alert(key);
            var ee = document.getElementById(key);
            if (ee) {
                ee.innerHTML = data[key];
            }
        }
    }
}

function autofillformdata(eform, data)
{
    var ff=eform;
    for (var i=0;i<ff.elements.length;i++) {
        var ee=ff.elements[i];

        if (!(ee.name in data)) {
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

    if (ff.name == "form_assess" || ff.name == "form_bi") {
        for (var key in data) {
            if (key.indexOf("score") >= 0) {
                //alert(key);
                var ee = document.getElementById(key);
                if (ee) {
                    ee.innerHTML = data[key];
                }
            }
        }
    }
}

function resetformdata(eform)
{
    var ff=eform;
    for (var i=0;i<ff.elements.length;i++) {
        var ee=ff.elements[i];

        if ("INPUT" == ee.tagName) {
            if (ee.type == "text") {
                ee.value = "";
            }
        }
        else if ("TEXTAREA" == ee.tagName) {
            ee.value = "";
        }
        else if ("SELECT" == ee.tagName) {
            ee.selectedIndex=0;
        }
    }
}

function ajaxRequest(method, url, data, callback) {
    //创建XMLHttpRequest对象
    var xmlHttp = new XMLHttpRequest();

    //配置XMLHttpRequest对象
    xmlHttp.open(method, url);

    //设置回调函数
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            callback(xmlHttp.responseText);
        }
    }

    if (data != null) {
        xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    }

    //发送请求
    xmlHttp.send(data);
}
