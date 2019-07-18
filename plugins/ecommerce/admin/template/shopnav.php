<li class="treeview<?php if ($page == 'shop') echo ' active';?>"><a href="javascript:void(0)"><i class="fa fa-shopping-cart"></i> <?php echo $tlec["shop"]["m"];?> <i class="fa fa-angle-left pull-right"></i></a>

<ul class="treeview-menu">

<li<?php if ($page == 'shop' && $page1 == '' || $page == 'shop' && $page1 == 'new' || $page == 'shop' && $page1 == 'edit') echo ' class="active"';?>><a href="index.php?p=shop"><i class="fa fa-circle-o"></i> <?php echo $tlec["shop"]["m52"];?></a></li>
<li<?php if ($page == 'shop' && $page1 == 'new') echo ' class="active"';?>><a href="index.php?p=shop&amp;sp=new"><i class="fa fa-circle-o"></i> <?php echo $tlec["shop"]["m4"];?></a></li>
<?php if ($page == 'shop' && $page1 == 'edit') { ;?>
<li class="active"><a href="index.php?p=shop&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tlec["shop"]["m30"];?></a></li>
<?php } ?>

<li<?php if ($page == 'shop' && ($page1 == 'categories' || $page1 == 'newcategory')) echo ' class="active"';?>><a href="index.php?p=shop&amp;sp=categories"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m5"];?></a></li>
<li<?php if ($page == 'shop' && $page1 == 'newcategory') echo ' class="active"';?>><a href="index.php?p=shop&amp;sp=newcategory"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c4"];?></a></li>
<?php if ($page == 'shop' && $page1 == 'categories' && $page2 == 'edit') { ;?>
<li class="active"><a href="index.php?p=shop&amp;sp=categories&amp;ssp=edit&amp;sssp=<?php echo $page3;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c6"];?></a></li>
<?php } ?>


<li<?php if ($page == 'shop' && $page1 == 'coupons') echo ' class="active"';?>><a href="index.php?p=shop&amp;sp=coupons"><i class="fa fa-circle-o"></i> <?php echo $tlec["shop"]["m77"];?></a></li>
<li<?php if ($page1 == 'coupons' && $page2 == 'new') echo ' class="active"';?>><a href="index.php?p=shop&amp;sp=coupons&amp;ssp=new"><i class="fa fa-circle-o"></i> <?php echo $tlec["shop"]["m78"];?></a></li>
<?php if ($page1 == 'coupons' && $page2 == 'edit') { ;?>
<li class="active"><a href="index.php?p=shop&amp;sp=coupons&amp;ssp=edit&amp;sssp=<?php echo $page3;?>"><i class="fa fa-circle-o"></i> <?php echo $tlec["shop"]["m83"];?></a></li>
<?php } ?>

<li<?php if ($page == 'shop' && $page1 == 'orders') echo ' class="active"';?>><a href="index.php?p=shop&amp;sp=orders"><i class="fa fa-circle-o"></i> <?php echo $tlec["shop"]["m1"];?></a></li>
<li<?php if ($page1 == 'orders' && $page2 == 'orders-paid') echo ' class="active"';?>><a href="index.php?p=shop&amp;sp=orders&amp;ssp=orders-paid"><i class="fa fa-circle-o"></i> <?php echo $tlec["shop"]["m67"];?></a></li>
<li<?php if ($page1 == 'orders' && $page2 == 'booked') echo ' class="active"';?>><a href="index.php?p=shop&amp;sp=orders&amp;ssp=booked"><i class="fa fa-circle-o"></i> <?php echo $tlec["shop"]["m59"];?></a></li>
<li<?php if ($page == 'shop' && $page1 == 'ecpayment') echo ' class="active"';?>><a href="index.php?p=shop&amp;sp=ecpayment"><i class="fa fa-circle-o"></i> <?php echo $tlec["shop"]["m2"];?></a></li>
<li<?php if ($page == 'shop' && $page1 == 'ecshipping') echo ' class="active"';?>><a href="index.php?p=shop&amp;sp=ecshipping"><i class="fa fa-circle-o"></i> <?php echo $tlec["shop"]["m44"];?></a></li>
<li<?php if ($page1 == 'ecshipping' && $page2 == 'new') echo ' class="active"';?>><a href="index.php?p=shop&amp;sp=ecshipping&amp;ssp=new"><i class="fa fa-circle-o"></i> <?php echo $tlec["shop"]["m47"];?></a></li>

<li<?php if ($page == 'shop' && $page1 == 'ecsetting') echo ' class="active"';?>><a href="index.php?p=shop&amp;sp=ecsetting"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m2"];?></a></li>

</ul>

</li>