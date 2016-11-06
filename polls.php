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
function parse_poll()
{
    global $CURUSER, $INSTALLER09, $mc1;
    $htmlout = "";
    $check = 0;
    $poll_footer = "";
    $GVARS = array(
        'allow_creator_vote' => 1,
        'allow_result_view' => 1,
        'allow_poll_tags' => 1
    ); // move this elsewhere later!
    if (($poll_data = $mc1->get_value('poll_data_' . $CURUSER['id'])) === false) {
        //$poll_data = array();
        //search for a poll with given ID
        $query = sql_query("SELECT * FROM polls
                            LEFT JOIN poll_voters ON polls.pid = poll_voters.poll_id
                            AND poll_voters.user_id = " . sqlesc($CURUSER['id']) . " 
                            ORDER BY polls.start_date DESC
                            LIMIT 1");
        //Did we find the poll?
        if (!mysqli_num_rows($query)) {
            return "Nothing to vote on right now!"; 
        }
        while ($row = mysqli_fetch_assoc($query)) {
            $poll_data = $row;
        }
        $mc1->cache_value('poll_data_' . $CURUSER['id'], $poll_data, $INSTALLER09['expires']['poll_data']);
    }
    //return $poll_data;
    $member_voted = 0;
    $total_votes = 0;
    //Has they ever posticated before?
    if ($poll_data['user_id']) {
        $member_voted = 1;
        //return "true";
    }
    // Make sure they can't post again
    if ($member_voted) {
        $check = 1;
        $poll_footer = 'You have already voted';
    }
    //Does we want the creator to vote on their own poll?
    if (($poll_data['starter_id'] == $CURUSER['id']) and ($GVARS['allow_creator_vote'] != 1)) {
        $check = 1;
        $poll_footer = 'poll_you_created';
    }
    //The following can be setup for guest ie; no loggedinorreturn() on index
    /*
        if ( ! $CURUSER['id'] ) //$poll_data['user_id'] )
        {
         if ( !$GVARS['allow_result_view'] )
         {
          $check 		= 2;
         }
         else
         {
        		$check      = 1;
          }
    		 return $check.$poll_footer;
        	$poll_footer = 'Guests can\'t view polls!';
        }
    */
    //allow viewing of poll results before voting?
    if ($GVARS['allow_result_view'] == 1) {
        if (isset($_GET['mode']) && $_GET['mode'] == 'show') {
            $check = 1;
            $poll_footer = "";
        }
    }
    if ($check == 1) {
        //ok, lets get this show on the road!
        $htmlout = poll_header($poll_data['pid'], htmlsafechars($poll_data['poll_question'], ENT_QUOTES));
        $poll_answers = unserialize(stripslashes($poll_data['choices']));
        reset($poll_answers);
        foreach ($poll_answers as $id => $data) {
            //subtitle question
            $question = htmlsafechars($data['question'], ENT_QUOTES);
            $choice_html = "";
            $tv_poll = 0;
            //get total votes for each choice
            foreach ($poll_answers[$id]['votes'] as $number) {
                $tv_poll+= intval($number);
            }
            // Get the choises from the unserialised array
            foreach ($data['choice'] as $choice_id => $text) {
                $choice = htmlsafechars($text, ENT_QUOTES);
                $votes = intval($data['votes'][$choice_id]);
                if (strlen($choice) < 1) {
                    continue;
                }
                if ($GVARS['allow_poll_tags']) {
                    $choice = preg_replace("/\[url=([^()<>\s]+?)\]((\s|.)+?)\[\/url\]/i", "<a href=\"\\1\">\\2</a>", $choice);
                }
                $percent = $votes == 0 ? 0 : $votes / $tv_poll * 100;
                $percent = sprintf('%.2f', $percent);
                $width = $percent > 0 ? intval($percent * 2) : 0;
                $choice_html.= poll_show_rendered_choice($choice_id, $votes, $id, $choice, $percent, $width);
            }
            $htmlout.= poll_show_rendered_question($id, $question, $choice_html);
        }
        $htmlout.= show_total_votes($tv_poll);
    } else if ($check == 2) {
        // only for guests when view before vote is off
        $htmlout = poll_header($poll_data['pid'], htmlsafechars($poll_data['poll_question'], ENT_QUOTES));
        $htmlout.= poll_show_no_guest_view();
        $htmlout.= show_total_votes($total_votes);
    } else {
        $poll_answers = unserialize(stripslashes($poll_data['choices']));
        reset($poll_answers);
        //output poll form
        $htmlout = poll_header($poll_data['pid'], htmlsafechars($poll_data['poll_question'], ENT_QUOTES));
        foreach ($poll_answers as $id => $data) {
            // get the question again!
            $question = htmlsafechars($data['question'], ENT_QUOTES);
            $choice_html = "";
            // get choices for this question
            foreach ($data['choice'] as $choice_id => $text) {
                $choice = htmlsafechars($text, ENT_QUOTES);
                $votes = intval($data['votes'][$choice_id]);
                if (strlen($choice) < 1) {
                    continue;
                }
                //do we wanna allow URL's and if so convert them
                if ($GVARS['allow_poll_tags']) {
                    $choice = $s = preg_replace("/\[url=([^()<>\s]+?)\]((\s|.)+?)\[\/url\]/i", "<a href=\"\\1\">\\2</a>", $choice);
                }
                if (isset($data['multi']) AND $data['multi'] == 1) {
                    $choice_html.= poll_show_form_choice_multi($choice_id, $votes, $id, $choice);
                } else {
                    $choice_html.= poll_show_form_choice($choice_id, $votes, $id, $choice);
                }
            }
            $choice_html = "<table style='cellpadding=4 cellspacing=0'>{$choice_html}</table>";
            $htmlout.= poll_show_form_question($id, $question, $choice_html);
        }
        $htmlout.= show_total_votes($total_votes);
    }
    $htmlout.= poll_footer();
    if ($poll_footer != "") {
        $htmlout = str_replace("<!--VOTE-->", $poll_footer, $htmlout);
    } else {
        if ($GVARS['allow_result_view'] == 1) {
            if (isset($_GET['mode']) && $_GET['mode'] == 'show') {
                $htmlout = str_replace("<!--SHOW-->", button_show_voteable() , $htmlout);
            } else {
                $htmlout = str_replace("<!--SHOW-->", button_show_results() , $htmlout);
                $htmlout = str_replace("<!--VOTE-->", button_vote() , $htmlout);
            }
        } else {
            //this section not for reviewing votes!
            $htmlout = str_replace("<!--VOTE-->", button_vote() , $htmlout);
            $htmlout = str_replace("<!--SHOW-->", button_null_vote() , $htmlout);
        }
    }
    return $htmlout;
}
///////////////////////////////////////////////
///////////////////////////////////////////////
//AUX FUNCTIONS
///////////////////////////////////////////////
///////////////////////////////////////////////
function poll_header($pid = "", $poll_q = "")
{
    global $INSTALLER09;
    $htmlout= "<script type=\"text/javascript\">
    /*<![CDATA[*/
    function go_gadget_show()
    {
      window.location = \"{$INSTALLER09['baseurl']}/index.php?pollid={$pid}&mode=show&st=main\";
    }
    function go_gadget_vote()
    {
      window.location = \"{$INSTALLER09['baseurl']}/index.php?pollid={$pid}&st=main\";
    }
    /*]]>*/
    </script>
    <form action='{$INSTALLER09['baseurl']}/polls_take_vote.php?pollid={$pid}&amp;st=main&amp;addpoll=1' method='post'>
    

";
    return $htmlout;
}
  function poll_footer()
{
    $htmlout= "<span><!--VOTE-->&nbsp;<!--SHOW--></span>
          <span><!-- no content --></span>

    </form>";
    return $htmlout;
}
function poll_show_rendered_choice($choice_id = "", $votes = "", $id = "", $answer = "", $percentage = "", $width = "")
{
    global $INSTALLER09;
    $htmlout= "<table style='cellpadding=4 cellspacing=0'><tr>
      <td style='width=25% colspan=2'>$answer</td>
      <td style='width=10% nowrap'> [ <b>$votes</b> ] </td>
      <td style='width=70% nowrap'>
      <img src='{$INSTALLER09['pic_base_url']}polls/bar.gif' width='$width' height='11' style='vertical-align:center' alt='' />
      &nbsp;[$percentage%]
      </td>
      </tr></table>";
    return $htmlout;
}
function poll_show_rendered_question($id = "", $question = "", $choice_html = "")
{
    $htmlout= "
     <div>
     <div class='roundedCorners' style='text-left; padding:4px;'><span class='postdetails'><strong>{$question}</strong></span></div>
     <table style='cellpadding=4px;cellspacing=0px'>
     $choice_html
     </table>
     </div><br />";
    return $htmlout;
}
function show_total_votes($total_votes = "")
{
    $htmlout= "<div class='text-left'><b>Total Votes: $total_votes</b></div>";
    return $htmlout;
}
function poll_show_form_choice_multi($choice_id = "", $votes = "", $id = "", $answer = "")
{
    $htmlout= "
    <tr><td style='colspan=3'><input type='checkbox' name='choice_{$id}_{$choice_id}' value='1'  />&nbsp;<b>$answer</b></td></tr>";
    return $htmlout;
}
function poll_show_form_choice($choice_id = "", $votes = "", $id = "", $answer = "")
{
    $htmlout= "
    <tr><td style='nowrap=nowrap'><input type='radio' name='choice[{$id}]' value='$choice_id'  />&nbsp;<strong>$answer</strong></td></tr>";
    return $htmlout;
}
function poll_show_form_question($id = "", $question = "", $choice_html = "")
{
    $htmlout= "
    <div align='left'>
      <div style='padding:4px;'><span class='postdetails'><strong>{$question}</strong></span></div>
      $choice_html
    </div>";
    return $htmlout;
}
function button_show_voteable()
{
    $htmlout= "<input class='btn btn-default' type='button' name='viewresult' value='Show Votes'  title='Goto poll voting' onclick=\"go_gadget_vote()\" />";
    return $htmlout;
}
function button_show_results()
{
    $htmlout= "<input class='btn btn-default' type='button' value='Results' title='Show all poll rsults' onclick=\"go_gadget_show()\" />";
    return $htmlout;
}
function button_vote()
{
    $htmlout= "<input class='btn btn-default' type='submit' name='submit' value='Vote' title='Poll Vote' />";
    return $htmlout;
}
function button_null_vote()
{
    $htmlout= "<input class='btn btn-default' type='submit' name='nullvote' value='View Results (Null Vote)' title='View results, but forfeit your vote in this poll' />";
    return $htmlout;
}
?>
