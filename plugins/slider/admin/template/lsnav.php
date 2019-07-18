<li class="treeview<?php if ($page == 'slider') echo ' active';?>"><a href="index.php?p=slider"><i class="fa fa-circle-o"></i> <?php echo $tlls["ls"]["m"];?></a></li>
<?php if ($page == 'slider' && $page1 == "edit") { ?><li class="active"><a href="index.php?p=slider&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tlls["ls"]["m2"];?></a></li><?php } ?>
<li<?php if ($page == 'slider' && $page1 == "new") { ?> class="active"<?php } ?>><a href="index.php?p=slider&amp;sp=new"><i class="fa fa-circle-o"></i> <?php echo $tlls["ls"]["m1"];?></a></li>
</li>