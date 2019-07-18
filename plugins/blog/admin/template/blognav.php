<li class="treeview<?php if ($page == 'blog') echo ' active';?>"><a href="javascript:void(0)"><i class="fa fa-comments-o"></i> <?php echo $tlblog["blog"]["m"];?> <i class="fa fa-angle-left pull-right"></i></a>

<ul class="treeview-menu">

<li<?php if ($page == 'blog') echo ' class="active"';?>><a href="index.php?p=blog"><i class="fa fa-circle-o"></i> <?php echo $tlblog["blog"]["m1"];?></a></li>
<li<?php if ($page == 'blog' && $page1 == 'new') echo ' class="active"';?>><a href="index.php?p=blog&amp;sp=new"><i class="fa fa-circle-o"></i> <?php echo $tlblog["blog"]["m2"];?></a></li>
<?php if ($page == 'blog' && $page1 == 'edit') { ;?>
<li class="active"><a href="index.php?p=blog&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tlblog["blog"]["m3"];?></a></li>
<?php } ?>

<li<?php if ($page == 'blog' && $page1 == 'categories') echo ' class="active"';?>><a href="index.php?p=blog&amp;sp=categories"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m5"];?></a></li>
<li<?php if ($page == 'blog' && $page1 == 'newcategory') echo ' class="active"';?>><a href="index.php?p=blog&amp;sp=newcategory"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c4"];?></a></li>
<?php if ($page == 'blog' && $page1 == 'subcategories') { ;?>
<li class="active"><a href="index.php?p=blog&amp;sp=subcategories&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m6"];?></a></li>
<?php } if ($page == 'blog' && $page1 == 'categories' && $page2 == 'edit') { ;?>
<li class="active"><a href="index.php?p=blog&amp;sp=categories&amp;ssp=edit&amp;sssp=<?php echo $page3;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c6"];?></a></li>
<?php } ?>

<li<?php if ($page == 'blog' && $page1 == 'comment' || $page == 'blog' && $page1 == 'trash') echo ' class="active"';?>><a href="index.php?p=blog&amp;sp=comment"><i class="fa fa-circle-o"></i> <?php echo $tlblog["blog"]["d19"];?></a></li>
<li<?php if ($page == 'blog' && $page1 == 'trash') echo ' class="active"';?>><a href="index.php?p=blog&amp;sp=trash"><i class="fa fa-circle-o"></i> <?php echo $tlblog["blog"]["d18"];?></a></li>
</li>
<li<?php if ($page == 'blog' && $page1 == 'setting') echo ' class="active"';?>><a href="index.php?p=blog&amp;sp=setting"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m2"];?></a></li>

</ul>

</li>