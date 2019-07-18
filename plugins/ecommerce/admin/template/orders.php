<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "s" || $page3 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page2 == "e" || $page2 == "ene" || $page3 == "e" || $page3 == "ene") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <h4><?php echo ($page2 == "e" ? $tl["errorpage"]["sql"] : $tl["errorpage"]["not"]); echo ($page3 == "e" ? $tl["errorpage"]["sql"] : $tl["errorpage"]["not"]);?></h4>
</div>
<?php } ?>

<?php if ($page2 == "booked" && isset($JAK_ORDERS)) { ?>
<h3><?php echo $tlec["shop"]["s3"];?></h3>
<div id="chart"></div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e1"])) echo $errors["e1"];?>
</div>
<?php } ?>

<form class="form-search" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

<div class="input-group">
    <input type="text" name="jakSH" class="form-control">
    <span class="input-group-btn">
    	<button type="submit" name="search" class="btn btn-default"><?php echo $tl["title"]["t30"];?></button>
    </span>
 </div>

</form>

<hr>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box">
<div class="box-body no-padding">
<div class="table-responsive">
<table class="table table-striped table-hover">
<thead>
<tr>
<th>#</th>
<th><input type="checkbox" id="jak_delete_all" /></th>
<th><?php echo $tlec["shop"]["m3"];?></th>
<th><?php echo $tl["page"]["p2"];?></th>
<th><?php echo $tlec["shop"]["m32"];?></th>
<th></th>
<th></th>
<th></th>
<th><?php if ($page2 == "orders-paid") { ?><button type="submit" name="allbooked" id="button_booked" class="btn btn-success btn-xs"><i class="fa fa-archive"></i></button><?php } ?></th>
<th></th>
<th></th>
<th><button type="submit" name="delete" id="button_delete" class="btn btn-danger btn-xs" onclick="if(!confirm('<?php echo $tlec["shop"]["alo"];?>'))return false;"><i class="fa fa-trash-o"></i></button></th>
</tr>
</thead>
<?php if (isset($JAK_ORDERS) && is_array($JAK_ORDERS)) foreach($JAK_ORDERS as $v) { ?>
<tr>
<td><?php echo $v["id"];?></td>
<td><input type="checkbox" name="jak_delete_order[]" class="highlight" value="<?php echo $v["id"];?>" /></td>
<td><a href="index.php?p=shop&amp;sp=orders&amp;ssp=edit&amp;sssp=<?php echo $v["id"];?>"><?php echo $v["ordernumber"];?></a></td>
<td><?php echo $v["ordertime"]; ?></td>
<td><?php if ($v["paidtime"] != "0000-00-00 00:00:00") { echo $v["paidtime"]; } else { echo '-'; } ?></td>
<td><a href="index.php?p=shop&sp=orders&ssp=invoice&sssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs quickedit"><i class="fa fa-file"></i></a></td>
<td><a href="index.php?p=shop&sp=orders&ssp=email&sssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs" onclick="if(!confirm('<?php echo $tlec["shop"]["se"];?>'))return false;"><i class="fa fa-paper-plane-o"></i></a></td>
<td><a href="index.php?p=shop&amp;sp=orders&amp;ssp=paid&amp;sssp=<?php echo $v["id"];?>&amp;ssssp=<?php echo $v["paid"];?>" class="btn btn-default btn-xs" onclick="if(!confirm('<?php if ($v["paid"] == '0') { echo $tlec["shop"]["sp"]; } else { echo $tlec["shop"]["spn"]; } ?>'))return false;"><i class="fa fa-<?php if ($v["paid"] == 0) { ?>exclamation-circle<?php } else { ?>check-circle<?php } ?>"></i></a></td>
<td><?php if ($v["paid"] == 1) { ?><a href="index.php?p=shop&amp;sp=orders&amp;ssp=isbooked&amp;sssp=<?php echo $v["id"];?>&amp;ssssp=<?php echo $v["booked"];?>" class="btn btn-default btn-xs" onclick="if(!confirm('<?php if ($page2 == 'booked') { echo $tlec["shop"]["sbn"]; } else { echo $tlec["shop"]["sb"]; } ?>'))return false;"><i class="fa fa-<?php if ($v["booked"] == 0) { ?>archive<?php } else { ?>check<?php } ?>"></i></a><?php } ?></td>
<td><a href="index.php?p=shop&amp;sp=orders&amp;ssp=digital&amp;sssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs" onclick="if(!confirm('<?php echo $tlec["shop"]["sd"];?>'))return false;"><i class="fa fa-floppy-o"></i></a></td>
<td><a href="index.php?p=shop&amp;sp=orders&amp;ssp=edit&amp;sssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a></td>
<td><a href="index.php?p=shop&amp;sp=orders&amp;ssp=delete&amp;sssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs" onclick="if(!confirm('<?php echo $tlec["shop"]["alo"];?>'))return false;"><i class="fa fa-trash-o"></i></a></td>
</tr>
<?php } ?>
</table>
</div>
</div>
</div>
</form>

<div class="icon_legend">
<h3><?php echo $tl["icons"]["i"];?></h3>
<i title="<?php echo $tlec["shop"]["m63"];?>" class="fa fa-file-o"></i>
<i title="<?php echo $tlec["shop"]["m38"];?>" class="fa fa-paper-plane-o"></i>
<i title="<?php echo $tlec["shop"]["m62"];?>" class="fa fa-exclamation-circle"></i>
<i title="<?php echo $tlec["shop"]["m61"];?>" class="fa fa-check-circle"></i>
<i title="<?php echo $tlec["shop"]["m65"];?>" class="fa fa-archive"></i>
<i title="<?php echo $tlec["shop"]["m64"];?>" class="fa fa-check"></i>
<i title="<?php echo $tlec["shop"]["m66"];?>" class="fa fa-floppy-o"></i>
<i title="<?php echo $tl["icons"]["i2"];?>" class="fa fa-edit"></i>
<i title="<?php echo $tl["icons"]["i1"];?>" class="fa fa-trash-o"></i>
</div>

<?php if ($JAK_PAGINATE) echo $JAK_PAGINATE;?>

<!-- JavaScript for select all -->

<script type="text/javascript">
		$(document).ready(function()
		{
			$("#jak_delete_all").click(function() {
				var checked_status = this.checked;
				$(".highlight").each(function()
				{
					this.checked = checked_status;
				});
			});			
		});
		jakWeb.jak_quickedit = "<?php echo $tlec["shop"]["m31"];?>";
</script>

<?php if ($page2 == "booked" && isset($JAK_ORDERS)) { ?>

<!-- First Stat -->
<script type="text/javascript">
var chart;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'chart',
			defaultSeriesType: 'column'
		},
		title: {
			text: '<?php echo $tlec["shop"]["s3"];?>'
		},
		xAxis: {
			categories: ['<?php echo $stat1month;?>']
		},
		yAxis: {
			min: 0,
			title: {
				text: '<?php echo $tlec["shop"]["s3"];?>'
			},
			stackLabels: {
				enabled: true,
				style: {
					fontWeight: 'bold',
					color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
				}
			}
		},
		legend: {
			align: 'right',
			x: -100,
			verticalAlign: 'top',
			y: 20,
			floating: true,
			backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
			borderColor: '#CCC',
			borderWidth: 1,
			shadow: false
		},
		tooltip: {
			formatter: function() {
				return '<b>'+ this.x +'</b><br/>'+
					this.series.name +': '+ Highcharts.numberFormat(this.y, 2);
			}
		},
		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {
					enabled: true,
					color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
				}
			}
		},
		series: [{
			name: '<?php echo $jkv["e_currency"];?>',
			data: [<?php echo $stat1total;?>]
		}<?php if ($currency_two[0]) { ?>, {
			name: '<?php echo $currency_two[0];?>',
			data: [<?php echo $stat2total;?>]
		}<?php } if ($currency_three[0]) { ?>, {
			name: '<?php echo $currency_three[0];?>',
			data: [<?php echo $stat3total;?>]
		}<?php } ?>]
	});
});
</script>

<script type="text/javascript" src="chart/highcharts.js"></script>
<script type="text/javascript" src="chart/exporting.js"></script>

<?php } ?>

		
<?php include_once APP_PATH.'admin/template/footer.php';?>