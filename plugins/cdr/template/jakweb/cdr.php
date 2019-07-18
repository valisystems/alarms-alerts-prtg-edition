<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=cdr';?>


<?php 	if ($PAGE_PASSWORD && !JAK_ASACCESS && $PAGE_PASSWORD != $_SESSION['pagesecurehashpasswordProtected'])
		{
			if ($errorpp){ 
				?>
		        	
			<!-- Show password error -->
		    <div class="alert alert-danger fade in">
		      <button type="button" class="close" data-dismiss="alert">×</button>
		      	<h4><?php echo $errorpp["e"];?></h4>
		    </div>
			<?php } ?>
	
			<!-- Show password form -->
			<form class="form-inline" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<div class="input-group">
			      <input type="password" name="pagepass" class="form-control" value="" placeholder="<?php echo $tl["general"]["g29"]; ?>" />
			      <span class="input-group-btn">
			        <button class="btn btn-default" name="protected" type="submit"><?php echo $tl["general"]["g83"];?></button>
			      </span>
			    </div>
			<input type="hidden" name="action" value="passwordProtected" />
			
			</form>

<?php 	}
		else
		{

			if ($PAGE_CONTENT) echo $PAGE_CONTENT;?>
			<link type="text/css" rel="stylesheet" href="<?= BASE_URL ?>plugins/cdr/css/jquery.dataTables.min.css" />

			<script type="text/javascript" src="<?= BASE_URL ?>plugins/cdr/js/cdr.js"></script>
			<script type="text/javascript" src="<?= BASE_URL ?>plugins/cdr/js/jquery.dataTables.min.js"></script>
			<link rel="stylesheet"  href="/plugins/analytic/css/buttons.dataTables.min.css" />
			<script type="text/javascript" src="/plugins/analytic/js/dataTables.buttons.min.js"></script>
			<script type="text/javascript" src="/plugins/analytic/js/jszip.min.js"></script>
			<script type="text/javascript" src="/plugins/analytic/js/pdfmake.min.js"></script>
			<script type="text/javascript" src="/plugins/analytic/js/vfs_fonts.js"></script>
			<script type="text/javascript" src="/plugins/analytic/js/buttons.html5.min.js"></script>
			<script type="text/javascript" src="/plugins/analytic/js/buttons.print.min.js"></script>

			<link rel="stylesheet" type="text/css" href="../plugins/cdr/css/bootstrap-switch.css" />
			<script type="text/javascript" src="../plugins/cdr/js/bootstrap-switch.js"></script>

			<br/><br/>

			<?php if (isset($cdrListing) && is_array($cdrListing)) { ?>

					<table id="cdrDataTable" >
						<thead>
						<tr>
							<th>Time Connected</th>
		                    <th>Direction</th>
		                    <th>From</th>
		                    <th>To</th>
		                    <th>Ring Duration</th>
		                    <th>Duration</th>
						</tr>
						</thead>
						<tbody>
						<?php if (isset($cdrListing) && is_array($cdrListing)) foreach($cdrListing as $cdr) { ?>
							<tr>
		                        <td><?= $cdr["ltime"]; ?></td>
		                        <!-- var_dump( $this->UtcToCurrent('2016-01-29 18:43:16', 'M d y g:i:s A')); -->
		                        <td>
		                            <?php
		                                if($cdr["direction"] == "I")
		                                {
		                                    echo "<img src='/plugins/cdr/images/door_in.png' alt='Incoming' />";
		                                }
		                                elseif($cdr["direction"] == "O")
		                                {
		                                    echo "<img src='/plugins/cdr/images/door_out.png' alt='Outgoing' />";
		                                }
		                                else
		                                {
		                                    echo $cdr["direction"];
		                                }
		                            ?>
		                        </td>

		                        <td>
		                            <?php
		                                echo formatSip($cdr["cid_from"]);
		                            ?>
		                        </td>

		                        <td>
		                            <?php
		                                echo formatSip($cdr["cid_to"]);
		                            ?>
		                        </td>

		                        <td>
		                            <?= (!empty($cdr["ringduration"]) ? gmdate('H:i:s', $cdr["ringduration"]) : '0'); ?>
		                        </td>

		                        <td>
		                            <?php
		                                echo  $cdr["durationhhmmss"];
		                            ?>
		                        </td>

		                    </tr>
						<?php } ?>
						</tbody>
					</table>
			<?php }
		}
		?>


<script type="text/javascript">
	$(document).ready(function(){
		if ($('#cdrDataTable').length)
		{
			$('#cdrDataTable').DataTable({
				"pageLength" : 50,
				aaSorting: [[0,'desc']],
				"aLengthMenu": [[50, 75, -1], [50, 75, "All"]],
				dom: 'Bfrtip',
				buttons: [
					'csv', 'excel', 'pdf'
				]
			});	
		}
    	
	});
</script>

<?php
function formatSip($sip)
{
    $output = '';
    $exp_lvl1 = explode('@', $sip);
    $output .= str_replace('<sip:', '', @$exp_lvl1[0]);
	return $output;
}

include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>