<script type="text/javascript">
$(document).ready(function() {
$("a[href^='http']:not([href^='<?php echo BASE_URL;?>'])")
  .attr({
    target: "_blank"
  })
});
</script>