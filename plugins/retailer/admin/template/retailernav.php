<li class="treeview<?php if ($page == 'retailer') echo ' active';?>"><a href="javascript:void(0)"><i class="fa fa-map-marker"></i> <?php echo $tlre["retailer"]["m"];?> <i class="fa fa-angle-left pull-right"></i></a>

<ul class="treeview-menu">

<li<?php if ($page == 'retailer') echo ' class="active"';?>><a href="index.php?p=retailer"><i class="fa fa-circle-o"></i> <?php echo $tlre["retailer"]["m1"];?></a></li>
<li<?php if ($page == 'retailer' && $page1 == 'new') echo ' class="active"';?>><a href="index.php?p=retailer&amp;sp=new"><i class="fa fa-circle-o"></i> <?php echo $tlre["retailer"]["m2"];?></a></li>
<?php if ($page == 'retailer' && $page1 == 'edit') { ;?>
<li class="active"><a href="index.php?p=retailer&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tlre["retailer"]["m3"];?></a></li>
<?php } ?>

<li<?php if ($page == 'retailer'  && ($page1 == 'categories' || $page1 == 'newcategory')) echo ' class="active"';?>><a href="index.php?p=retailer&amp;sp=categories"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m5"];?></a></li>
<li<?php if ($page == 'retailer' && $page1 == 'newcategory') echo ' class="active"';?>><a href="index.php?p=retailer&amp;sp=newcategory"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c4"];?></a></li>
<?php if ($page == 'retailer' && $page1 == 'categories' && $page2 == 'edit') { ;?>
<li class="active"><a href="index.php?p=retailer&amp;sp=categories&amp;ssp=edit&amp;sssp=<?php echo $page3;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c6"];?></a></li>
<?php } ?>

<li<?php if ($page == 'retailer' && $page1 == 'comment' || $page == 'retailer' && $page1 == 'trash') echo ' class="active"';?>><a href="index.php?p=retailer&amp;sp=comment"><i class="fa fa-circle-o"></i> <?php echo $tlre["retailer"]["d19"];?></a></li>
<li<?php if ($page == 'retailer' && $page1 == 'trash') echo ' class="active"';?>><a href="index.php?p=retailer&amp;sp=trash"><i class="fa fa-circle-o"></i> <?php echo $tlre["retailer"]["d18"];?></a></li>
<li<?php if ($page == 'retailer' && $page1 == 'setting') echo ' class="active"';?>><a href="index.php?p=retailer&amp;sp=setting"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m2"];?></a></li>

</ul>

</li>