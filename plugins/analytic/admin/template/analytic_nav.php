<li class="treeview<?php if ($page == 'analytic') echo ' active';?>">
    <a href="javascript:void(0)">
        <i class="fa fa-bar-chart"></i>
        <?php echo $tlanalytic["analytic"]["n"];?>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

        <li<?php if ($page == 'analytic' && empty($page1)) echo ' class="active"';?>>
            <a href="index.php?p=analytic"><i class="fa fa-tachometer"></i> <?php echo $tlanalytic["analytic"]["n1"];?></a>
        </li>

        <li<?php if ($page == 'analytic' && $page1 == 'sync') echo ' class="active"';?>>
            <a href="index.php?p=analytic&amp;sp=sync"><i class="fa fa-refresh"></i> Sync Account</a>
        </li>

        <li<?php if ($page == 'analytic' && $page1 == 'accts' && empty($page2)) echo ' class="active"';?>>
            <a href="index.php?p=analytic&amp;sp=accts"><i class="fa fa-phone"></i> Accounts</a>
        </li>

        <li<?php if ($page == 'analytic' && $page1 == 'add') echo ' class="active"';?>>
            <a href="index.php?p=analytic&amp;sp=accts&amp;ssp=add"><i class="fa fa-plus"></i> Add Account</a>
        </li>

        <li<?php if ($page == 'analytic' && $page2 == 'rep') echo ' class="active"';?>>
            <a href="index.php?p=analytic&amp;sp=accts&amp;ssp=rep"><i class="fa fa-circle-o"></i> Reports</a>
        </li>

        <li<?php if ($page == 'analytic' && $page2 == 'filter') echo ' class="active"';?>>
            <a href="index.php?p=analytic&amp;sp=accts&amp;ssp=filter"><i class="fa fa-filter"></i> Filter</a>
        </li>

        <li<?php if ($page == 'analytic' && $page1 == 'dev_rep') echo ' class="active"';?>>
            <a href="index.php?p=analytic&amp;sp=dev_rep"><i class="fa fa-circle-o"></i> Device Report</a>
        </li>

        <li<?php if ($page == 'analytic' && $page1 == 'settings') echo ' class="active"';?>>
            <a href="index.php?p=analytic&amp;sp=settings"><i class="fa fa-cog"></i> Settings</a>
        </li>

    </ul>

</li>