<?php
function db_test()
{
    global $root, $INSTALLER09;
    $out = '<fieldset><legend>Database</legend>';
    require_once ($root.'include/config.php');
    $mysqli_test = new mysqli($INSTALLER09['mysql_host'], $INSTALLER09['mysql_user'], $INSTALLER09['mysql_pass'], $INSTALLER09['mysql_db']);
    if (!$mysqli_test->connect_error) {
        $out.= '<div class="readable">Connection to database was made</div>';
        if ($mysqli_test->select_db($INSTALLER09['mysql_db'])) {
            $out.= '<div class="readable">Data base exists, data can be imported</div>';
            $out.= '<form action="index.php" method="post"><div class="info" style="text-align:center;"><input type="hidden" name="do" value="db_insert" /><input type="hidden" name="xbt" value="'.$_GET['xbt'].'" /><input type="submit" value="Import database" /></div></form>';
        } else $out.= '<div class="notreadable">There was an error while selecting the database<br/>'.$mysqli_test->error.'</div><div class="info" style="text-align:center"><input type="button" value="Reload" onclick="window.location.reload()"/></div>';
    } else $out.= '<div class="notreadable">There was an error while connection to the database<br/>'.$mysqli_test->connect_error.'</div><div class="info" style="text-align:center"><input type="button" value="Reload" onclick="window.location.reload()"/></div>';
    $out.= '</fieldset>';
    print ($out);
}
//== Win - remember to set your path up correctly in the query- atm its set for appserv c:\AppServ\MySQL\bin\mysql
function db_insert()
{
    global $root, $INSTALLER09;
    $out = '<fieldset><legend>Database</legend>';
    require_once ($root.'include/config.php');
    if($_POST['xbt'] == 1) $file = "install.xbt.sql";
    elseif($_POST['xbt'] == 0) $file = "install.php.sql";
    $q = sprintf('/usr/bin/mysql -h %s -u %s -p%s %s < %sinstall/extra/'.$file, $INSTALLER09['mysql_host'], $INSTALLER09['mysql_user'], $INSTALLER09['mysql_pass'], $INSTALLER09['mysql_db'], $root); //== Linux
    //$q = sprintf('c:\AppServ\MySQL\bin\mysql -h %s -u %s -p%s %s < %sinstall/extra/'.$file,$INSTALLER09['mysql_host'],$INSTALLER09['mysql_user'],$INSTALLER09['mysql_pass'],$INSTALLER09['mysql_db'],$root);  //== Win - remember to set your path up correctly - atm its set for appserv
    exec($q, $o);
    if (!count($o)) {
        $out.= '<div class="readable">Database was imported</div><div class="info" style="text-align:center"><input type="button" value="Finish" onclick="window.location.href=\'?step=3\'"/></div>';
        file_put_contents('step2.lock', 1);
    } else $out.= '<div class="notreadable">There was an error while importing the database<br/>'.$o.'</div>';
    $out.= '</fieldset>';
    print ($out);
}
?>
