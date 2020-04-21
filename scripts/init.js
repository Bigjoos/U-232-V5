$(document).ready(function() {
// Question 1
$('#question_1').click(function(){

$.scrollTo('#answer_1', {duration: 500, onAfter:function(){
$('#answer_1_text').highlightFade({color:'rgb(255, 189, 112)', speed: 500});
} });
});

// Question 2
$('#question_2').click(function(){
$.scrollTo('#answer_2', {duration: 500, onAfter:function(){
$('#answer_2_text').highlightFade({color:'rgb(255, 189, 112)', speed: 500});
} });
});

// Question 3
$('#question_3').click(function(){
$.scrollTo('#answer_3', {duration: 500, onAfter:function(){
$('#answer_3_text').highlightFade({color:'rgb(255, 189, 112)', speed: 500});
} });
});

// Question 4
$('#question_4').click(function(){
$.scrollTo('#answer_4', {duration: 500, onAfter:function(){
$('#answer_4_text').highlightFade({color:'rgb(255, 189, 112)', speed: 500});
} });
});

// Question 5
$('#question_5').click(function(){
$.scrollTo('#answer_5', {duration: 500, onAfter:function(){
$('#answer_5_text').highlightFade({color:'rgb(255, 189, 112)', speed: 500});
} });
});

// Question 6
$('#question_6').click(function(){
$.scrollTo('#answer_6', {duration: 500, onAfter:function(){
$('#answer_6_text').highlightFade({color:'rgb(255, 189, 112)', speed: 500});
} });
});

// Question 7
$('#question_7').click(function(){
$.scrollTo('#answer_7', {duration: 500, onAfter:function(){
$('#answer_7_text').highlightFade({color:'rgb(255, 189, 112)', speed: 500});
} });
});

// Question 8
$('#question_8').click(function(){
$.scrollTo('#answer_8', {duration: 500, onAfter:function(){
$('#answer_8_text').highlightFade({color:'rgb(255, 189, 112)', speed: 500});
} });
});

// Question 7
$('#question_9').click(function(){
$.scrollTo('#answer_9', {duration: 500, onAfter:function(){
$('#answer_9_text').highlightFade({color:'rgb(255, 189, 112)', speed: 500});
} });
});

// Go To TOP

$('.go_to_top').click(function(){

$.scrollTo('#top_zone', {duration: 500});

});

});