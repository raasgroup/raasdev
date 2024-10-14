<?php
// Include the parent theme's footer
require get_template_directory() . '/footer.php';
?>

<script>
<?php 
if ($name == '' || $name == 'research')  //the home page
	@require_once('researchfooter.js');
?>
</script>
<script>
<?php 
if ($name == 'raas_team')
	@require_once('teamtemplate.js');
?>
</script>
<script>
<?php
//echo 'page:' . $name;
?>
</script>
