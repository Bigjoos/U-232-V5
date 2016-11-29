<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                                            |
 |--------------------------------------------------------------------------|
 |   Licence Info: WTFPL                                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5                                            |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'html_functions.php');
require_once (INCL_DIR . 'password_functions.php');
require_once (INCL_DIR . 'function_bemail.php');
dbconn(true);
global $CURUSER;
if (!$CURUSER) {
    get_template();
}
$lang = array_merge(load_language('global'));
$HTMLOUT = '';
//==Promo mod by putyn 24/2/2009
$do = (isset($_GET["do"]) ? htmlsafechars($_GET["do"]) : (isset($_POST["do"]) ? htmlsafechars($_POST["do"]) : ""));
$id = (isset($_GET["id"]) ? (int)$_GET["id"] : (isset($_POST["id"]) ?(int) $_POST["id"] : "0"));
$link = (isset($_GET["link"]) ? htmlsafechars($_GET["link"]) : (isset($_POST["link"]) ? htmlsafechars($_POST["link"]) : ""));
$sure = (isset($_GET["sure"]) && htmlsafechars($_GET["sure"]) == "yes" ? "yes" : "no");
if ($_SERVER["REQUEST_METHOD"] == "POST" && $do == "addpromo") {
    $promoname = (isset($_POST["promoname"]) ? htmlsafechars($_POST["promoname"]) : "");
    if (empty($promoname)) stderr("Error", "No name for the promo");
    $days_valid = (isset($_POST["days_valid"]) ? (int) $_POST["days_valid"] : 0);
    if ($days_valid == 0) stderr("Error", "Link will be valid for 0 days ? I don't think so!");
    $max_users = (isset($_POST["max_users"]) ? (int) $_POST["max_users"] : 0);
    if ($max_users == 0) stderr("Error", "Max users cant be 0 i think you missed that!");
    $bonus_upload = (isset($_POST["bonus_upload"]) ? (int)$_POST["bonus_upload"] : 0);
    $bonus_invites = (isset($_POST["bonus_invites"]) ? (int) $_POST["bonus_invites"] : 0);
    $bonus_karma = (isset($_POST["bonus_karma"]) ? (int) $_POST["bonus_karma"] : 0);
    if ($bonus_upload == 0 && $bonus_invites == 0 && $bonus_karma == 0) stderr("Error", "No gift for the new users ?! :w00t: give them some gifts :D");
    $link = md5("promo_link" . TIME_NOW);
    $q = sql_query("INSERT INTO promo (name,added,days_valid,max_users,link,creator,bonus_upload,bonus_invites,bonus_karma) VALUES (" . implode(",", array_map("sqlesc", array(
        $promoname,
        TIME_NOW,
        $days_valid,
        $max_users,
        $link,
        $CURUSER["id"],
        $bonus_upload,
        $bonus_invites,
        $bonus_karma
    ))) . ") ") or sqlerr(__FILE__, __LINE__);
    if (!$q) stderr("Error", "Something wrong happned, please retry");
    else stderr("Success", "The promo link <b>" . htmlsafechars($promoname) . "</b> was added! here is the link <br /><input type=\"text\" name=\"promo-link\" value=\"" . $INSTALLER09['baseurl'] . $_SERVER["PHP_SELF"] . "?do=signup&amp;link=" . $link . "\" size=\"80\" onclick=\"select();\"  /><br/><a href=\"" . $_SERVER["PHP_SELF"] . "\"><input type=\"button\" value=\"Back to Promos\" /></a>");
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $do == "signup") {
    //==err("w00t");
    $r_check = sql_query("SELECT * FROM promo WHERE link=" . sqlesc($link)) or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($r_check) == 0) stderr("Error", "The link your using is not a valid link");
    else {
        $ar_check = mysqli_fetch_assoc($r_check);
        if ($ar_check["max_users"] == $ar_check["accounts_made"]) stderr("Error", "Sorry account limit (" . htmlsafechars($ar_check["max_users"]) . ") on this link has been reached ");
        if (($ar_check["added"] + (86400 * $ar_check["days_valid"])) < TIME_NOW) stderr("Error", "This link was valid only till " . date("d/M-Y", ($ar_check["added"] + (86400 * $ar_check["days_valid"]))));
        //==Some variables for the new user :)
        $username = (isset($_POST["username"]) ? htmlsafechars($_POST["username"]) : "");
        if (empty($username)) stderr("Error", "You must pick a an username");
        if (strlen($username) < 4 || strlen($username) > 12) stderr("Error", "Your username is to long or to short (min 4 char , max 12 char)");
        $password = (isset($_POST["password"]) ? htmlsafechars($_POST["password"]) : "");
        $passwordagain = (isset($_POST["passwordagain"]) ? htmlsafechars($_POST["passwordagain"]) : "");
        if (empty($password) || empty($passwordagain)) stderr("Error", "You have to type your passwords twice");
        if ($password != $passwordagain) stderr("Error", "The passwords didn't match! Must've typoed. Try again.");
        if (strlen($password) < 6) stderr("Error", "Password must be min 6 char");
        $email = (isset($_POST["mail"]) ? htmlsafechars($_POST["mail"]) : "");
        if (empty($email)) stderr("Error", "No email adress, you forgot about that?");
        if (!validemail($email)) stderr("Error", "That dosen't look like an email adress");
        check_banned_emails($email);
        //==Check if username or password already exists
        $var_check = sql_query("SELECT id, editsecret FROM users where username=" . sqlesc($username) . " OR email=" . sqlesc($email)) or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($var_check) == 1) stderr("Error", "Username or password already exists");
        $secret = mksecret();
        $passhash = make_passhash($secret, md5($password));
        //$editsecret = make_passhash_login_key();
        $editsecret = (EMAIL_CONFIRM ? make_passhash_login_key() : "");
        $res = sql_query("INSERT INTO users(username, passhash, secret, editsecret, email, added, uploaded, invites, seedbonus) VALUES (" . implode(",", array_map("sqlesc", array(
            $username,
            $passhash,
            $secret,
            $editsecret,
            $email,
            TIME_NOW,
            ($ar_check["bonus_upload"] * 1073741824) ,
            $ar_check["bonus_invites"],
            $ar_check["bonus_karma"]
        ))) . ") ") or sqlerr(__FILE__, __LINE__);
        if ($res) {
            //==Updating promo table
            $userid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
            $users = (empty($ar_check["users"]) ? $userid : $ar_check["users"] . "," . $userid);
            sql_query("update promo set accounts_made=accounts_made+1 , users=" . sqlesc($users) . " WHERE id=" . sqlesc($ar_check["id"])) or sqlerr(__FILE__, __LINE__);
            //==Email part :)
            $sec = $editsecret;
            $subject = $INSTALLER09['site_name'] . " user registration confirmation";
            $message = "Hi!
						You used the link from promo " . htmlsafechars($ar_check["name"]) . " and registred a new account at {$INSTALLER09['site_name']}
							
						To confirm your account click the link below
						{$INSTALLER09['baseurl']}/confirm.php?id=" . (int)$userid . "&secret=$sec

						Welcome and enjoy your stay 
						Staff at {$INSTALLER09['site_name']}";
            $headers = 'From: ' . $INSTALLER09['site_email'] . "\r\n" . 'Reply-To:' . $INSTALLER09['site_email'] . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            $mail = @mail($email, $subject, $message, $headers);
            stderr("Success!", "Account was created! and an email was sent to <b>" . htmlsafechars($email) . "</b>, you can use your account once you confirm the email!");
        } else stderr("Error", "Something odd happned please retry");
    }
} elseif ($do == "delete" && $id > 0) {
    $r = sql_query("SELECT name FROM promo WHERE id=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    if ($sure == "no") {
        $a = mysqli_fetch_assoc($r);
        stderr("Sanity check...", "You are about to delete promo <b>" . htmlsafechars($a["name"]) . "</b>, if you are sure click <a href=\"" . $_SERVER["PHP_SELF"] . "?do=delete&amp;id=" . $id . "&amp;sure=yes\">here</a>");
    } elseif ($sure == "yes") {
        if (sql_query("DELETE FROM promo where id=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__)) {
            header("Refresh: 2; url=" . $_SERVER["PHP_SELF"]);
            stderr("Success", "Promo was deleted!");
        } else stderr("Error", "Odd things happned!Contact your coder!");
    }
} elseif ($do == "addpromo") {
    loggedinorreturn();
    if ($CURUSER['class'] < UC_STAFF) stderr("Error", "There is nothing for you here! Go play somewere else");
  $HTMLOUT.= "<div class='row'><div class='col-md-12'><h2>Add Promo Link</h2>";
    $HTMLOUT.= "<form action='" . ($_SERVER["PHP_SELF"]) . "' method='post' >
					<table class='table table-bordered'>
					  <tr>
						<td nowrap='nowrap' align='right' colspan='1'>Promo Name</td>
						<td align='left' width='100%' colspan='3'><input type='text' name='promoname' size='60' /></td>
					  </tr>
					  <tr>
					  <td nowrap='nowrap' align='right' >Days valid</td>
						<td align='left' width='100%' colspan='1'><input type='text' name='days_valid' size='15' /></td>
						<td nowrap='nowrap' align='right' >Max users</td>
						<td align='left' width='100%' colspan='2'><input type='text' name='max_users' size='15' /></td>
					  </tr>
					  <tr>
						<td align='right' rowspan='3' nowrap='nowrap' valign='top'>Bonuses</td>
					  </tr>
					  <tr>
						<td align='center'>Upload</td>
						<td align='center'>Invites</td>
						<td align='center'>Karma</td>
					  </tr>
					  <tr>
						<td align='center'><input type='text' name='bonus_upload' size='15' /></td>
						<td align='center'><input type='text' name='bonus_invites' size='15' /></td>
						<td align='center'><input type='text' name='bonus_karma' size='15' /></td>
					  </tr>
					  <tr><td align='center' colspan='4'><input type='hidden' value='addpromo' name='do'  /><input type='submit' value='Add Promo!' /></td></tr>
					</table>
				</form>";
	$HTMLOUT.= "</div></div><br>";
    echo stdhead('Add Promo Link') . $HTMLOUT . stdfoot();
} elseif ($do == "signup") {
    if (empty($link)) stderr("Error", "There is no link found! Please check the link");
    else {
        $r_promo = sql_query("SELECT * from promo where link=" . sqlesc($link)) or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($r_promo) == 0) stderr("Error", "There is no promo with that link ");
        else {
            $ar = mysqli_fetch_assoc($r_promo);
            if ($ar["max_users"] == $ar["accounts_made"]) stderr("Error", "Sorry account limit (" . htmlsafechars($ar["max_users"]) . ") on this link has been reached ");
            if (($ar["added"] + (86400 * $ar["days_valid"])) < TIME_NOW) stderr("Error", "This link was valid only till " . date("d/M-Y", ($ar["added"] + (86400 * $ar["days_valid"]))));
		$HTMLOUT.= "<div class='row'><div class='col-md-12'>";
            $HTMLOUT.= "<form action='" . ($_SERVER["PHP_SELF"]) . "' method='post'>
						  <table class='table table-bordered'>
						  <tr><td class='colhead' align='center' colspan='2'>Promo : " . htmlsafechars($ar["name"]) . " </td></tr>
						  <tr><td nowrap='nowrap' align='right'>Bonuses</td>
							  <td align='left' width='100%'>
								" . ($ar["bonus_upload"] > 0 ? "<b>upload</b>:&nbsp;" . mksize($ar["bonus_upload"] * 1073741824) . "<br />" : "") . "
								" . ($ar["bonus_invites"] > 0 ? "<b>invites</b>:&nbsp;" . ((int) $ar["bonus_invites"]) . "<br />" : "") . "
								" . ($ar["bonus_karma"] > 0 ? "<b>karma</b>:&nbsp;" . ((int) $ar["bonus_karma"]) . "<br />" : "") . "
								</td></tr>
								<tr>
							  <td nowrap='nowrap' align='right'>Username</td>
							  <td align='left' width='100%'><input type='text' size='40' name='username' /></td>
							</tr>
							<tr><td nowrap='nowrap' align='right'>Password</td><td align='left' width='100%'><input type='password' name='password' size='40' /></td></tr>
							<tr><td nowrap='nowrap' align='right'>Password again</td><td align='left' width='100%'><input type='password' name='passwordagain' size='40' /></td></tr>
							<tr><td nowrap='nowrap' align='right'>Email</td><td align='left' width='100%'><input type='text' name='mail' size='40'/></td></tr>
							<tr><td colspan='2' class='colhead' align='center'><input type='hidden' name='link' value='" . ($link) . "'/><input type='hidden' name='do' value='signup'/><input type='submit' value='SignUp!' /></td></tr>
						  </table> 
						</form>";
          $HTMLOUT.= "</div></div><br>";
            echo stdhead("Signup for promo :" . htmlsafechars($ar["name"]) . "") . $HTMLOUT . stdfoot();
        }
    }
} elseif ($do == "accounts") {
    if ($id == 0) die("Can't find id");
    else {
        $q1 = sql_query("SELECT name, users FROM promo WHERE id=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($q1) == 1) {
            $a1 = mysqli_fetch_assoc($q1);
            if (!empty($a1["users"])) {
                $users = explode(",", $a1["users"]);
                if (!empty($users)) $q2 = sql_query("SELECT id, username, added FROM users WHERE id IN (" . join(",", $users) . ")") or sqlerr(__FILE__, __LINE__);
                $HTMLOUT = "
          <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
          <html xmlns='http://www.w3.org/1999/xhtml'>
          <head>
					<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
					<title>Users list for promo : " . htmlsafechars($a1["name"]) . "</title>
					<style type=\"text/css\">
					body { background-color:#999999;
					color:#333333;
					font-family:tahoma;
					font-size:12px;
					font-weight:bold;}
					a:link, a:hover , a:visited {
					color:#FFFFFF;
					}
					.rowhead { background-color:#0033FF;
					color:#CCCCCC;}
					</style>
					</head>
					<body>
					<div class='row'><div class='col-md-12'>
					<table class='table table-bordered'>
						<tr><td class='rowhead' align='left' width='100'> User</td><td class='rowhead' align='left' nowrap='nowrap'>Added</td></tr>";
                while ($ap = mysqli_fetch_assoc($q2)) {
                    $HTMLOUT.= "<tr><td align='left' width='100'><a href='userdetails.php?id=" . (int)$ap["id"] . "'>" . htmlsafechars($ap["username"]) . "</a></td><td  align='left' nowrap='nowrap' >" . get_date($ap["added"], 'LONG', 0, 1) . "</td></tr>";
                }
                $HTMLOUT.= "</table></div></div>
						<br/>
					<div align='center'><a href='javascript:close()'><input type='button' value='Close' /></a></div>
					</body>
					</html>";
                echo $HTMLOUT;
            } else die("No users");
        } else die("Something odd happend");
    }
} else {
    loggedinorreturn();
    if ($CURUSER['class'] < UC_STAFF) stderr("Error", "There is nothing for you here! Go play somewere else");
    $r = sql_query("SELECT p.*,u.username from promo as p LEFT JOIN users as u on p.creator=u.id ORDER by p.added,p.days_valid DESC") or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($r) == 0) stderr("Error", "There is no promo if you want to make one click <a href=\"" . $_SERVER["PHP_SELF"] . "?do=addpromo\">here</a>");
    else {      
	$HTMLOUT.= "<div class='row'><div class='col-md-12'><h2>Current Promos&nbsp;<font class=\"small\"><a href=\"" . $_SERVER["PHP_SELF"] . "?do=addpromo\">- Add promo</a></font></h2>";
	$HTMLOUT.= "<script type='text/javascript'>
		/*<![CDATA[*/
		function link(id)
		{
			wind = window.open('promo.php?do=accounts&id='+id,' ','height=300,width=320,resizable=yes,scrollbars=yes,toolbar=no,menubar=no');
			wind.focus();
		 }
		 /*]]>*/
		</script>";
	        $HTMLOUT.= "<table class='table table-bordered'>
			<tr>
				<td align='left' width='100%' rowspan='2'>Promo</td>
				<td align='center' nowrap='nowrap' rowspan='2'>Added</td>
				<td align='center' nowrap='nowrap' rowspan='2'>Valid Till</td>
				<td align='center' nowrap='nowrap' colspan='2'>Users</td>
				<td align='center' nowrap='nowrap' colspan='3' >Bonuses</td>
				<td align='center' nowrap='nowrap' rowspan='2'>Added by</td>       
				<td align='center' nowrap='nowrap' rowspan='2'>Remove</td>       
			</tr>
			<tr>
				<td align='center' nowrap='nowrap'>max</td>
				<td align='center' nowrap='nowrap'>till now</td>
				<td align='center' nowrap='nowrap' >upload</td>
				<td align='center' nowrap='nowrap' >invites</td>
				<td align='center' nowrap='nowrap' >karma</td>       
			</tr>";
        while ($ar = mysqli_fetch_assoc($r)) {
            $active = (($ar["max_users"] == $ar["accounts_made"]) || (($ar["added"] + (86400 * $ar["days_valid"])) < TIME_NOW)) ? false : true;
            $HTMLOUT.= "<tr " . (!$active ? "title=\"This promo has ended\"" : "") . ">
				<td nowrap='nowrap' align='center'>" . (htmlsafechars($ar["name"])) . "<br /><input type='text' " . (!$active ? "disabled=\"disabled\"" : "") . " value='" . ($INSTALLER09['baseurl'] . $_SERVER["PHP_SELF"] . "?do=signup&amp;link=" . $ar["link"]) . "' size='60' name='" . (htmlsafechars($ar["name"])) . "' onclick='select();' /></td>
				<td nowrap='nowrap' align='center'>" . (date("d/M-Y", $ar["added"])) . "</td>
				<td nowrap='nowrap' align='center'>" . (date("d/M-Y", ($ar["added"] + (86400 * $ar["days_valid"])))) . "</td>
				<td nowrap='nowrap' align='center'>" . ((int) $ar["max_users"]) . "</td>
				<td nowrap='nowrap' align='center'>" . ($ar["accounts_made"] > 0 ? "<a href=\"javascript:link(" . (int)$ar["id"] . ")\" >" . (int)$ar["accounts_made"] . "</a>" : 0) . "</td>
				<td nowrap='nowrap' align='center'>" . (mksize($ar["bonus_upload"] * 1073741824)) . "</td>
				<td nowrap='nowrap' align='center'>" . ((int) $ar["bonus_invites"]) . "</td>
				<td nowrap='nowrap' align='center'>" . ((int) $ar["bonus_karma"]) . "</td>
				<td nowrap='nowrap' align='center'><a href='userdetails.php?id=" . (int)$ar["creator"] . "'>" . htmlsafechars($ar["username"]) . "</a></td>
				<td nowrap='nowrap' align='center'><a href='" . $_SERVER["PHP_SELF"] . "?do=delete&amp;id=" . (int)$ar["id"] . "'><img src='pic/del.png' border='0' alt='Drop' /></a></td>
			</tr>";
        }
        $HTMLOUT.= "</table>";
	$HTMLOUT.= "</div></div><br>";
        echo stdhead("Current Promos") . $HTMLOUT . stdfoot();
    }
}
?>
