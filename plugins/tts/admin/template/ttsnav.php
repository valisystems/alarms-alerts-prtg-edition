<li class="treeview<?php if ($page == 'tts') echo ' active';?>">
    <a href="javascript:void(0)">
        <i class="fa fa-th"></i>
        <?php echo $tltts["tts"]["n"];?>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

        <li<?php if ($page == 'tts' && empty($page1) ) echo ' class="active"';?>>
            <a href="index.php?p=tts"><i class="fa fa-circle-o"></i> <?php echo $tltts["tts"]["n1"];?></a>
        </li>

        <li<?php if ($page == 'tts' && $page1 == 'files') echo ' class="active"';?>>
            <a href="index.php?p=tts&amp;sp=files"><i class="fa fa-circle-o"></i> Files</a>
        </li>

        <li<?php if ($page == 'tts' && $page1 == 'settings') echo ' class="active"';?>>
            <a href="index.php?p=tts&amp;sp=settings"><i class="fa fa-circle-o"></i> Settings</a>
        </li>

    </ul>

</li>