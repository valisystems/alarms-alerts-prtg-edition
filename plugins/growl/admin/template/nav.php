<li<?php if ($page == 'growl') echo ' class="active"';?>><a href="index.php?p=growl"><i class="fa fa-circle-o"></i> <?php echo $tlgwl["growl"]["m"];?></a>
<li<?php if ($page == 'growl' && $page1 == 'new') echo ' class="active"';?>><a href="index.php?p=growl&amp;sp=new"><i class="fa fa-circle-o"></i> <?php echo $tlgwl["growl"]["m1"];?></a></li>
<?php if ($page == 'growl' && $page1 == 'edit') { ;?>
<li class="active"><a href="index.php?p=growl&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tlgwl["growl"]["m2"];?></a></li>
<?php } ?>
</li>