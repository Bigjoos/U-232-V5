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
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'), load_language('takelang'));
$HTMLOUT = $out = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lid = isset($_POST['language']) ? (int)$_POST['language'] : 1;

    //print_r(sqlesc($lid));
    //exit();

    if ($lid > 0 && $lid != $CURUSER['id']) sql_query('UPDATE users SET language=' . sqlesc($lid) . ' WHERE id = ' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    $mc1->begin_transaction('MyUser_' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'language' => $lid
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    $mc1->begin_transaction('user' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'language' => $lid
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    $HTMLOUT.= "<script language='javascript' type='text/javascript'>
        opener.location.reload(true);
        self.close();
      </script>";
}
$HTMLOUT.= "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>{$lang['language_choice']}</title>
<link rel='stylesheet' href='./templates/{$CURUSER['stylesheet']}/{$CURUSER['stylesheet']}.css' type='text/css' />
</head>
<body>
  <div align='center' style='width:200px'><fieldset>
    <legend>{$lang['language_choice']}</legend>
  <form action='take_lang.php' method='post'>
            <p align='center'>
          <select name='language' onchange='this.form.submit();' size='1' style='font-family: Verdana; font-size: 8pt; color: #000000; border: 1px solid #808080; background-color: #ececec'>";
$out.= "<option value='1'" . ($CURUSER['language'] == '1' ? " selected='selected'" : "") . ">{$lang['language_loc1']}</option>
    	<option value='2'" . ($CURUSER['language'] == '2' ? " selected='selected'" : "") . ">{$lang['language_loc4']}</option>";   
//<option value='3'" . ($CURUSER['language'] == '3' ? " selected='selected'" : "") . ">Rm</option>";
$HTMLOUT.= $out;
$HTMLOUT.= "</select>
   <input type='button' value='".$lang['language_close']."' onclick='self.close()' /></p></form>
</fieldset></div></body></html>";
echo $HTMLOUT;
exit();
?>
