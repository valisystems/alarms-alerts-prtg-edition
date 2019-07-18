<li<?php if ($page == 'belowheader') { ?> class="active"<?php } ?>><a href="index.php?p=belowheader"><i class="fa fa-circle-o"></i> <?php echo $tlbh["bh"]["m"];?></a></li>
<li<?php if ($page == 'belowheader' && $page1 == "newbh") { ?> class="active"<?php } ?>><a href="index.php?p=belowheader&amp;sp=newbh"><i class="fa fa-circle-o"></i> <?php echo $tlbh["bh"]["m1"];?></a></li>
<?php if ($page == 'belowheader' && $page1 == 'edit') { ;?>
<li class="active"><a href="index.php?p=belowheader&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tlbh["bh"]["m2"];?></a></li>
<?php } ?>