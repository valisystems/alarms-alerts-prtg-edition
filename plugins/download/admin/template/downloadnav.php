<li class="treeview<?php if ($page == 'download') echo ' active';?>"><a href="javascript:void(0)"><i class="fa fa-download"></i> <?php echo $tld["dload"]["m"];?> <i class="fa fa-angle-left pull-right"></i></a>

<ul class="treeview-menu">

<li<?php if ($page == 'download') echo ' class="active"';?>><a href="index.php?p=download"><i class="fa fa-circle-o"></i> <?php echo $tld["dload"]["m1"];?></a></li>
<li<?php if ($page == 'download' && $page1 == 'new') echo ' class="active"';?>><a href="index.php?p=download&amp;sp=new"><i class="fa fa-circle-o"></i> <?php echo $tld["dload"]["m2"];?></a></li>
<?php if ($page == 'download' && $page1 == 'edit') { ;?>
<li class="active"><a href="index.php?p=download&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tld["dload"]["m3"];?></a></li>
<?php } ?>

<li<?php if ($page == 'download'  && ($page1 == 'categories' || $page1 == 'newcategory')) echo ' class="active"';?>><a href="index.php?p=download&amp;sp=categories"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m5"];?></a></li>
<li<?php if ($page == 'download' && $page1 == 'newcategory') echo ' class="active"';?>><a href="index.php?p=download&amp;sp=newcategory"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c4"];?></a></li>
<?php if ($page == 'download' && $page1 == 'categories' && $page2 == 'edit') { ;?>
<li class="active"><a href="index.php?p=download&amp;sp=categories&amp;ssp=edit&amp;sssp=<?php echo $page3;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c6"];?></a></li>
<?php } ?>

<li<?php if ($page == 'download' && $page1 == 'comment' || $page == 'download' && $page1 == 'trash') echo ' class="active"';?>><a href="index.php?p=download&amp;sp=comment"><i class="fa fa-circle-o"></i> <?php echo $tld["dload"]["d19"];?></a>
<li<?php if ($page == 'download' && $page1 == 'trash') echo ' class="active"';?>><a href="index.php?p=download&amp;sp=trash"><i class="fa fa-circle-o"></i> <?php echo $tld["dload"]["d18"];?></a></li>
</li>
<li<?php if ($page == 'download' && $page1 == 'setting') echo ' class="active"';?>><a href="index.php?p=download&amp;sp=setting"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m2"];?></a></li>

</ul>

</li>