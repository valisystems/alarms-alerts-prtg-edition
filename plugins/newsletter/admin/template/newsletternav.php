<li class="treeview<?php if ($page == 'newsletter') echo ' active';?>"><a href="javascript:void(0)"><i class="fa fa-envelope-o"></i> <?php echo $tlnl["nletter"]["m"];?> <i class="fa fa-angle-left pull-right"></i></a>

<ul class="treeview-menu">

<li<?php if ($page == 'newsletter') echo ' class="active"';?>><a href="index.php?p=newsletter"><i class="fa fa-circle-o"></i> <?php echo $tlnl["nletter"]["m1"];?></a></li>
<li<?php if ($page == 'newsletter' && $page1 == 'new') echo ' class="active"';?>><a href="index.php?p=newsletter&amp;sp=new"><i class="fa fa-circle-o"></i> <?php echo $tlnl["nletter"]["m2"];?></a></li>
<?php if ($page == 'newsletter' && $page1 == 'edit') { ;?>
<li class="active"><a href="index.php?p=newsletter&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tlnl["nletter"]["m3"];?></a></li>
<?php } ?>
<li<?php if ($page == 'newsletter' && $page1 == 'user') echo ' class="active"';?>><a href="index.php?p=newsletter&amp;sp=user"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m3"];?></a></li>
<li<?php if ($page == 'newsletter' && $page2 == 'newuser') echo ' class="active"';?>><a href="index.php?p=newsletter&amp;sp=user&amp;ssp=newuser"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c2"];?></a></li>
<li<?php if ($page == 'newsletter' && $page1 == 'usergroup') echo ' class="active"';?>><a href="index.php?p=newsletter&amp;sp=usergroup"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m9"];?></a></li>
<li<?php if ($page == 'newsletter' && $page1 == 'usergroup' && $page2 == 'new') echo ' class="active"';?>><a href="index.php?p=newsletter&amp;sp=usergroup&amp;ssp=new"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c11"];?></a></li>
<li<?php if ($page == 'newsletter' && $page1 == 'settings') echo ' class="active"';?>><a href="index.php?p=newsletter&amp;sp=settings"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m2"];?></a></li>

</ul>

</li>