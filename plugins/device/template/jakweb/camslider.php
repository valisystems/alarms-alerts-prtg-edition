<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<script type="text/javascript">
    var camHost = "<?= $camurl; ?>";
    var auth = "<?= $basic_auth; ?>";
</script>

<script type="text/javascript" src="<?= BASE_URL ?>plugins/device/js/cam.js"></script>

<?php

    if ($camImage)
    {
        ?>

        <div id="myCarousel" class="carousel slide" data-ride="carousel">

              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <div class="item active">
                  <img src="<?= $camImage ?>" />
                  <div class="carousel-caption">
                      <a href="#" data-video="<?= $page2 ?>"  class="btn btn-default getVideo" role="button">Video</a>
                  </div>
                </div>

              </div>

              <!-- Left and right controls -->
              <a class="left carousel-control" href="/index.php?p=device&sp=cam&ssp=<?= (int)$page2 - 1?>" role="button" data-slide="prev">
                <span class="fa fa-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="/index.php?p=device&sp=cam&ssp=<?= (int)$page2 + 1?>" role="button" data-slide="next">
                <span class="fa fa-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
        </div>

        <?php
    }
    else {
        echo $content;
    }
?>


<style>
    .carousel-inner > .item >img{
        margin: 0 auto;
    }
    @media screen and (min-width: 768px)
    .carousel-control .fa-chevron-left, .carousel-control .icon-prev {
        margin-left: -10px;
    }
    @media screen and (min-width: 768px)
    .carousel-control .fa-chevron-left, .carousel-control .fa-chevron-right, .carousel-control .icon-next, .carousel-control .icon-prev {
        width: 30px;
        height: 30px;
        margin-top: -10px;
        font-size: 30px;
    }
    .carousel-control .fa-chevron-left, .carousel-control .icon-prev {
        left: 50%;
        margin-left: -10px;
    }
    .carousel-control .fa-chevron-left, .carousel-control .fa-chevron-right, .carousel-control .icon-next, .carousel-control .icon-prev {
        position: absolute;
        top: 50%;
        z-index: 5;
        display: inline-block;
        margin-top: -10px;
    }


    @media screen and (min-width: 768px)
    .carousel-control .fa-chevron-right, .carousel-control .icon-next {
        margin-right: -10px;
    }
    .carousel-control .fa-chevron-right, .carousel-control .icon-next {
        right: 50%;
        margin-right: -10px;
    }


</style>




<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>