<li class="treeview<?php if ($page == 'gallery') echo ' active';?>"><a href="javascript:void(0)"><i class="fa fa-picture-o"></i> <?php echo $tlgal["gallery"]["m"];?> <i class="fa fa-angle-left pull-right"></i></a>

<ul class="treeview-menu">

<li<?php if ($page == 'gallery') echo ' class="active"';?>><a href="index.php?p=gallery"><i class="fa fa-circle-o"></i> <?php echo $tlgal["gallery"]["m1"];?></a></li>
<li<?php if ($page == 'gallery' && $page1 == 'new') echo ' class="active"';?>><a href="index.php?p=gallery&amp;sp=new"><i class="fa fa-circle-o"></i> <?php echo $tlgal["gallery"]["m2"];?></a></li>
<?php if ($page == 'gallery' && $page1 == 'edit') { ;?>
<li class="active"><a href="index.php?p=gallery&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tlgal["gallery"]["m3"];?></a></li>
<?php } if ($page == 'gallery' && $page1 == 'showcat') { ;?>
<li class="active"><a href="index.php?p=gallery&amp;sp=showcat&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tlgal["gallery"]["d28"];?></a></li>
<?php } ?>

<li<?php if ($page == 'gallery'  && ($page1 == 'categories' || $page1 == 'newcategory')) echo ' class="active"';?>><a href="index.php?p=gallery&amp;sp=categories"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m5"];?></a></li>
<li<?php if ($page == 'gallery' && $page1 == 'newcategory') echo ' class="active"';?>><a href="index.php?p=gallery&amp;sp=newcategory"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c4"];?></a></li>
<?php if ($page == 'gallery' && $page1 == 'categories' && $page2 == 'edit') { ;?>
<li class="active"><a href="index.php?p=gallery&amp;sp=categories&amp;ssp=edit&amp;sssp=<?php echo $page3;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c6"];?></a></li>
<?php } ?>

<li<?php if ($page == 'gallery' && $page1 == 'comment' || $page == 'gallery' && $page1 == 'trash') echo ' class="active"';?>><a href="index.php?p=gallery&amp;sp=comment"><i class="fa fa-circle-o"></i> <?php echo $tlgal["gallery"]["d19"];?></a></li>
<li<?php if ($page == 'gallery' && $page1 == 'trash') echo ' class="active"';?>><a href="index.php?p=gallery&amp;sp=trash"><i class="fa fa-circle-o"></i> <?php echo $tlgal["gallery"]["d18"];?></a></li>
<li<?php if ($page == 'gallery' && $page1 == 'setting') echo ' class="active"';?>><a href="index.php?p=gallery&amp;sp=setting"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m2"];?></a></li>

</ul>

</li>