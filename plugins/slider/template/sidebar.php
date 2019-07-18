<?php if (is_numeric($sg["whatid"])) {

$loadsliderside = false;

$sidls = $jakdb->query('SELECT id, lslogo, lslogolink, lsresponsive, lsloops, lsfloops, lsavideo, lsyvprev, lsanimatef, lswidth, lsheight, lstheme, lspause, lstransition, lstransitionout, lsdirection, autostart, imgpreload, naviprevnext, navibutton, pausehover FROM '.DB_PREFIX.'slider WHERE id = "'.smartsql($sg["whatid"]).'" AND active = 1 AND (permission = 0 OR permission = "'.smartsql(JAK_USERGROUPID).'")');
$rsls = $sidls->fetch_assoc();

// We have a slider
if ($jakdb->affected_rows == 1) {
	$loadsliderside = true;

?>
	
	<div id="slider-container">
	<div id="sliderside" style="width: <?php echo $rsls['lswidth'];?>; height: <?php echo $rsls['lsheight'];?>; margin: 0px auto;">
	        
		<?php
	        
	    	$lsl = $jakdb->query('SELECT id, slide2d, slide3d, timeshift, lsdeep, slidedirection, slidedelay, durationin, durationout, easingin, easingout, delayin, delayout FROM '.DB_PREFIX.'slider_layers WHERE lsid = "'.$rsls['id'].'" AND layer = 0 ORDER BY id ASC LIMIT 10');
	        while ($rowlsl = $lsl->fetch_assoc()) {
	        
	        // Check all the parameters
	        if (!empty($rowlsl['slide2d'])) {
	        	if (!empty($rowlsl['slide2d'])) $vars = 'transition2d:'.$rowlsl['slide2d'].';';
	        	if (!empty($rowlsl['slide3d'])) $vars .= 'transition3d:'.$rowlsl['slide3d'].';';
	        } else {
	        	if (!empty($rowlsl['easingin'])) $vars = 'easingin:'.$rowlsl['easingin'].';';
	        	if (!empty($rowlsl['easingout'])) $vars .= 'easingout:'.$rowlsl['easingout'].';';
	        }
	        if (!empty($rowlsl['lsdeep'])) $vars .= 'deeplink:'.$rowlsl['lsdeep'].';';
	        if (!empty($rowlsl['durationin'])) $vars .= 'durationin:'.$rowlsl['durationin'].';';
	        if (!empty($rowlsl['durationout'])) $vars .= 'durationout:'.$rowlsl['durationout'].';';
	        
	        if (!empty($rowlsl['delayin'])) $vars .= 'delayin:'.$rowlsl['delayin'].';';
	        if (!empty($rowlsl['delayout'])) $vars .= 'delayout:'.$rowlsl['delayout'].';';
	        if (!empty($rowlsl['slidedirection'])) $vars .= 'slidedirection:'.$rowlsl['slidedirection'].';';
	        if (!empty($rowlsl['slidedelay'])) $vars .= 'slidedelay:'.$rowlsl['slidedelay'].';';
	        
	        if ($vars) {
	        	$vars = ' data-ls="'.$vars.'"';
	        }
	        
	        echo '<div class="ls-slide"'.$vars.'>';
	        
	        // Reset All
	        $vars = '';
	        
	        $counter = 0;
	        
	        $lsp = $jakdb->query('SELECT lsposition, lsmove, lsstyle, lslink, lspath, imgdirection, durationin, durationout, easingin, easingout, delayin, delayout, parallaxin, parallaxout FROM '.DB_PREFIX.'slider_layers WHERE lsid = '.$rsls['id'].' AND layer = "'.$rowlsl['id'].'" ORDER BY id ASC LIMIT 20');
	        while ($rowlsp = $lsp->fetch_assoc()) {
	        
	        	$counter++;
	        
	        	if (!empty($rowlsp['lslink'])) {
	        	
	        		$link_open = '<a href="'.$rowlsp['lslink'].'">';
	        		$link_close =  '</a>';
	        	
	        	}
	        	
	        	$ipos = $varsi = $styleid = "";
	        	
	        	// Check the position
	        	if (!empty($rowlsp['lsposition'])) $ipos = ' style="'.$rowlsp['lsposition'].'"';
	        	
	        	// Check the movement
	        	if (!empty($rowlsp['lsmove'])) $varsi .= $rowlsp['lsmove'];
	        	if (!empty($rowlsp['imgdirection'])) $varsi .= 'slidedirection:'.$rowlsp['imgdirection'].';';
	        	if (!empty($rowlsp['durationin'])) $varsi .= 'durationin:'.$rowlsp['durationin'].';';
	        	if (!empty($rowlsp['durationout'])) $varsi .= 'durationout:'.$rowlsp['durationout'].';';
	        	if (!empty($rowlsp['easingin'])) $varsi .= 'easingin:'.$rowlsp['easingin'].';';
	        	if (!empty($rowlsp['easingout'])) $varsi .= 'easingout:'.$rowlsp['easingout'].';';
	        	if (!empty($rowlsp['delayin'])) $varsi .= 'delayin:'.$rowlsp['delayin'].';';
	        	if (!empty($rowlsp['delayout'])) $varsi .= 'delayout:'.$rowlsp['delayout'].';';
	        	if (!empty($rowlsp['parallaxin'])) $varsi .= 'parallaxin:'.$rowlsp['parallaxin'].';';
	        	if (!empty($rowlsp['parallaxout'])) $varsi .= 'parallaxout:'.$rowlsp['parallaxout'].';';
	        	
	        	if ($varsi) {
	        		$varsi = ' data-ls="'.$varsi.'"';
	      		}
	      		
	      		// Check if there is a style id assocciated
	      		if (!empty($rowlsp['lsstyle'])) $styleid = ' id="'.$rowlsp['lsstyle'].'"';
	      		
	      		if (!empty($rowlsp['lslink'])) {
	      			
	      				$link_open = '<a class="ls-l"'.$ipos.$varsi.$styleid.' href="'.$rowlsp['lslink'].'">';
	      				$link_close =  '</a>';
	      				$ipos = $varsi = $styleid = "";
	      			}
	        	
	          
	          if (@getimagesize(APP_PATH.$rowlsp['lspath'])) {
	          
	          	if ($counter == 1) {
	          
	     			$lsdisp = '<img class="ls-bg"'.$ipos.$varsi.$styleid.' src="'.$rowlsp['lspath'].'" alt="img" />';
	     		
	     		} else {
	     		
	     			$lsdisp = '<img class="ls-s"'.$ipos.$varsi.$styleid.' src="'.$rowlsp['lspath'].'" alt="img" />';
	     		
	     		}  
	            
	          } else {
	          	$input = $rowlsp['lspath'];
	          	$lsdisp = '<div class="ls-s"'.$ipos.$varsi.$styleid.'>'.$input.'</div>';
	          }
	        	
	        	if (!empty($rowlsp['lstitle'])) {
	        			
	        			$title_html .= '<div class="caption-bottom">'.$rowlsp['lstitle'].'</div>';
	        	
	        	}
	        	
	        	echo $link_open.$lsdisp.$link_close.$title_html;
	        	
	        	
	        	// Reset All
	        	$slidedirection = '';
	        	$link_open = '';
	        	$link_close = '';
	        	$title_html = '';
	        	$lsdisp = '';
	        
	        }
	     
	     echo '</div>';   
	        
	     } ?>
	       
	</div>
	</div>
	<div class="clearfix"></div>
<?php } } ?>