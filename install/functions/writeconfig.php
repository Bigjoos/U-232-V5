<?php
//==09 Installer by putyn
$foo = array(
    'Database' => array(
        array(
            'text' => 'Host',
            'input' => 'config[mysql_host]',
            'info' => 'Usually this will be localhost unless your on a cluster server.'
        ) ,
        array(
            'text' => 'Username',
            'input' => 'config[mysql_user]',
            'info' => 'Your mysql username.'
        ) ,
        array(
            'text' => 'Password',
            'input' => 'config[mysql_pass]',
            'info' => 'Your mysql password.'
        ) ,
        array(
            'text' => 'Database',
            'input' => 'config[mysql_db]',
            'info' => 'Your mysql database name.'
        ) ,
    ) ,
    'Tracker' => array(
        array(
            'text' => 'Announce Url',
            'input' => 'config[announce_urls]',
            'info' => 'Your announce url.'
        ) ,
        array(
            'text' => 'HTTPS Announce Url',
            'input' => 'config[announce_https]',
            'info' => 'Your HTTPS announce url.'
        ) ,
        array(
            'text' => 'Site Email',
            'input' => 'config[site_email]',
            'info' => 'Your site email address.'
        ) ,
        array(
            'text' => 'Site Name',
            'input' => 'config[site_name]',
            'info' => 'Your site name.'
        ) ,
        array(
            'text' => 'Using XBT Tracker',
            'input' => 'config[xbt_tracker]',
            'info' => 'Check if yes.'
        ) ,
    ) ,
    'Cookies' => array(
        array(
            'text' => 'Prefix',
            'input' => 'config[cookie_prefix]',
            'info' => 'Only required for sub-domain installs.'
        ) ,
        array(
            'text' => 'Path',
            'input' => 'config[cookie_path]',
            'info' => 'Only required for sub-domain installs.'
        ) ,
        array(
            'text' => 'Cookie Domain',
            'input' => 'config[cookie_domain]',
            'info' => 'Your domain name - note exclude http and www.'
        ) ,
        array(
            'text' => 'Domain',
            'input' => 'config[domain]',
            'info' => 'Your site domain name - note exclude http or www.'
        ) ,
    ) ,
    'Announce' => array(
        array(
            'text' => 'Host',
            'input' => 'announce[mysql_host]',
            'info' => 'Usually this will be localhost unless your on a cluster server.'
        ) ,
        array(
            'text' => 'Username',
            'input' => 'announce[mysql_user]',
            'info' => 'Your mysql username.'
        ) ,
        array(
            'text' => 'Password',
            'input' => 'announce[mysql_pass]',
            'info' => 'Your mysql password.'
        ) ,
        array(
            'text' => 'Database',
            'input' => 'announce[mysql_db]',
            'info' => 'Your mysql database name.'
        ) ,
        array(
            'text' => 'Domain',
            'input' => 'announce[baseurl]',
            'info' => 'Your domain name - note include http and www.'
        ) ,
    ) ,
);
function foo($x)
{
    return '/\#'.$x.'/';
}
function createblock($fo, $foo)
{
    if (file_exists('step1.lock')) header('Location: index.php?step=2');
    $out = '
	<fieldset>
		<legend>'.$fo.'</legend>
		<table align="center">';
    foreach ($foo as $bo) {$out.= '<tr>
                <td class="input_text">'.$bo['text'].'</td>';
                if(strpos($bo['input'], 'pass') == true) {$type = 'password';}
                elseif ($bo['input'] == 'config[xbt_tracker]') {$type = 'checkbox" value="yes" checked="checked';}
                else {$type = 'text';}
                $out.= '<td class="input_input"><input type="'.$type.'" name="'.$bo['input'].'" size="30"/></td>
                <td class="input_info">'.$bo['info'].'</td>
              </tr>';}
    $out.= '</table></fieldset>';
    return $out;
}
function saveconfig()
{
    global $root;
    $continue = true;
    $out = "<fieldset><legend>Write config</legend>";
    if (!file_exists('config.lock')) {
    	if(isset($_POST['config']['xbt_tracker'])) {
    		$file = "extra/config.xbtsample.php";
    		$xbt = 1;
    	}
    	else {
    		$file = "extra/config.phpsample.php";
    		$xbt = 0;
    	}
        $config = file_get_contents($file);
        $keys = array_map('foo', array_keys($_POST['config']));
        $values = array_values($_POST['config']);
        $config = preg_replace($keys, $values, $config);
        if (file_put_contents($root.'include/config.php', $config)) {
            $out.= '<div class="readable">Config file was saved</div>';
            file_put_contents('config.lock', 1);
        } else {
            $out.= '<div class="notreadable">Config file could not be saved</div>';
            $continue = false;
        }
    } else $out.= '<div class="readable">Config file was already written</div>';
    if (!file_exists('announce.lock')) {
        if(isset($_POST['config']['xbt_tracker'])) {
            $file = "extra/ann_config.xbtsample.php";
            $xbt = 1;
        }
        else {
            $file = "extra/ann_config.phpsample.php";
            $xbt = 0;
        }
        $announce = file_get_contents($file);
        $keys = array_map('foo', array_keys($_POST['announce']));
        $values = array_values($_POST['announce']);
        $announce = preg_replace($keys, $values, $announce);
        if (file_put_contents($root.'include/ann_config.php', $announce)) {
            $out.= '<div class="readable">Announce file was saved</div>';
            file_put_contents('announce.lock', 1);
        } else {
            $out.= '<div class="notreadable">announce file could not be saved</div>';
            $continue = false;
        }
    } else $out.= '<div class="readable">Announce file was already written</div>';
    if ($continue) {
        if(isset($_POST['config']['xbt_tracker'])) {
            $xbt = 1;
        }
        else {
            $xbt = 0;
        }
        $out.= '<div style="text-align:center" class="info"><input type="button" value="Next step" onclick="window.location.href=\'index.php?step=2&xbt='.$xbt.'\'"/></div>';
        file_put_contents('step1.lock', 1);
    } else $out.= '<div style="text-align:center" class="info"><input type="button" value="Go back" onclick="window.go(-1)"/></div>';
    $out.= '</fieldset>';
    print ($out);
}
?>
