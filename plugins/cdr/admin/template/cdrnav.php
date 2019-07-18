<li class="treeview<?php if ($page == 'cdr') echo ' active';?>">
    <a href="javascript:void(0)">
        <i class="fa fa-th"></i>
        <?php echo $tlcdr["cdr"]["n"];?>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

        <li<?php if ($page == 'cdr' && empty($page1)) echo ' class="active"';?>>
            <a href="index.php?p=cdr"><i class="fa fa-circle-o"></i> <?php echo $tlcdr["cdr"]["n1"];?></a>
        </li>

        <li<?php if ($page == 'cdr' && $page1 == 'settings') echo ' class="active"';?>>
            <a href="index.php?p=cdr&amp;sp=settings"><i class="fa fa-circle-o"></i> Settings</a>
        </li>


    </ul>

</li>