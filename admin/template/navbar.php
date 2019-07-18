<ul class="sidebar-menu">
<?php if ($JAK_MODULES) { ?>
<li class="treeview<?php if ($page == '' || $page == 'site' || $page == 'logs' || $page == 'searchlog') echo ' active';?>"><a href="javascript:void(0)"><i class="fa fa-home"></i> <?php echo $tl["menu"]["mh"];?> <i class="fa fa-angle-left pull-right"></i></a>

<ul class="treeview-menu">
<li<?php if ($page == '') echo ' class="active"';?>><a href="<?php echo BASE_URL_ADMIN;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["mh"];?></a></li>
<li<?php if ($page == 'site') echo ' class="active"';?>><a href="index.php?p=site"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c1"];?></a></li>
<li<?php if ($page == 'logs') echo ' class="active"';?>><a href="index.php?p=logs"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c48"];?></a></li>
<li<?php if ($page == 'searchlog') echo ' class="active"';?>><a href="index.php?p=searchlog"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c49"];?></a></li>
</ul>

</li>

<li class="treeview<?php if ($page == 'setting' || $page == 'plugins' || $page == 'template' || $page == 'maintenance' || $page == 'version-control') echo " active";?>"><a href="javascript:void(0)"><i class="fa fa-cogs"></i> <?php echo $tl["menu"]["m"];?> <i class="fa fa-angle-left pull-right"></i></a>

<ul class="treeview-menu">

<li<?php if ($page == 'setting') echo ' class="active"';?>><a href="index.php?p=setting"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m2"];?></a></li>

<?php if (JAK_SUPERADMINACCESS) { ?>

<li<?php if ($page == 'plugins') echo ' class="active"';?>><a href="index.php?p=plugins"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m10"];?></a></li>
<li<?php if ($page1 == 'hooks') echo ' class="active"';?>><a href="index.php?p=plugins&amp;sp=hooks"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m27"];?></a></li>
<?php if ($page1 == 'sorthooks') { ?>
<li class="active"><a href="index.php?p=plugins&amp;sp=sorthooks&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c52"];?></a></li>
<?php } if ($page1 == 'hooks' && $page2 == 'edit') { ?>
<li class="active"><a href="index.php?p=plugins&sp=hooks&ssp=edit&sssp=<?php echo $page3;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c51"];?></a></li>
<?php } ?>
<li<?php if ($page1 == 'newhook') echo ' class="active"';?>><a href="index.php?p=plugins&amp;sp=newhook"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c50"];?></a></li>
<li<?php if ($page == 'template') echo ' class="active"';?>><a href="index.php?p=template"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m23"];?></a></li>
<li<?php if ($page1 == 'edit-files') echo ' class="active"';?>><a href="index.php?p=template&amp;sp=edit-files"><i class="fa fa-circle-o"></i> <?php echo $tl["general"]["g52"];?></a></li>
<li<?php if ($page1 == 'cssedit') echo ' class="active"';?>><a href="index.php?p=template&amp;sp=cssedit"><i class="fa fa-circle-o"></i> <?php echo $tl["general"]["g53"];?></a></li>
<li<?php if ($page1 == 'langedit') echo ' class="active"';?>><a href="index.php?p=template&amp;sp=langedit"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c54"];?></a></li>
<li<?php if ($page == 'maintenance') echo ' class="active"';?>><a href="index.php?p=maintenance"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m28"];?></a></li>
<?php } ?>
</ul>

</li>

<?php } ?>

<li class="treeview<?php if ($page == 'user' || $page == 'usergroup' || $page == 'categories' || $page == 'page' || $page == 'contactform' || $page == 'poll' || $page == 'contactform' || $page == 'sitemap' || $page == 'searchsetting' || $page == 'growl' || $page == 'xml_seo' || $page == 'slider' || $page == 'belowheader' || $page == 'register-form' || $page == 'urlmapping') echo " active";?>"><a href="javascript:void(0)"><i class="fa fa-files-o"></i> <?php echo $tl["menu"]["m4"];?> <i class="fa fa-angle-left pull-right"></i></a>

<ul class="treeview-menu">

<li<?php if ($page == 'user') echo ' class="active"';?>><a href="index.php?p=user"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m3"];?></a></li>
<li<?php if ($page1 == 'newuser') echo ' class="active"';?>><a href="index.php?p=user&amp;sp=newuser"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c2"];?></a></li>
<?php if ($page == 'user' && $page1 == 'edit') { ?>
<li class="active"><a href="index.php?p=user&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c3"];?></a></li>
<?php } ?>

<li<?php if ($page == 'usergroup') echo ' class="active"';?>><a href="index.php?p=usergroup"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m9"];?></a></li>

<li<?php if ($page1 == 'newgroup') echo ' class="active"';?>><a href="index.php?p=usergroup&amp;sp=newgroup"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c11"];?></a></li>
<?php if ($page == 'usergroup' && $page1 == 'edit') { ?>
<li class="active"><a href="index.php?p=usergroup&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c12"];?></a></li>
<?php } ?>

<?php if ($JAK_MODULEM) { ?>

<li<?php if ($page == 'categories') echo ' class="active"';?>><a href="index.php?p=categories"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m5"];?></a></li>
<li<?php if ($page1 == 'newcat') echo ' class="active"';?>><a href="index.php?p=categories&amp;sp=newcat"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c4"];?></a></li>
<?php if ($page == 'categories' && $page1 == 'edit') { ?>
<li class="active"><a href="index.php?p=categories&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c6"];?></a></li>
<?php } ?>

<li<?php if ($page == 'page') echo ' class="active"';?>><a href="index.php?p=page"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m7"];?></a></li>
<li<?php if ($page1 == 'newpage') echo ' class="active"';?>><a href="index.php?p=page&amp;sp=newpage"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c5"];?></a></li>
<?php if ($page == 'page' && $page1 == 'edit') { ?>
<li class="active"><a href="index.php?p=page&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cmenu"]["c7"];?></a></li>
<?php } ?>

<li<?php if ($page == 'contactform') echo ' class="active"';?>><a href="index.php?p=contactform"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m26"];?></a></li>

<li<?php if ($page1 == 'newcontact') echo ' class="active"';?>><a href="index.php?p=contactform&amp;sp=newcontact"><i class="fa fa-circle-o"></i> <?php echo $tl["cform"]["c"];?></a></li>
<?php if ($page == 'contactform' && $page1 == 'edit') { ?>
<li class="active"><a href="index.php?p=contactform&amp;sp=<?php echo $page1;?>&amp;ssp=<?php echo $page2;?>"><i class="fa fa-circle-o"></i> <?php echo $tl["cform"]["c15"];?></a></li>
<?php } ?>

<li<?php if ($page == 'sitemap') echo ' class="active"';?>><a href="index.php?p=sitemap"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m16"];?></a></li>
<li<?php if ($page == 'searchsetting') echo ' class="active"';?>><a href="index.php?p=searchsetting"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m17"];?></a></li>
<?php } if (isset($JAK_PLUGINS_MANAGENAV) && is_array($JAK_PLUGINS_MANAGENAV)) foreach($JAK_PLUGINS_MANAGENAV as $pmn) { include_once $pmn; } ?>

</ul>

</li>

<?php if (isset($JAK_PLUGINS_TOPNAV) && is_array($JAK_PLUGINS_TOPNAV)) foreach($JAK_PLUGINS_TOPNAV as $ptn) { include_once $ptn; } ?>

</ul>