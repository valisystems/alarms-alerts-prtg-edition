<li class="treeview<?php if ($page == 'device') echo ' active';?>">
    <a href="javascript:void(0)">
        <i class="fa fa-th"></i>
        <?php echo $tldev["device"]["n"];?>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

        <li<?php if ($page == 'device' && empty($page1)) echo ' class="active"';?>>
            <a href="index.php?p=device"><i class="fa fa-circle-o"></i> <?php echo $tldev["device"]["n1"];?></a>
        </li>
        <li<?php if ($page == 'device' && $page1 == 'new') echo ' class="active"';?>>
            <a href="index.php?p=device&amp;sp=new"><i class="fa fa-circle-o"></i> <?php echo $tldev["device"]["n2"];?></a>
        </li>
        <?php if ($page == 'device' && $page1 == 'edit') { ;?>
        <li class="active">
            <a href="index.php?p=device&amp;sp=edit&amp;ssp=<?php echo $page2;?>">
                <i class="fa fa-circle-o"></i> <?php echo $tldev["device"]["n3"];?>
            </a>
        </li>
        <?php } ?>

        <li<?php if ($page == 'device' && $page1 == 'files') echo ' class="active"';?>>
            <a href="index.php?p=device&amp;sp=files"><i class="fa fa-circle-o"></i> Files</a>
        </li>

        <li<?php if ($page == 'device' && $page1 == 'urls') echo ' class="active"';?>>
            <a href="index.php?p=device&amp;sp=urls"><i class="fa fa-circle-o"></i> URLs</a>
        </li>

        <li<?php if ($page == 'device' && $page1 == '3cx_urls') echo ' class="active"';?>>
            <a href="index.php?p=device&amp;sp=3cx_urls"><i class="fa fa-circle-o"></i> 3cx URLs</a>
        </li>

        <li<?php if ($page == 'device' && $page1 == 'setting') echo ' class="active"';?>>
            <a href="index.php?p=device&amp;sp=setting"><i class="fa fa-circle-o"></i> <?php echo $tl["menu"]["m2"];?></a>
        </li>
        
        <li<?php if ($page == 'device' && $page1 == 'cust_cam') echo ' class="active"';?>>
            <a href="index.php?p=device&amp;sp=cust_cam"><i class="fa fa-circle-o"></i> Custom Camera</a>
        </li>

        <li<?php if ($page == 'device' && $page1 == 'default_config') echo ' class="active"';?>>
            <a href="index.php?p=device&amp;sp=default_config"><i class="fa fa-circle-o"></i> Device default config</a>
        </li>


    </ul>

</li>
