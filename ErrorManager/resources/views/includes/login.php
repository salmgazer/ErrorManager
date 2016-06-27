<?php
function login($user, $password)
{
    global $param;
    global $db;
    $ad = ldap_connect($param['ldap']) or die("<strong>Error!</strong><br/>Please contact administrator on 0202009542");
    $attr = array("displayname", "mail", "sn", "givenname", "samaccountname", "telephonenumber", "employeeID",);
    $dn = $param["dn"];
    $user = trim($user);
    if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
        //email
        $winid = $user;
        $filter = "(mail=" . $winid . ")";
        $seach_by = "LOWER(use_email) = LOWER('" . $winid . "')";
    } else {
        //username
        $winid = "vf-root\\" . $user;
        $filter = "(samaccountname=" . $user . ")";
        $seach_by = " LOWER(use_username) = LOWER('" . $user . "') ";
    }
    trigger_error($winid . ' - ' . $filter . ' - ' . $seach_by);
    ldap_set_option($ad, LDAP_OPT_SIZELIMIT, 1);
    ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
    $bd = ldap_bind($ad, $winid, $password);
    if ($user <> '' and $password <> '' and $bd) {
        $result = ldap_search($ad, $dn, $filter, $attr);
        $row = ldap_get_entries($ad, $result);
        if ($row["count"] > 0) {
            foreach ($row as $as) {
                $mail = $as["mail"][0];
                $displayname = $as["displayname"][0];
                $firstname = $as["givenname"][0];
                $lastname = $as["sn"][0];
                $telephone = $as["telephonenumber"][0];
            }
            $sql = "SELECT * FROM tb_users WHERE " . $seach_by . " and deleted = 0";
            $rs = $db->query($sql);
            $html = '';
            if (sizeof($rs) > 0) {
                session_name();
                session_start();
                $_SESSION['start'] = time();
                $rand = md5(rand(1000, 10000)) . time();
                $_SESSION["sid"] = $rand;
                $_SESSION["uid"] = $rs[0]['use_id'];
                $_SESSION["emp_no"] = $rs[0]['use_empno'];
                $_SESSION["unit"] = $rs[0]['use_unit'];
                $_SESSION["usergroup"] = $rs[0]['use_usergroup'];
                $_SESSION["mail"] = $mail;
                $_SESSION["displayname"] = $displayname;
                $_SESSION["firstname"] = $firstname;
                $_SESSION["lastname"] = $lastname;
                $url = "Location: home";
                session_encode();
            } else {
                $url = "Location: index?mode=failed";
            }
        }
    } else {
        $url = "Location: index?mode=failed";
    }
    header($url);
    exit;
}

#put on top of every page you want to protect
function session_page()
{
    session_name();
    session_start();
    #destroy session after 30 minuites of inactivity
    $inactive = 1800;
    if (isset($_SESSION['start'])) {
        $session_life = time() - $_SESSION['start'];
        if ($session_life > $inactive) {
            header("Location: logout");
        }
    }
    $_SESSION['start'] = time();
    //check if user has a session id
    if (!($_SESSION["sid"])) {
        session_unset();
        session_destroy();
        $url = "Location: logout";
        header($url);
        exit;
    }
}

?>
