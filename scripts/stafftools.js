      $(document).ready(function()	{
      $(function(){
      jQuery('.poll_select').trilemma({max:'.$multi_options.',disablelabels:true});
      });
      });
      $(document).ready(function()	{
      //=== show hide staff tools
      $("#tool_open").click(function() {
      $("#tools").slideToggle("slow", function() {
      });
      });
      //=== show hide voters
      $("#toggle_voters").click(function() {
      $("#voters").slideToggle("slow", function() {
      });
      });
      });
      //=== show hide send PM
      $("#pm_open").click(function() {
      $("#pm").slideToggle("slow", function() {
      });
      });