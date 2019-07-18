<li class="treeview<?php if ($page == 'faq' || $page == 'faq' && in_array($page1, array("new", "categories", "newcategory", "subcategories", "categories", "comment", "trash", "setting")) || $page == 'faq' && $page1 == 'categories' && $page2 == 'edit') echo ' active';?>"><a href="javascript:void(0)"><i class="fa fa-question-circle"></i> <?php echo $tlf["faq"]["m"];?> <i class="fa fa-angle-left pull-right"></i></a>

<ul class="treeview-menu">

<li<?php if ($page == 'faq') echo ' class="active"';?>><a href="index.php?p=faq"><i class="fa fa-circle-o"></i> <?php echo $tlf["faq"]["m1"];?></a></li>
<li<?php if ($page == 'faq' && $page1 == 'new') echo ' class="active"';?>><a href="index.php?p=faq&amp;sp=new"><i class="fa fa-circle-o"></i> <?php echo $tlf["faq"]["m2"];?></a></li>
<?php if ($page == 'faq' && $page1 == 'edit') { ;?>
<li class="active"><a href="index.php?p=faq&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tlf["faq"]["m3"];?></a></li>
<?php } ?>

<li<?php if ($page == 'faq' && $page1 == 'categories') echo ' class="active"';?>><a href="index.php?p=faq&amp;sp=categories"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m5"];?></a></li>
<li<?php if ($page == 'faq' && $page1 == 'newcategory') echo ' class="active"';?>><a href="index.php?p=faq&amp;sp=newcategory"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c4"];?></a></li>
<?php if ($page == 'faq' && $page1 == 'subcategories') { ;?>
<li class="active"><a href="index.php?p=faq&amp;sp=subcategories&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m6"];?></a></li>
<?php } if ($page == 'faq' && $page1 == 'categories' && $page2 == 'edit') { ;?>
<li class="active"><a href="index.php?p=faq&amp;sp=categories&amp;ssp=edit&amp;sssp=<?php echo $page3;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c6"];?></a></li>
<?php } ?>

<li<?php if ($page == 'faq' && $page1 == 'comment' || $page == 'faq' && $page1 == 'trash') echo ' class="active"';?>><a href="index.php?p=faq&amp;sp=comment"><i class="fa fa-circle-o"></i> <?php echo $tlf["faq"]["d19"];?></a></li>
<li<?php if ($page == 'faq' && $page1 == 'trash') echo ' class="active"';?>><a href="index.php?p=faq&amp;sp=trash"><i class="fa fa-circle-o"></i> <?php echo $tlf["faq"]["d18"];?></a></li>
<li<?php if ($page == 'faq' && $page1 == 'setting') echo ' class="active"';?>><a href="index.php?p=faq&amp;sp=setting"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m2"];?></a></li>

</ul>

</li>