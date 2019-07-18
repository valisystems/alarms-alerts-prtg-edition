<li<?php if ($page == 'urlmapping') { ?> class="active"<?php } ?>><a href="index.php?p=urlmapping"><i class="fa fa-circle-o"></i> <?php echo $tlum["um"]["m"];?></a></li>
<li<?php if ($page == 'urlmapping' && $page1 == "new") { ?> class="active"<?php } ?>><a href="index.php?p=urlmapping&amp;sp=new"><i class="fa fa-circle-o"></i> <?php echo $tlum["um"]["m1"];?></a></li>
<?php if ($page == 'urlmapping' && $page1 == 'edit') { ;?>
<li class="active"><a href="index.php?p=urlmapping&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tlum["um"]["m2"];?></a></li>
<?php } ?>