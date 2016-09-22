function changedcb(response) {
    var resultstr="set"+g_tname+"result=";
    var index=response.indexOf(resultstr);
    var data=JSON.parse(response.substr(index+resultstr.length));
    var eres=document.getElementById(g_tname+"_ret");

    //alert(response);
    //alert(response.substr(index+13));

    if (data.ret == 0) {
        if (data.action == 'add') {
            eres.innerHTML="添加成功，您可以继续添加新记录.";
            resetformdata(document.forms['form_'+g_tname]);
        } else {
            eres.innerHTML="修改成功.";
        }
    } else {
        if (data.action == 'add') {
            eres.innerHTML="添加失败: " + data.retstr + "!";
        } else {
            eres.innerHTML="修改失败: " + data.retstr + "!";
        }
    }
}

function apply() {
    var staffpre="/sms/pages/crc_data.php?method=staff";
    var params = $('#form_'+g_tname).serialize();
    ajaxRequest("POST", staffpre+"&func="+g_tname, params, changedcb);
}

function showdata(response) {
    var resultstr="get"+g_tname+"result=";
    var index=response.indexOf(resultstr);
    var data=JSON.parse(response.substr(index+resultstr.length));

    //alert(result.substr(index+13));

    if (data.ret == 0) {
        autofillformdata(document.forms['form_'+g_tname], data.data[0]);
    }
}

function load()
{
    var staffpre="/sms/pages/crc_data.php?method=staff";

    document.getElementById("action").value=g_action;
    document.getElementById(g_tname+"_uid").value=g_pid;
    document.getElementById(g_tname+"_id").value=g_did;

    if (g_action == 'edit') {
        ajaxRequest("GET", staffpre+"&func="+g_tname+"&action=get"+"&pid=" + g_pid + "&did=" + g_did, null, showdata);
    } else {
        document.getElementById("button").value="添加";
    }
}
