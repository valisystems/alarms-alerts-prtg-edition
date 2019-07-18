<div class="jak-like" id="likebutton<?php echo $PAGE_ID;?>">
<div class="jak-like-results"></div>
<?php if ($SHOWVOTE && $USR_CAN_RATE) { ?>
<div class="jak-like-btn likeanimated">
	<span><a href="javascript:void(0)" onclick="updateLikeCounter(<?php echo $PAGE_ID;?>,<?php echo $PLUGIN_LIKE_ID;?>,1);"><img src="/img/like/like_btn.png" alt="like-button" /></a></span>
	<span><a href="javascript:void(0)" onclick="updateLikeCounter(<?php echo $PAGE_ID;?>,<?php echo $PLUGIN_LIKE_ID;?>,2);"><img src="/img/like/love_btn.png" alt="love-button" /></a></span>
	<span><a href="javascript:void(0)" onclick="updateLikeCounter(<?php echo $PAGE_ID;?>,<?php echo $PLUGIN_LIKE_ID;?>,3);"><img src="/img/like/funny_btn.png" alt="funny-button" /></a></span>
	<span><a href="javascript:void(0)" onclick="updateLikeCounter(<?php echo $PAGE_ID;?>,<?php echo $PLUGIN_LIKE_ID;?>,4);"><img src="/img/like/smile_btn.png" alt="smile-button" /></a></span>
	<span><a href="javascript:void(0)" onclick="updateLikeCounter(<?php echo $PAGE_ID;?>,<?php echo $PLUGIN_LIKE_ID;?>,5);"><img src="/img/like/what_btn.png" alt="what-button" /></a></span>
	<span><a href="javascript:void(0)" onclick="updateLikeCounter(<?php echo $PAGE_ID;?>,<?php echo $PLUGIN_LIKE_ID;?>,6);"><img src="/img/like/cry_btn.png" alt="cry-button" /></a></span>
	<span><a href="javascript:void(0)" onclick="updateLikeCounter(<?php echo $PAGE_ID;?>,<?php echo $PLUGIN_LIKE_ID;?>,7);"><img src="/img/like/angry_btn.png" alt="angry-button" /></a></span>
</div>
<p><a href="javascript:void(0)" class="btn btn-primary jak-like-link"><i class="fa fa-thumbs-o-up"></i> <?php echo $tl["rate"]["r4"];?></a></p>
<?php } ?>
</div>