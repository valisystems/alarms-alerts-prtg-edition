<li class="treeview<?php if ($page == 'news') echo " active";?>"><a href="javascript:void(0)"><i class="fa fa-newspaper-o"></i> <?php echo $tl["menu"]["m8"];?> <i class="fa fa-angle-left pull-right"></i></a>

<ul class="treeview-menu">
<li<?php if ($page == 'news') echo ' class="active"';?>><a href="index.php?p=news"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m8"];?></a></li>
<li<?php if ($page == 'news' && $page1 == 'new') echo ' class="active"';?>><a href="index.php?p=news&amp;sp=new"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c8"];?></a></li>
<?php if ($page == 'news' && $page1 == 'edit') { ;?>
<li class="active"><a href="index.php?p=news&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c9"];?></a></li>
<?php } ?>
</li>
<li<?php if ($page == 'news' && $page1 == 'setting') echo ' class="active"';?>><a href="index.php?p=news&amp;sp=setting"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m2"];?></a></li>

</ul>

</li>