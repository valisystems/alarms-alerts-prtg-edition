<?php include "header.php";?>

<?php if (!isset($jkv["email"])) { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <h4><?php echo $tl["error"]["e3"];?>- <a href="index.php?p=setting"><?php echo $tl["menu"]["m2"];?></a></h4>
</div>
<?php } ?>

<?php if (!isset($jkv["cms_tpl"])) { ?>
<div class="alert alert-danger fade in">
  <i class="fa fa-exclamation-triangle"></i> <a href="index.php?p=template"><?php echo $tl["error"]["e17"];?></a>
</div>
<?php } ?>

<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?php echo $totalhits;?></h3>
        <p><?php echo $tl["stat"]["s1"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-bar-chart"></i>
      </div>
      <a href="index.php?p=page" class="small-box-footer"><?php echo $tl["stat"]["s6"];?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3><?php echo $JAK_COUNTS["searchClog"];?></h3>
        <p><?php echo $tl["stat"]["s3"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-search"></i>
      </div>
      <a href="index.php?p=searchlog" class="small-box-footer"><?php echo $tl["stat"]["s6"];?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3><?php echo $JAK_COUNTS["pluginCtotal"];?></h3>
        <p><?php echo $tl["stat"]["s4"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-plug"></i>
      </div>
      <a href="index.php?p=plugins" class="small-box-footer"><?php echo $tl["stat"]["s6"];?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <?php if (JAK_TAGS) { ?>
    <div class="small-box bg-red">
      <div class="inner">
        <h3><?php echo $JAK_COUNTS["tagsCtotal"];?></h3>
        <p><?php echo $tl["stat"]["s5"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-tags"></i>
      </div>
      <a href="index.php?p=tags" class="small-box-footer"><?php echo $tl["stat"]["s6"];?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
    <?php } else { ?>
    <div class="small-box bg-red">
      <div class="inner">
        <h3><?php echo $JAK_COUNTS["hookCtotal"];?></h3>
        <p><?php echo $tl["stat"]["s7"];?></p>
      </div>
      <div class="icon">
        <i class="fa fa-flash"></i>
      </div>
      <a href="index.php?p=plugins&sp=hooks" class="small-box-footer"><?php echo $tl["stat"]["s6"];?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
    <?php } ?>
  </div><!-- ./col -->
</div><!-- /.row -->

<div class="row">
<div class="col-md-6">
<div class="box box-primary">
  <div class="box-header">
    <i class="fa fa-paperclip"></i>
    <h3 class="box-title"><?php echo $tl["title"]["t24"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
	<ul class="todoList">
		<?php if (isset($todos) && is_array($todos)) foreach($todos as $item) { echo $item; } ?>
	</ul>
</div>
<div class="box-footer clearfix no-border">
  <a id="addButton" class="btn btn-default btodo pull-right" href="#"><?php echo $tl["general"]["g115"];?></a>
</div>
</div>
<div class="box">
  <div class="box-header">
  	<i class="fa fa-pie-chart"></i>
    <h3 class="box-title"><?php echo $tl["title"]["t19"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body no-padding">
	<div id="chart_total" class="charts"></div>
</div>
</div>
<?php if (isset($JAK_HOOK_ADMIN_INDEX) && is_array($JAK_HOOK_ADMIN_INDEX)) foreach($JAK_HOOK_ADMIN_INDEX as $hspi) { include_once APP_PATH.$hspi['phpcode']; } ?>
</div>
<div class="col-md-6">
<div class="box">
  <div class="box-header">
  <i class="fa fa-server"></i>
    <h3 class="box-title"><?php echo $tl["title"]["t"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body no-padding">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["general"]["g8"];?></td>
	<td><?php echo $WEBS;?></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g9"];?></td>
	<td><?php echo $PHPV;?></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g10"];?></td>
	<td><?php echo $POSTM;?></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g11"];?></td>
	<td><?php echo $MEML;?></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g12"];?></td>
	<td><?php echo $MYV;?></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g13"];?></td>
	<td><?php echo $SRVIP;?></td>
</tr>
</table>
</div>
</div>
<div class="box">
  <div class="box-header">
  <i class="fa fa-info-circle"></i>
    <h3 class="box-title"><?php echo $tl["title"]["t1"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body no-padding">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["menu"]["m12"];?></td>
	<td><?php echo $jkv["version"];?></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g14"];?></td>
	<td><a href="http://www.claricom.ca">CLARICOM</a></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g15"];?></td>
	<td>Claricom</td>
</tr>
</table>
</div>
</div>
</div>		
</div>

<?php if ($pageCdata) { ?>
<!-- First Stat -->
<script type="text/javascript">
var jakchart;
$(document).ready(function() {

	jakchart = new Highcharts.Chart({
			chart: {
				renderTo: 'chart_total'
			},
			title: {
				text: '<?php echo $tl["title"]["t19"];?>'
			},
			xAxis: {
						categories: ['<?php echo $tl["stat"]["s2"];?>'],
						title: {
							text: null
						}
					},
			yAxis: {
				min: 0,
				title: {
					text: '<?php echo $tl["stat"]["s"];?>',
					align: 'high'
				}
			},
			tooltip: {
				formatter: function() {
					var s;
					if (this.point.name) { // the pie chart
						s = ''+
							this.point.name +': '+ this.y +' <?php echo $tl["general"]["g56"];?>';
					} else {
						s = ''+
							this.series.name  +': '+ this.y;
					}
					return s;
				}
			},
			labels: {
				items: [{
					html: '<?php echo $tl["stat"]["s1"];?>',
					style: {
						left: '5px',
						top: '5px',
						color: 'black'
					}
				}]
			},
			series: [{
				type: 'column',
				name: '<?php echo $tl["menu"]["m7"];?>',
				data: [<?php echo $JAK_COUNTS["pageCtotal"];?>]
			}, {
				type: 'column',
				name: '<?php echo $tl["menu"]["t"];?>',
				data: [<?php echo $JAK_COUNTS["tagsCtotal"];?>]
			}, {
				type: 'column',
				name: '<?php echo $tl["menu"]["m3"];?>',
				data: [<?php echo $JAK_COUNTS["userCtotal"];?>]
			}, {
				type: 'column',
				name: '<?php echo $tl["menu"]["m14"];?>',
				data: [<?php echo $JAK_COUNTS["pluginCtotal"];?>]
			}, {
				type: 'column',
				name: '<?php echo $tl["menu"]["m27"];?>',
				data: [<?php echo $JAK_COUNTS["hookCtotal"];?>]
			}, {
				type: 'pie',
				name: '<?php echo $tl["stat"]["s1"];?>',
				data: [<?php echo $pageCdata;?>],
				center: [60, 80],
				size: 100,
				showInLegend: false,
				dataLabels: {
					enabled: false
				}
			}]
		});
});
</script>

<script type="text/javascript" src="chart/highcharts.js"></script>
<script type="text/javascript" src="chart/exporting.js"></script>

<?php } ?>

<script src="js/todo.js" type="text/javascript"></script>

<?php include "footer.php";?>