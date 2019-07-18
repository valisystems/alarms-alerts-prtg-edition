<?php if (JAK_CONTACT_FORM) { ?>
<?php if ($JAK_SHOW_C_FORM_NAME['showtitle'] == 1) echo '<h3>'.$JAK_SHOW_C_FORM_NAME['title'].'</h3>';?>
			<?php if (isset($errorsA) && !empty($errorsA)) { ?>
			
			<div class="alert alert-danger fade in">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			  	<?php foreach($errorsA as $i) { echo $i; } ?>
			</div>
			
			<?php } if (!empty($_SESSION["jak_thankyou_msg"])) { ?>
			<div class="alert alert-success">
			  <?php echo $_SESSION['jak_thankyou_msg'];?>
			</div>
			<?php } ?>
			
			<form class="jak-ajaxform cFrom" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
			<div class="jak-thankyou"></div>
			<?php echo $JAK_SHOW_C_FORM;?>
			
			<input type="hidden" name="contactF" value="1" />
			
			<div class="well well-sm">
				<?php echo $tl["contact"]["n"];?> <?php echo $tl["contact"]["n1"];?> <i class="fa fa-star"></i> <?php echo $tl["contact"]["n2"];?>
			</div>
			
			<button type="submit" class="btn btn-primary btn-block jak-submit"><?php echo $tl["contact"]["s"];?></button>
			
		</form>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/contact.js"></script>
	<script type="text/javascript">

		<?php if ($jkv["hvm"]) { ?>
			jQuery(document).ready(function() {
				jQuery(".cFrom").append('<input type="hidden" name="<?php echo $random_name;?>" value="<?php echo $random_value;?>" />');
			});
		<?php } ?>
	
		if ($("input:file").length > 0) {
			$("form").removeClass("jak-ajaxform");
		}
	
		jakWeb.jak_submit = "<?php echo $tl['general']['g10'];?>";
		jakWeb.jak_submitwait = "<?php echo $tl['general']['g99'];?>";
	
	</script>
	
<?php } ?>