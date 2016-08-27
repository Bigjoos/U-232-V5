<?php
/// navigation site > forums > etc
function navigation_start()
{
    return "<div class='navigation'>";
}
function navigation_middle()
{
    return "&gt;";
}
function navigation_active($x)
{
    return "<br>
		<img src='templates/1/pic/carbon/nav_bit.png' alt=''>
		<span class='active'>$x</span>";
}
function navigation_end()
{
    return "</div> <br />";
}
/// end navigation site > forums > etc
?>