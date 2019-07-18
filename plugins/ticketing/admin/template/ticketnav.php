<li class="treeview<?php if ($page == 'ticketing') echo ' active';?>"><a href="javascript:void(0)"><i class="fa fa-ticket"></i> <?php echo $tlt["st"]["m"];?> <i class="fa fa-angle-left pull-right"></i></a>

<ul class="treeview-menu">

<li<?php if ($page == 'ticketing') echo ' class="active"';?>><a href="index.php?p=ticketing"><i class="fa fa-circle-o"></i> <?php echo $tlt["st"]["m1"];?></a></li>
<li<?php if ($page == 'ticketing' && $page1 == 'new') echo ' class="active"';?>><a href="index.php?p=ticketing&amp;sp=new"><i class="fa fa-circle-o"></i> <?php echo $tlt["st"]["m2"];?></a></li>
<?php if ($page == 'ticketing' && $page1 == 'edit') { ;?>
<li class="active"><a href="index.php?p=ticketing&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tlt["st"]["m3"];?></a></li>
<?php } ?>

<li<?php if ($page == 'ticketing' && $page1 == 'categories') echo ' class="active"';?>><a href="index.php?p=ticketing&amp;sp=categories"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m5"];?></a></li>
<li<?php if ($page == 'ticketing' && $page1 == 'newcategory') echo ' class="active"';?>><a href="index.php?p=ticketing&amp;sp=newcategory"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c4"];?></a></li>
<li<?php if ($page == 'ticketing' && $page1 == 'options') echo ' class="active"';?>><a href="index.php?p=ticketing&amp;sp=options"><i class="fa fa-circle-o"></i> <?php echo $tlt["st"]["d35"];?></a></li>
<li<?php if ($page == 'ticketing' && $page1 == 'options' && $page2 == 'new') echo ' class="active"';?>><a href="index.php?p=ticketing&amp;sp=options&amp;ssp=new"><i class="fa fa-circle-o"></i> <?php echo $tlt["st"]["d36"];?></a></li>
<?php if ($page == 'ticketing' && $page1 == 'options' && $page2 == 'edit') { ;?>
<li class="active"><a href="index.php?p=ticketing&amp;sp=options&amp;ssp=edit&amp;sssp=<?php echo $page3;?>"><i class="fa fa-circle-o"></i> <?php echo $tlt["st"]["m3"];?></a></li>
<?php } ?>
<li<?php if ($page == 'ticketing' && $page1 == 'comment') echo ' class="active"';?>><a href="index.php?p=ticketing&amp;sp=comment"><i class="fa fa-circle-o"></i> <?php echo $tlt["st"]["d11"];?></a></li>
<li<?php if ($page == 'ticketing' && $page1 == 'trash') echo ' class="active"';?>><a href="index.php?p=ticketing&amp;sp=trash"><i class="fa fa-circle-o"></i> <?php echo $tlt["st"]["d10"];?></a></li>
<li<?php if ($page == 'ticketing' && $page1 == 'setting') echo ' class="active"';?>><a href="index.php?p=ticketing&amp;sp=setting"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m2"];?></a></li>

</ul>

</li>