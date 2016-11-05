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
$step = isset($_GET['step']) ? (int)$_GET['step'] : 0;
$root = $_SERVER['DOCUMENT_ROOT'];
if ($root[strlen($root) - 1] != DIRECTORY_SEPARATOR) $root = $root.DIRECTORY_SEPARATOR;
if (file_exists($root.'include/install.lock')) die('This was already installed, huh ? how this happened');
function checkpreviousstep()
{
    $step = isset($_GET['step']) ? (int)$_GET['step'] - 1 : 0;
    if (!file_exists('step'.$step.'.lock')) header('Location: index.php?step='.$step);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>U-232 V5</title>
<link type="text/css" href="extra/installer.css" rel="stylesheet" />
</head>
<body>

<div id="wrapper">
<div id="logo"></div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $valid_do = array(
        'write' => 1,
        'db_insert' => 1
    );
    $do = isset($_POST['do']) && isset($valid_do[$_POST['do']]) ? $_POST['do'] : false;
    switch ($do) {
    case 'write':
        require_once ('functions/writeconfig.php');
        saveconfig();
        break;

    case 'db_insert':
        require_once ('functions/database.php');
        db_insert();
        break;

    default:
        print ('<fieldset><div class="notreadable">Unknown action</div></fieldset>');
    }
} else {
    switch ($step) {
    case 0:
        require_once ('functions/permissioncheck.php');
        print (permissioncheck());
        break;

    case 1:
        checkpreviousstep();
        require_once ('functions/writeconfig.php');
        $out = '<form action="index.php" method="post">';
        foreach ($foo as $fo => $fooo) $out.= createblock($fo, $fooo);
        $out.= '<fieldset><div style="text-align:center"><input type="submit" value="Submit data" /><input type="hidden" value="write" name="do" /></div></fieldset></form>';
        print ($out);
        break;

    case 2:
        checkpreviousstep();
        require_once ('functions/database.php');
        db_test();
        break;

    case 3:
        $out = '<fieldset><legend>All done</legend><div class="info">Installation complete<br><br>Remember to remove this install directory</div><a href="/signup.php" class="btn">Getting Started</a></fieldset>';
        print ($out);
        break;
    }
}
?>
</div>
</body>
</html>
