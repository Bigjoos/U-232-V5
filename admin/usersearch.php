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
if (!defined('IN_INSTALLER09_ADMIN')) {
    $HTMLOUT = '';
    $HTMLOUT.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
		<title>Error!</title>
		</head>
		<body>
	<div style='font-size:33px;color:white;background-color:red;text-align:center;'>Incorrect access<br />You cannot access this file directly.</div>
	</body></html>";
    echo $HTMLOUT;
    exit();
}
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'pager_functions.php');
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
// 0 - No debug; 1 - Show and run SQL query; 2 - Show SQL query only
$DEBUG_MODE = 0;
$lang = array_merge($lang, load_language('ad_usersearch'));
function is_set_not_empty($param)
{
    if (isset($_POST[$param]) && !empty($_POST[$param])) return TRUE;
    else return FALSE;
}
echo stdhead($lang['usersearch_window_title']);
//$HTMLOUT .= "<h1>{$lang['usersearch_title']}</h1>\n";
echo "<h1>{$lang['usersearch_title']}</h1>\n";
$HTMLOUT = $where_is = $join_is = $q1 = $comment_is = $comments_exc = $email_is = '';
if (isset($_GET['h'])) {
    echo $lang['usersearch_instructions'];
    //$HTMLOUT .= $lang['usersearch_instructions'];
    
} else {
    $HTMLOUT.= "<p align='center'>(<a href='staffpanel.php?tool=usersearch&amp;action=usersearch&amp;h=1'>{$lang['usersearch_inlink']}</a>)";
    $HTMLOUT.= "&nbsp;-&nbsp;(<a href='staffpanel.php?tool=usersearch'>{$lang['usersearch_reset']}</a>)</p>\n";
    //echo "<p align='center'>(<a href='staffpanel.php?tool=usersearch&amp;action=usersearch&amp;h=1'>{$lang['usersearch_inlink']}</a>)";
    //echo "&nbsp;-&nbsp;(<a href='staffpanel.php?tool=usersearch'>{$lang['usersearch_reset']}</a>)</p>\n";
    
}
$highlight = " bgcolor='lightgrey'";
?>
<div class='row'><div class='col-md-12'>
<form method='post' action='staffpanel.php?tool=usersearch&amp;action=usersearch'>
<table class='table table-bordered'>
<tr>

  <td valign="middle" class='rowhead'><?php
echo $lang['usersearch_name'] ?></td>
  <td <?php
echo (isset($_POST['n']) && !empty($_POST['n'])) ? $highlight : "" ?>><input name="n" type="text" value=""<?php
echo isset($_POST['n']) ? htmlsafechars($_POST['n']) : "" ?>" size='25' /></td>

  <td valign="middle" class='rowhead'><?php
echo $lang['usersearch_ratio'] ?></td>
  <td <?php
echo (isset($_POST['r']) && !empty($_POST['r'])) ? $highlight : "" ?>><select name="rt">
    <?php
$options = array(
    $lang['usersearch_equal'],
    $lang['usersearch_above'],
    $lang['usersearch_below'],
    $lang['usersearch_between']
);
for ($i = 0; $i < count($options); $i++) {
    echo "<option value='$i' " . (((isset($_POST['rt']) ? $_POST['rt'] : "3") == "$i") ? "selected='selected'" : "") . ">" . $options[$i] . "</option>\n";
}
?>
    </select>
    <input name="r" type="text" value=""<?php
echo isset($_POST['r']) ? $_POST['r'] : '' ?>" size="5" maxlength="4" />
    <input name="r2" type="text" value=""<?php
echo isset($_POST['r2']) ? $_POST['r2'] : '' ?>" size="5" maxlength="4" /></td>

  <td valign="middle" class='rowhead'><?php
echo $lang['usersearch_status'] ?></td>
  <td <?php
echo (isset($_POST['st']) && !empty($_POST['st'])) ? $highlight : "" ?>><select name="st">
    <?php
$options = array(
    $lang['usersearch_any'],
    $lang['usersearch_confirmed'],
    $lang['usersearch_pending']
);
for ($i = 0; $i < count($options); $i++) {
    echo "<option value='$i' " . (((isset($_POST['st']) ? $_POST['st'] : "0") == "$i") ? "selected='selected'" : "") . ">" . $options[$i] . "</option>\n";
}
?>
    </select></td></tr>
<tr><td valign="middle" class='rowhead'><?php
echo $lang['usersearch_email'] ?></td>
  <td <?php
echo (isset($_POST['em']) && !empty($_POST['em'])) ? $highlight : "" ?>><input name="em" type="text" value=""<?php
echo isset($_POST['em']) ? $_POST['em'] : '' ?>" size="25" /></td>
  <td valign="middle" class='rowhead'><?php
echo $lang['usersearch_ip'] ?></td>
  <td <?php
echo (isset($_POST['ip']) && !empty($_POST['ip'])) ? $highlight : "" ?>><input name="ip" type="text" value=""<?php
echo isset($_POST['ip']) ? $_POST['ip'] : '' ?>" maxlength="17" /></td>

  <td valign="middle" class='rowhead'><?php
echo $lang['usersearch_acstatus'] ?></td>
  <td <?php
echo (isset($_POST['as']) && !empty($_POST['as'])) ? $highlight : "" ?>><select name="as">
    <?php
$options = array(
    $lang['usersearch_any'],
    $lang['usersearch_enabled'],
    $lang['usersearch_disabled']
);
for ($i = 0; $i < count($options); $i++) {
    echo "<option value='$i' " . (((isset($_POST['as']) ? $_POST['as'] : "0") == "$i") ? "selected='selected'" : "") . ">" . $options[$i] . "</option>\n";
}
?>
    </select></td></tr>
<tr>
  <td valign="middle" class='rowhead'><?php
echo $lang['usersearch_comments'] ?></td>
  <td <?php
echo (isset($_POST['co']) && !empty($_POST['co'])) ? $highlight : "" ?>><input name="co" type="text" value=""<?php
echo isset($_POST['co']) ? $_POST['co'] : "" ?>" size="25" /></td>
  <td valign="middle" class='rowhead'><?php
echo $lang['usersearch_mask'] ?></td>
  <td <?php
echo (isset($_POST['ma']) && !empty($_POST['ma'])) ? $highlight : "" ?>><input name="ma" type="text" value=""<?php
echo isset($_POST['ma']) ? $_POST['ma'] : "" ?>" maxlength="17" /></td>
  <td valign="middle" class='rowhead'><?php
echo $lang['usersearch_class'] ?></td>
  <td <?php
echo (isset($_POST['c']) && !empty($_POST['c'])) ? $highlight : "" ?>><select name="c"><option value=''><?php $lang['usersearch_any'] ?></option>
  <?php
$class = isset($_POST['c']) ? (int)$_POST['c'] : '';
if (!is_valid_id($class)) $class = '';
for ($i = 2;; ++$i) {
    if ($c = get_user_class_name($i - 2)) echo ("<option value='" . $i . "'" . ((isset($class) ? $class : 0) == $i ? " selected='selected'" : "") . ">$c</option>\n");
    else break;
}
?>
    </select></td></tr>
<tr>

    <td valign="middle" class='rowhead'><?php
echo $lang['usersearch_joined'] ?></td>

  <td <?php
echo (isset($_POST['d']) && !empty($_POST['d'])) ? $highlight : "" ?>><select name="dt">
    <?php
$options = array(
    $lang['usersearch_on'],
    $lang['usersearch_before'],
    $lang['usersearch_after'],
    $lang['usersearch_between']
);
for ($i = 0; $i < count($options); $i++) {
    echo "<option value='$i' " . (((isset($_POST['dt']) ? $_POST['dt'] : "0") == "$i") ? "selected='selected'" : "") . ">" . $options[$i] . "</option>\n";
}
?>
    </select>

    <input name="d" type="text" value=""<?php
echo isset($_POST['d']) ? $_POST['d'] : '' ?>" size="12" maxlength="10" />

    <input name="d2" type="text" value=""<?php
echo isset($_POST['d2']) ? $_POST['d2'] : '' ?>" size="12" maxlength="10" /></td>


  <td valign="middle" class='rowhead'><?php
echo $lang['usersearch_uploaded'] ?></td>

  <td <?php
echo (isset($_POST['ult']) && !empty($_POST['ult'])) ? $highlight : "" ?>><select name="ult" id="ult">
    <?php
$options = array(
    $lang['usersearch_equal'],
    $lang['usersearch_above'],
    $lang['usersearch_below'],
    $lang['usersearch_between']
);
for ($i = 0; $i < count($options); $i++) {
    echo "<option value='$i' " . (((isset($_POST['ult']) ? $_POST['ult'] : "0") == "$i") ? "selected='selected'" : "") . ">" . $options[$i] . "</option>\n";
}
?>
    </select>

    <input name="ul" type="text" id="ul" size="8" maxlength="7" value=""<?php
echo isset($_POST['ul']) ? $_POST['ul'] : '' ?>" />

    <input name="ul2" type="text" id="ul2" size="8" maxlength="7" value=""<?php
echo isset($_POST['ul2']) ? $_POST['ul2'] : '' ?>" /></td>
  <td valign="middle" class="rowhead"><?php
echo $lang['usersearch_donor'] ?></td>

  <td <?php
echo (isset($_POST['do']) && !empty($_POST['do'])) ? $highlight : "" ?>><select name="do">
    <?php
$options = array(
    $lang['usersearch_any'],
    $lang['usersearch_yes'],
    $lang['usersearch_no']
);
for ($i = 0; $i < count($options); $i++) {
    echo "<option value='$i' " . (((isset($_POST['do']) ? $_POST['do'] : "0") == "$i") ? "selected='selected'" : "") . ">" . $options[$i] . "</option>\n";
}
?>
	</select></td></tr>
<tr>

<td valign="middle" class='rowhead'><?php
echo $lang['usersearch_lastseen'] ?></td>

  <td <?php
echo (isset($_POST['ls']) && !empty($_POST['ls'])) ? $highlight : "" ?>><select name="lst">
  <?php
$options = array(
    $lang['usersearch_on'],
    $lang['usersearch_before'],
    $lang['usersearch_after'],
    $lang['usersearch_between']
);
for ($i = 0; $i < count($options); $i++) {
    echo "<option value='$i' " . (((isset($_POST['lst']) ? $_POST['lst'] : "0") == "$i") ? "selected='selected'" : "") . ">" . $options[$i] . "</option>\n";
}
?>
  </select>

  <input name="ls" type="text" value=""<?php
echo isset($_POST['ls']) ? $_POST['ls'] : '' ?>" size="12" maxlength="10" />

  <input name="ls2" type="text" value=""<?php
echo isset($_POST['ls2']) ? $_POST['ls2'] : '' ?>" size="12" maxlength="10" /></td>
	  <td valign="middle" class='rowhead'><?php
echo $lang['usersearch_downloaded'] ?></td>

  <td <?php
echo (isset($_POST['dl']) && !empty($_POST['dl'])) ? $highlight : "" ?>><select name="dlt" id="dlt">
  <?php
$options = array(
    $lang['usersearch_equal'],
    $lang['usersearch_above'],
    $lang['usersearch_below'],
    $lang['usersearch_between']
);
for ($i = 0; $i < count($options); $i++) {
    echo "<option value='$i' " . (((isset($_POST['dlt']) ? $_POST['dlt'] : "0") == "$i") ? "selected='selected'" : "") . ">" . $options[$i] . "</option>\n";
}
?>
    </select>

    <input name="dl" type="text" id="dl" size="8" maxlength="7" value=""<?php
echo isset($_POST['dl']) ? $_POST['dl'] : '' ?>" />

    <input name="dl2" type="text" id="dl2" size="8" maxlength="7" value=""<?php
echo isset($_POST['dl2']) ? $_POST['dl2'] : '' ?>" /></td>

	<td valign="middle" class='rowhead'><?php
echo $lang['usersearch_warned'] ?></td>

	<td <?php
echo (isset($_POST['w']) && !empty($_POST['w'])) ? $highlight : "" ?>><select name="w">
  <?php
$options = array(
    $lang['usersearch_any'],
    $lang['usersearch_yes'],
    $lang['usersearch_no']
);
for ($i = 0; $i < count($options); $i++) {
    echo "<option value='$i' " . (((isset($_POST['w']) ? $_POST['w'] : "0") == "$i") ? "selected='selected'" : "") . ">" . $options[$i] . "</option>\n";
}
?>
	</select></td></tr>

<tr><td class="rowhead"></td><td></td>
  <td valign="middle" class='rowhead'><?php
echo $lang['usersearch_active'] ?></td>
	<td <?php
echo (isset($_POST['ac']) && !empty($_POST['ac'])) ? $highlight : "" ?>><input name="ac" type="checkbox" value="1" <?php
echo (isset($_POST['ac'])) ? "checked='checked'" : "" ?> /></td>
  <td valign="middle" class='rowhead'><?php
echo $lang['usersearch_banned'] ?></td>
  <td <?php
echo (isset($_POST['dip']) && !empty($_POST['dip'])) ? $highlight : "" ?>><input name="dip" type="checkbox" value="1" <?php
echo (isset($_POST['dip'])) ? "checked='checked'" : "" ?> /></td>
  </tr>
<tr><td colspan="6" align='center'><input name="submit" type='submit' class='btn' /></td></tr>
</table>
<br /><br />
</form>
</div></div>
<?php
// Validates date in the form [yy]yy-mm-dd;
// Returns date if valid, 0 otherwise.
function mkdate($date)
{
    if (strpos($date, '-')) $a = explode('-', $date);
    elseif (strpos($date, '/')) $a = explode('/', $date);
    else return 0;
    for ($i = 0; $i < 3; $i++) if (!is_numeric($a[$i])) return 0;
    if (checkdate($a[1], $a[2], $a[0])) return date("Y-m-d", mktime(0, 0, 0, $a[1], $a[2], $a[0]));
    else return 0;
}
// ratio as a string
function ratios($up, $down, $color = True)
{
    if ($down > 0) {
        $r = number_format($up / $down, 2);
        if ($color) $r = "<font color='" . get_ratio_color($r) . "'>$r</font>";
    } else if ($up > 0) $r = "Inf.";
    else $r = "---";
    return $r;
}
// checks for the usual wildcards *, ? plus mySQL ones
function haswildcard($text)
{
    if (strpos($text, '*') === False && strpos($text, '?') === False && strpos($text, '%') === False && strpos($text, '_') === False) return False;
    else return True;
}
///////////////////////////////////////////////////////////////////////////////
if (count($_POST) > 0); //&& isset($_POST['n']))
{
    // name
    $name_is = '';
    $names_exc = 0;
    $names = isset($_POST['n']) ? explode(' ', trim($_POST['n'])) : array(
        0 => ''
    );
    if ($names[0] !== "") {
        foreach ($names as $name) {
            if (substr($name, 0, 1) == '~') {
                if ($name == '~') continue;
                $names_exc[] = substr($name, 1);
            } else $names_inc[] = $name;
        }
         if (is_array($names_inc))
    {
	  	$where_is .= !empty($where_is)?" AND (":"(";
	    foreach($names_inc as $name)
	    {
      	if (!haswildcard($name))
	        $name_is .= (!empty($name_is)?" OR ":"")."u.username = ".sqlesc($name);
        
	      else
	      {
	        $name = str_replace(array('?','*'), array('_','%'), $name);
	        $name_is .= (!empty($name_is)?" OR ":"")."u.username LIKE ".sqlesc($name);
	      }
	    }
      $where_is .= $name_is.")";
      unset($name_is);
	  }

    if (is_array($names_exc))
    {
	  	$where_is .= !empty($where_is)?" AND NOT (":" NOT (";
	    foreach($names_exc as $name)
	    {
	    	if (!haswildcard($name))
	      	$name_is .= (isset($name_is)?" OR ":"")."u.username = ".sqlesc($name);
	      else
	      {
	      	$name = str_replace(array('?','*'), array('_','%'), $name);
	        $name_is .= (isset($name_is)?" OR ":"")."u.username LIKE ".sqlesc($name);
	      }
	    }
      $where_is .= $name_is.")";
	  }
	  $q1 .= ($q1 ? "&amp;" : "") . "n=".urlencode(trim($_POST['n']));
  }
    // email
    if (is_set_not_empty('em')) {
        $emaila = explode(' ', trim($_POST['em']));
        if ($emaila[0] !== "") {
            $where_is.= !empty($where_is) ? " AND (":"(";
            foreach ($emaila as $email) {
                if (strpos($email, '*') === False && strpos($email, '?') === False && strpos($email, '%') === False) {
                    if (validemail($email) !== 1) {
                        stdmsg($lang['usersearch_error'], $lang['usersearch_bademail']);
                        stdfoot();
                        die();
                    }
                    $email_is.= (!empty($email_is) ? " OR ":"") . "u.email =" . sqlesc($email);
                } else {
                    $sql_email = str_replace(array(
                        '?',
                        '*'
                    ) , array(
                        '_',
                        '%'
                    ) , $email);
                    $email_is.= (!empty($email_is) ? " OR ":"") . "u.email LIKE " . sqlesc($sql_email);
                }
            }
            $where_is.= $email_is . ")";
            $q1.= ($q1 ? "&amp;" : "") . "em=" . urlencode(trim($_POST['em']));
        }
    }
    //class
    // NB: the c parameter is passed as two units above the real one
    $class = is_set_not_empty('c') ? $_POST['c'] - 2 : -2;
    if (is_valid_id($class + 1)) {
        $where_is.= (!empty($where_is) ? " AND " : "") . "u.class=$class";
        $q1.= ($q1 ? "&amp;" : "") . "c=" . ($class + 2);
    }
    // IP
    if (is_set_not_empty('ip')) {
        $ip = trim($_POST['ip']);
        $regex = "/^(((1?\d{1,2})|(2[0-4]\d)|(25[0-5]))(\.\b|$)){4}$/";
        if (!preg_match($regex, $ip)) {
            stdmsg($lang['usersearch_error'], $lang['usersearch_badip']);
            stdfoot();
            die();
        }
        $mask = trim($_POST['ma']);
        if ($mask == "" || $mask == "255.255.255.255") $where_is.= (!empty($where_is) ? " AND ":"") . "u.ip = '$ip'";
        else {
            if (substr($mask, 0, 1) == "/") {
                $n = substr($mask, 1, strlen($mask) - 1);
                if (!is_numeric($n) or $n < 0 or $n > 32) {
                    stdmsg($lang['usersearch_error'], $lang['usersearch_badmask']);
                    stdfoot();
                    die();
                } else $mask = long2ip(pow(2, 32) - pow(2, 32 - $n));
            } elseif (!preg_match($regex, $mask)) {
                stdmsg($lang['usersearch_error'], $lang['usersearch_badmask']);
                stdfoot();
                die();
            }
            $where_is.= (!empty($where_is) ? " AND ":"") . "INET_ATON(u.ip) & INET_ATON('$mask') = INET_ATON('$ip') & INET_ATON('$mask')";
            $q1.= ($q1 ? "&amp;" : "") . "ma=$mask";
        }
        $q1.= ($q1 ? "&amp;" : "") . "ip=$ip";
    }
    // ratio
    if (is_set_not_empty('r')) {
        $ratio = trim($_POST['r']);
        if ($ratio == '---') {
            $ratio2 = "";
            $where_is.= !empty($where_is) ? " AND " : "";
            $where_is.= " u.uploaded = 0 and u.downloaded = 0";
        } elseif (strtolower(substr($ratio, 0, 3)) == 'inf') {
            $ratio2 = "";
            $where_is.= !empty($where_is) ? " AND ":"";
            $where_is.= " u.uploaded > 0 and u.downloaded = 0";
        } else {
            if (!is_numeric($ratio) || $ratio < 0) {
                stdmsg($lang['usersearch_error'], $lang['usersearch_badratio']);
                stdfoot();
                die();
            }
            $where_is.= !empty($where_is) ? " AND ":"";
            $where_is.= " (u.uploaded/u.downloaded)";
            $ratiotype = $_POST['rt'];
            $q1.= ($q1 ? "&amp;" : "") . "rt=$ratiotype";
            if ($ratiotype == "3") {
                $ratio2 = trim($_POST['r2']);
                if (!$ratio2) {
                    stdmsg($lang['usersearch_error'], $lang['usersearch_badratio2']);
                    stdfoot();
                    die();
                }
                if (!is_numeric($ratio2) or $ratio2 < $ratio) {
                    stdmsg($lang['usersearch_error'], $lang['usersearch_badratio3']);
                    stdfoot();
                    die();
                }
                $where_is.= " BETWEEN $ratio and $ratio2";
                $q1.= ($q1 ? "&amp;" : "") . "r2=$ratio2";
            } elseif ($ratiotype == "2") $where_is.= " < $ratio";
            elseif ($ratiotype == "1") $where_is.= " > $ratio";
            else $where_is.= " BETWEEN ($ratio - 0.004) and ($ratio + 0.004)";
        }
        $q1.= ($q1 ? "&amp;" : "") . "r=$ratio";
    }
    // comment
    if (is_set_not_empty('co')) {
        $comments = explode(' ', trim($_POST['co']));
        if ($comments[0] !== "") {
            foreach ($comments as $comment) {
                if (substr($comment, 0, 1) == '~') {
                    if ($comment == '~') continue;
                    $comments_exc[] = substr($comment, 1);
                } else $comments_inc[] = $comment;
            }
            if (is_array($comments_inc)) {
                $where_is.= !empty($where_is) ? " AND (":"(";
                foreach ($comments_inc as $comment) {
                    if (!haswildcard($comment)) $comment_is.= (!empty($comment_is) ? " OR ":"") . "u.modcomment LIKE " . sqlesc("%" . $comment . "%");
                    else {
                        $comment = str_replace(array(
                            '?',
                            '*'
                        ) , array(
                            '_',
                            '%'
                        ) , $comment);
                        $comment_is.= (!empty($comment_is) ? " OR ":"") . "u.modcomment LIKE " . sqlesc($comment);
                    }
                }
                $where_is.= $comment_is . ")";
                unset($comment_is);
            }
            if (is_array($comments_exc)) {
                $where_is.= !empty($where_is) ? " AND NOT (":" NOT (";
                foreach ($comments_exc as $comment) {
                    if (!haswildcard($comment)) $comment_is.= (isset($comment_is) ? " OR " : "") . "u.modcomment LIKE " . sqlesc("%" . $comment . "%");
                    else {
                        $comment = str_replace(array(
                            '?',
                            '*'
                        ) , array(
                            '_',
                            '%'
                        ) , $comment);
                        $comment_is.= (isset($comment_is) ? " OR ":"") . "u.modcomment LIKE " . sqlesc($comment);
                    }
                }
                $where_is.= $comment_is . ")";
            }
            $q1.= ($q1 ? "&amp;" : "") . "co=" . urlencode(trim($_POST['co']));
            $where_is.= (isset($where_is) ? " AND ":"") . "u.class<" . $CURUSER['class'];
        }
    }
    $unit = 1073741824; // 1GB
    // uploaded
    if (is_set_not_empty('ul')) {
        $ul = trim($_POST['ul']);
        if (!is_numeric($ul) || $ul < 0) {
            stdmsg($lang['usersearch_error'], $lang['usersearch_badup']);
            stdfoot();
            die();
        }
        $where_is.= !empty($where_is) ? " AND " : "";
        $where_is.= " u.uploaded ";
        $ultype = $_POST['ult'];
        $q1.= ($q1 ? "&amp;" : "") . "ult=$ultype";
        if ($ultype == "3") {
            $ul2 = trim($_POST['ul2']);
            if (!$ul2) {
                stdmsg($lang['usersearch_error'], $lang['usersearch_badup2']);
                stdfoot();
                die();
            }
            if (!is_numeric($ul2) or $ul2 < $ul) {
                stdmsg($lang['usersearch_error'], $lang['usersearch_badup3']);
                stdfoot();
                die();
            }
            $where_is.= " BETWEEN " . $ul * $unit . " and " . $ul2 * $unit;
            $q1.= ($q1 ? "&amp;" : "") . "ul2=$ul2";
        } elseif ($ultype == "2") $where_is.= " < " . $ul * $unit;
        elseif ($ultype == "1") $where_is.= " >" . $ul * $unit;
        else $where_is.= " BETWEEN " . ($ul - 0.004) * $unit . " and " . ($ul + 0.004) * $unit;
        $q1.= ($q1 ? "&amp;" : "") . "ul=$ul";
    }
    // downloaded
    if (is_set_not_empty('dl')) {
        $dl = trim($_POST['dl']);
        if (!is_numeric($dl) || $dl < 0) {
            stdmsg($lang['usersearch_error'], $lang['usersearch_baddl']);
            stdfoot();
            die();
        }
        $where_is.= !empty($where_is) ? " AND ":"";
        $where_is.= " u.downloaded ";
        $dltype = $_POST['dlt'];
        $q1.= ($q1 ? "&amp;" : "") . "dlt=$dltype";
        if ($dltype == "3") {
            $dl2 = trim($_POST['dl2']);
            if (!$dl2) {
                stdmsg($lang['usersearch_error'], $lang['usersearch_baddl2']);
                stdfoot();
                die();
            }
            if (!is_numeric($dl2) or $dl2 < $dl) {
                stdmsg($lang['usersearch_error'], $lang['usersearch_baddl3']);
                stdfoot();
                die();
            }
            $where_is.= " BETWEEN " . $dl * $unit . " and " . $dl2 * $unit;
            $q1.= ($q1 ? "&amp;" : "") . "dl2=$dl2";
        } elseif ($dltype == "2") $where_is.= " < " . $dl * $unit;
        elseif ($dltype == "1") $where_is.= " > " . $dl * $unit;
        else $where_is.= " BETWEEN " . ($dl - 0.004) * $unit . " and " . ($dl + 0.004) * $unit;
        $q1.= ($q1 ? "&amp;" : "") . "dl=$dl";
    }
    // date joined
    if (is_set_not_empty('d')) {
        $date = trim($_POST['d']);
        if (!$date = strtotime($date)) {
            stdmsg($lang['usersearch_error'], $lang['usersearch_baddate']);
            stdfoot();
            die();
        }
        $q1.= ($q1 ? "&amp;" : "") . "d=$date";
        $datetype = $_POST['dt'];
        $q1.= ($q1 ? "&amp;" : "") . "dt=$datetype";
        if ($datetype == "0")
        // For mySQL 4.1.1 or above use instead
        // $where_is .= (isset($where_is)?" AND ":"")."DATE(added) = DATE('$date')";
        $where_is.= (!empty($where_is) ? " AND ":"") . "(added - $date) BETWEEN 0 and 86400";
        else {
            $where_is.= (!empty($where_is) ? " AND ":"") . "u.added ";
            if ($datetype == "3") {
                $date2 = strtotime(trim($_POST['d2']));
                if ($date2) {
                    if (!$date = strtotime($date)) {
                        stdmsg($lang['usersearch_error'], $lang['usersearch_baddate']);
                        stdfoot();
                        die();
                    }
                    $q1.= ($q1 ? "&amp;" : "") . "d2=$date2";
                    $where_is.= " BETWEEN '$date' and '$date2'";
                } else {
                    stdmsg($lang['usersearch_error'], $lang['usersearch_baddate']);
                    stdfoot();
                    die();
                }
            } elseif ($datetype == "1") $where_is.= "< '$date'";
            elseif ($datetype == "2") $where_is.= "> '$date'";
        }
    }
    // date last seen
    if (is_set_not_empty('ls')) {
        $last = trim($_POST['ls']);
        if (!$last = strtotime($last)) {
            stdmsg($lang['usersearch_error'], $lang['usersearch_baddate']);
            stdfoot();
            die();
        }
        $q1.= ($q1 ? "&amp;" : "") . "ls=$last";
        $lasttype = $_POST['lst'];
        $q1.= ($q1 ? "&amp;" : "") . "lst=$lasttype";
        if ($lasttype == "0")
        // For mySQL 4.1.1 or above use instead
        // $where_is .= (isset($where_is)?" AND ":"")."DATE(added) = DATE('$date')";
        $where_is.= (!empty($where_is) ? " AND ":"") . "(last_access - $last) BETWEEN 0 and 86400";
        else {
            $where_is.= (!empty($where_is) ? " AND ":"") . "u.last_access ";
            if ($lasttype == "3") {
                $last2 = strtotime(trim($_POST['ls2']));
                if ($last2) {
                    $where_is.= " BETWEEN '$last' and '$last2'";
                    $q1.= ($q1 ? "&amp;" : "") . "ls2=$last2";
                } else {
                    stdmsg($lang['usersearch_error'], $lang['usersearch_baddate2']);
                    stdfoot();
                    die();
                }
            } elseif ($lasttype == "1") $where_is.= "< '$last'";
            elseif ($lasttype == "2") $where_is.= "> '$last'";
        }
    }
    // status
    if (is_set_not_empty('st')) {
        $status = $_POST['st'];
        $where_is.= ((!empty($where_is)) ? " AND ":"");
        if ($status == "1") $where_is.= "u.status = 'confirmed'";
        else $where_is.= "u.status = 'pending'";
        $q1.= ($q1 ? "&amp;" : "") . "st=$status";
    }
    // account status
    if (is_set_not_empty('as')) {
        $accountstatus = $_POST['as'];
        $where_is.= (!empty($where_is)) ? " AND ":"";
        if ($accountstatus == "1") $where_is.= " u.enabled = 'yes'";
        else $where_is.= " u.enabled = 'no'";
        $q1.= ($q1 ? "&amp;" : "") . "as=$accountstatus";
    }
    //donor
    if (is_set_not_empty('do')) {
        $donor = $_POST['do'];
        $where_is.= (!empty($where_is)) ? " AND ":"";
        if ($donor == 1) $where_is.= " u.donor = 'yes'";
        else $where_is.= " u.donor = 'no'";
        $q1.= ($q1 ? "&amp;" : "") . "do=$donor";
    }
    //warned
    if (is_set_not_empty('w')) {
        $warned = $_POST['w'];
        $where_is.= (!empty($where_is)) ? " AND ":"";
        if ($warned == 1) $where_is.= " u.warned >= '1'";
        else $where_is.= " u.warned = '0'";
        $q1.= ($q1 ? "&amp;" : "") . "w=$warned";
    }
    // disabled IP
    $disabled = isset($_POST['dip']) ? (int)$_POST['dip'] : '';
    if (!empty($disabled)) {
        $distinct = "DISTINCT ";
        $join_is.= " LEFT JOIN users AS u2 ON u.ip = u2.ip";
        $where_is.= ((!empty($where_is)) ? " AND " : "") . "u2.enabled = 'no'";
        $q1.= ($q1 ? "&amp;" : "") . "dip=$disabled";
    }
    // active
    $active = isset($_POST['ac']) ? $_POST['ac'] : '';
    if ($active == "1") {
        $distinct = "DISTINCT ";
        $join_is.= " LEFT JOIN peers AS p ON u.id = p.userid";
        $q1.= ($q1 ? "&amp;" : "") . "ac=$active";
    }
    $from_is = isset($join_is) ? "users AS u" . $join_is : "users AS u";
    $distinct = isset($distinct) ? $distinct : "";
    $where_is = !empty($where_is) ? $where_is : "";
    $queryc = "SELECT COUNT(" . $distinct . "u.id) FROM " . $from_is . (($where_is == "") ? "":" WHERE $where_is ");
    $querypm = "FROM " . $from_is . (($where_is == "") ? " " : " WHERE $where_is ");
    $announcement_query = 'SELECT u.id FROM ' . $from_is . (($where_is == "") ? " WHERE 1=1":" WHERE $where_is");
    $select_is = "u.id, u.username, u.email, u.status, u.added, u.last_access, u.ip,
  	u.class, u.uploaded, u.downloaded, u.donor, u.modcomment, u.enabled, u.warned";
    $query1 = "SELECT ".$distinct." ".$select_is." ".$querypm;
    //    <temporary>    /////////////////////////////////////////////////////
    if ($DEBUG_MODE > 0) {
        stdmsg($lang['usersearch_count'], $queryc);
        echo "<br /><br />";
        stdmsg($lang['usersearch_query'], $query1);
        echo "<br /><br />";
        stdmsg($lang['usersearch_url'], $q1);
        stdmsg("Announce Query", $announcement_query);
        echo "<br /><br />";
        if ($DEBUG_MODE == 2) stdfoot();
        exit();
    }
    //    </temporary>   /////////////////////////////////////////////////////
    $res = sql_query($queryc) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_row($res);
    $count = $arr[0];
    $q1 = isset($q1) ? ($q1 . "&amp;") : "";
    $perpage = 30;
    $pager = pager($perpage, $count, "staffpanel.php?tool=usersearch&amp;action=usersearch&amp;" . $q1);
    $query1.= $pager['limit'];
    $res = sql_query($query1) or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res) == 0) stdmsg($lang['usersearch_warn'], $lang['usersearch_nouser']);
    else if (mysqli_num_rows($res) == 1) {
        $usertt = mysqli_fetch_array($res);
        header('Location:userdetails.php?id=' . $usertt['id']);
        die();
    } else {
        if ($count > $perpage) $HTMLOUT.= $pager['pagertop'];
        $HTMLOUT.= "<table class='table table-bordered'>\n
        <tr><td class='colhead' align='left'>{$lang['usersearch_name']}</td>
    	  <td class='colhead' align='left'>{$lang['usersearch_ratio']}</td>
        <td class='colhead' align='left'>{$lang['usersearch_ip']}</td>
        <td class='colhead' align='left'>{$lang['usersearch_email']}</td>" . "<td class='colhead' align='left'>{$lang['usersearch_joined']}</td>" . "<td class='colhead' align='left'>{$lang['usersearch_lastseen']}</td>" . "<td class='colhead' align='left'>{$lang['usersearch_asts']}</td>" . "<td class='colhead' align='left'>{$lang['usersearch_enabled']}</td>" . "<td class='colhead'>{$lang['usersearch_pR']}</td>" . "<td class='colhead'>{$lang['usersearch_pUL']}</td>" . "<td class='colhead'>{$lang['usersearch_pDL']}</td>" . "<td class='colhead'>{$lang['usersearch_history']}</td></tr>";
        $ids = '';
        while ($user = mysqli_fetch_array($res)) {
            if ($user['ip']) {
                $nip = ip2long($user['ip']);
                $auxres = sql_query("SELECT COUNT(*) FROM bans WHERE $nip >= first AND $nip <= last") or sqlerr(__FILE__, __LINE__);
                $array = mysqli_fetch_row($auxres);
                if ($array[0] == 0) $ipstr = $user['ip'];
                else $ipstr = "<a href='staffpanel.php?tool=testip&amp;action=testip&amp;ip=" . htmlsafechars($user['ip']) . "'><font color='#FF0000'><b>" . htmlsafechars($user['ip']) . "</b></font></a>";
            } else $ipstr = "---";
            $auxres = sql_query("SELECT SUM(uploaded) AS pul, SUM(downloaded) AS pdl FROM peers WHERE userid = " . sqlesc($user['id'])) or sqlerr(__FILE__, __LINE__);
            $array = mysqli_fetch_array($auxres);
            $pul = $array['pul'];
            $pdl = $array['pdl'];
            if ($pdl > 0) $partial = ratios($pul, $pdl) . " (" . mksize($pul) . "/" . mksize($pdl) . ")";
            else if ($pul > 0) $partial = "Inf. " . mksize($pul) . "/" . mksize($pdl) . ")";
            else $partial = "---";
            $auxres = sql_query("SELECT COUNT(DISTINCT p.id)
      FROM posts AS p LEFT JOIN topics as t ON p.topic_id = t.id
      LEFT JOIN forums AS f ON t.forum_id = f.id
      WHERE p.user_id = " . sqlesc($user['id']) . " AND f.min_class_read <= " . sqlesc($CURUSER['class'])) or sqlerr(__FILE__, __LINE__);
            $n = mysqli_fetch_row($auxres);
            $n_posts = $n[0];
            $auxres = sql_query("SELECT COUNT(id) FROM comments WHERE user = " . sqlesc($user['id'])) or sqlerr(__FILE__, __LINE__);
            $n = mysqli_fetch_row($auxres);
            $n_comments = $n[0];
            $ids.= (int)$user['id'] . ':';
            $HTMLOUT.= "<tr><td><b><a href='userdetails.php?id=" . (int)$user['id'] . "'>" . htmlsafechars($user['username']) . "</a></b>" . ($user["donor"] == "yes" ? "<img src='pic/star.gif' alt=\"{$lang['usersearch_donor']}\" />" : "") . ($user["warned"] == "yes" ? "<img src=\"pic/warned.gif\" alt=\"{$lang['usersearch_warned']}\" />" : "") . "</td>
          <td>" . ratios($user['uploaded'], $user['downloaded']) . "</td>
          <td>" . $ipstr . "</td><td>" . htmlsafechars($user['email']) . "</td>
          <td><div align='center'>" . get_date($user['added'], '') . "</div></td>
          <td><div align='center'>" . get_date($user['last_access'], '', 0, 1) . "</div></td>
          <td><div align='center'>" . htmlsafechars($user['status']) . "</div></td>
          <td><div align='center'>" . htmlsafechars($user['enabled']) . "</div></td>
          <td><div align='center'>" . ratios($pul, $pdl) . "</div></td>
          <td><div align='right'>" . number_format($pul / 1048576) . "</div></td>
          <td><div align='right'>" . number_format($pdl / 1048576) . "</div></td>
          <td><div align='center'>" . ($n_posts ? "<a href='userhistory.php?action=viewposts&amp;id=" . (int)$user['id'] . "'>$n_posts</a>" : $n_posts) . "|" . ($n_comments ? "<a href='userhistory.php?action=viewcomments&amp;id=" . (int)$user['id'] . "'>$n_comments</a>" : $n_comments) . "</div></td></tr>\n";
        }
        $HTMLOUT.= "</table>";
        if ($count > $perpage) $HTMLOUT.= $pager['pagerbottom'];
        $HTMLOUT.= "
<br />

<form method='post' action='./new_announcement.php'>
<table class='table table-bordered'>
<tr>
<td>
<div align='center'>
<input name='n_pms' type='hidden' value='" . $count . "' />
<input name='ann_query' type='hidden' value='" . rawurlencode($announcement_query) . "' />
<input name='ann_hash' type='hidden' value ='" . (hashit($announcement_query, $count)) . "' />
<button type='submit'>{$lang['usersearch_create_ann']}</button>
</div></td>
</tr>
</table>
</form><br>";
    }
}
if (isset($pagemenu)) $HTMLOUT.= ("<p>$pagemenu<br />$browsemenu</p>");
echo $HTMLOUT . stdfoot();
die;
?>
