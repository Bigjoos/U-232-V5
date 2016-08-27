<?php
$GVARS = array(
    'rep_is_online' => 1,
    'rep_default' => 10,
    'rep_undefined' => 'is off the scales',
    'rep_userrates' => 5,
    'rep_adminpower' => 5,
    'rep_rdpower' => 365,
    'rep_pcpower' => 1000,
    'rep_kppower' => 100,
    'rep_minpost' => 50,
    'rep_minrep' => 10,
    'rep_maxperday' => 10,
    'rep_repeat' => 20,
    'g_rep_negative' => TRUE,
    'g_rep_seeown' => TRUE,
    'g_rep_use' => $CURUSER['class'] > UC_USER ? TRUE : FALSE
);
?>