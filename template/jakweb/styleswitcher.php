<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!JAK_ASACCESS || !$jkv["styleswitcher_tpl"]) die($tl["error"]["nda"]);

// Get the sidebar templates
$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.DB_PREFIX.'pluginhooks WHERE hook_name = "tpl_footer_widgets" AND active = 1 ORDER BY exorder ASC');
while ($row = $result->fetch_assoc()) {
	$plhooks[] = $row;
}
// Get all plugins out the databse
$JAK_HOOKS = $plhooks;

// Reset the database settings so we have it unique
$result = $jakdb->query('SELECT varname, value FROM '.DB_PREFIX.'setting WHERE product = "tpl_jakweb"');
while ($row = $result->fetch_assoc()) {
    // collect each record into a define
    
    // Now check if sting contains html and do something about it!
    if (strlen($row['value']) != strlen(filter_var($row['value'], FILTER_SANITIZE_STRING))) {
    	$defvar  = htmlspecialchars_decode(htmlspecialchars($row['value']));
    } else {
    	$defvar = $row["value"];
    }
    	
	$jktpl[$row['varname']] = $defvar;
}

?>

<div id="jak_stylechanger" class="hidden-xs">

	<div id="jak_stylecontent">
	
		<!-- Nav tabs -->
		  <ul class="nav nav-tabs" id="sctabs">
		    <li role="stylechanger" class="active"><a href="#scnavbar" aria-controls="home" role="tab" data-toggle="tab">Navbar</a></li>
		    <li role="stylechanger"><a href="#scgeneral" aria-controls="profile" role="tab" data-toggle="tab">General</a></li>
		    <li role="stylechanger"><a href="#scmain" aria-controls="messages" role="tab" data-toggle="tab">Main Style</a></li>
		    <li role="stylechanger"><a href="#scsection" aria-controls="settings" role="tab" data-toggle="tab">Section</a></li>
		    <li role="stylechanger"><a href="#scfooter" aria-controls="settings" role="tab" data-toggle="tab">Footer</a></li>
		  </ul>
		  
		<form class="jak-style" method="post" action="<?php echo BASE_URL;?>template/jakweb/stylesave.php">
		  
		<!-- Tab panes -->
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane active" id="scnavbar">
		    	
		    	<h4>Navbar Style</h4>
		    		<select name="navbarstyle" id="navbarstyle" class="form-control">
		    			<option value="1"<?php if ($jktpl["navbarstyle_jakweb_tpl"] == '1'){ echo ' selected'; } ?>>float</option>
		    			<option value="0"<?php if ($jktpl["navbarstyle_jakweb_tpl"] == '0'){ echo ' selected'; } ?>>fix</option>
		    		</select>
		    	<div class="row">
		    		<div class="col-md-6">
				    	<h4>Background Color</h4>
				    	<input type="text" name="nav_color" class="form-control colorn" value="<?php echo $jktpl["navbarcolor_jakweb_tpl"];?>" />
				    	<h4>Link Color</h4>
				    	<input type="text" name="nav_link_color" class="form-control colornt" value="<?php echo $jktpl["navbarlinkcolor_jakweb_tpl"];?>" />
				    </div>
				    <div class="col-md-6">
				    	<h4>Link Background Color</h4>
				    	<input type="text" name="nav_linkbg_color" class="form-control colorntb" value="<?php echo $jktpl["navbarcolorlinkbg_jakweb_tpl"];?>" />
				    	<h4>SubMenu Background Color</h4>
				    	<input type="text" name="nav_links_color" class="form-control colornts" value="<?php echo $jktpl["navbarcolorsubmenu_jakweb_tpl"];?>" />
				    </div>
				</div>
		    	<h4>Logo</h4>
		    	<div class="input-group">
		    		<input type="text" name="logo" id="sclogo" class="form-control" value="<?php echo $jktpl["logo_jakweb_tpl"];?>" />
		    		<span class="input-group-btn">
		    		  <a class="btn btn-info ifManager" type="button" href="../../js/editor/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=&field_id=sclogo"><i class="fa fa-photo"></i></a>
		    		</span>
		    	</div><!-- /input-group -->
		    
		    </div>
		    <div role="tabpanel" class="tab-pane" id="scgeneral">
		    	<div class="row">
		    		<div class="col-md-6">
				    	<h4>Style</h4>
				    		<select name="tplstyle" id="tplstyle" class="form-control">
				    		<option value=""<?php if ($jktpl["style_jakweb_tpl"] == ''){ echo ' selected'; } ?>>wide</option>
				    		<option value="boxed"<?php if ($jktpl["style_jakweb_tpl"] == 'boxed'){ echo ' selected'; } ?>>boxed</option>
				    		</select>
				    	<h4>Color</h4>
				    		<select name="tplcolor" id="tplcolor" class="form-control">
				    		<option value=""<?php if ($jktpl["color_jakweb_tpl"] == ''){ echo ' selected'; } ?>>light</option>
				    		<option value="dark"<?php if ($jktpl["color_jakweb_tpl"] == 'dark'){ echo ' selected'; } ?>>dark</option>
				    		</select>
				    	<h4>Sidebar</h4>
				    		<select name="tplsidebar" class="form-control">
				    		<option value="left"<?php if ($jktpl["sidebar_location_tpl"] == 'left'){ echo ' selected'; } ?>>left</option>
				    		<option value="right"<?php if ($jktpl["sidebar_location_tpl"] == 'right'){ echo ' selected'; } ?>>right</option>
				    		</select>
				    		
				    	<h4>Headings - Google Font</h4>
				    		<select name="gFont" id="gFont" class="form-control">
				    			<optgroup label="Recomended Fonts">
				    				<option value='Ubuntu'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Ubuntu'){ echo ' selected="selected"'; } ?>>Ubuntu</option>
				    				<option value='Walter+Turncoat'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Walter+Turncoat'){ echo ' selected="selected"'; } ?>>Walter Turncoat</option>
				    				<option value='Lato'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Lato'){ echo ' selected="selected"'; } ?>>Lato</option>
				    				<option value='Amaranth'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Amaranth'){ echo ' selected="selected"'; } ?>>Amaranth</option>
				    				<option value='Pacifico'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Pacifico'){ echo ' selected="selected"'; } ?>>Pacifico</option>
				    				<option value='Anton'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Anton'){ echo ' selected="selected"'; } ?>>Anton</option>
				    				<option value='Luckiest+Guy'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Luckiest+Guy'){ echo ' selected="selected"'; } ?>>Luckiest Guy</option>
				    				<option value='Permanent+Marker'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Permanent+Marker'){ echo ' selected="selected"'; } ?>>Permanent Marker</option>
				    				<option value='Merriweather'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Merriweather'){ echo ' selected="selected"'; } ?>>Merriweather</option>
				    				<option value='Cuprum'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Cuprum'){ echo ' selected="selected"'; } ?>>Cuprum</option>
				    				<option value='Neuton'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Neuton'){ echo ' selected="selected"'; } ?>>Neuton</option>
				    				<option value='Lobster'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Lobster'){ echo ' selected="selected"'; } ?>>Lobster</option>
				    				<option value='NonGoogle'<?php if ($jktpl["fontg_jakweb_tpl"] == 'NonGoogle'){ echo ' selected="selected"'; } ?>>Use Same as Content Font</option>
				    			</optgroup>
				    			<optgroup label="Other Fonts">
				    				<option value='Allan'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Allan'){ echo ' selected="selected"'; } ?>>Allan</option>
				    				<option value='Allerta'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Allerta'){ echo ' selected="selected"'; } ?>>Allerta</option>
				    				<option value='Allerta+Stencil'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Allerta+Stencil'){ echo ' selected="selected"'; } ?>>Allerta Stencil</option>
				    				<option value='Anonymous+Pro'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Anonymous+Pro'){ echo ' selected="selected"'; } ?>>Anonymous Pro</option>
				    				<option value='Arimo'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Arimo'){ echo ' selected="selected"'; } ?>>Arimo</option>
				    				<option value='Arvo'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Arvo'){ echo ' selected="selected"'; } ?>>Arvo</option>
				    				<option value='Astloch'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Astloch'){ echo ' selected="selected"'; } ?>>Astloch</option>
				    				<option value='Bentham'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Bentham'){ echo ' selected="selected"'; } ?>>Bentham</option>
				    				<option value='Bevan'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Bevan'){ echo ' selected="selected"'; } ?>>Bevan</option>
				    				<option value='Buda:light'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Buda:light'){ echo ' selected="selected"'; } ?>>Buda</option>
				    				<option value='Cabin'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Cabin'){ echo ' selected="selected"'; } ?>>Cabin</option>
				    				<option value='Cabin+Sketch'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Cabin+Sketch'){ echo ' selected="selected"'; } ?>>Cabin Sketch</option>
				    				<option value='Calligraffitti'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Calligraffitti'){ echo ' selected="selected"'; } ?>>Calligraffitti</option>
				    				<option value='Candal'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Candal'){ echo ' selected="selected"'; } ?>>Candal</option>
				    				<option value='Cantarell'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Cantarell'){ echo ' selected="selected"'; } ?>>Cantarell</option>
				    				<option value='Cardo'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Cardo'){ echo ' selected="selected"'; } ?>>Cardo</option>
				    				<option value='Cherry+Cream+Soda'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Cherry+Cream+Soda'){ echo ' selected="selected"'; } ?>>Cherry Cream Soda</option>
				    				<option value='Chewy'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Chewy'){ echo ' selected="selected"'; } ?>>Chewy</option>
				    				<option value='Coda:800'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Coda:800'){ echo ' selected="selected"'; } ?>>Coda</option>
				    				<option value='Coda+Caption:800'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Coda+Caption:800'){ echo ' selected="selected"'; } ?>>Coda Caption</option>
				    				<option value='Coming+Soon'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Coming+Soon'){ echo ' selected="selected"'; } ?>>Coming Soon</option>
				    				<option value='Copse'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Copse'){ echo ' selected="selected"'; } ?>>Copse</option>
				    				<option value='Corben'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Corben'){ echo ' selected="selected"'; } ?>>Corben</option>
				    				<option value='Cousine'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Cousine'){ echo ' selected="selected"'; } ?>>Cousine</option>
				    				<option value='Covered+By+Your+Grace'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Covered+By+Your+Grace'){ echo ' selected="selected"'; } ?>>Covered By Your Grace</option>
				    				<option value='Crafty+Girls'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Crafty+Girls'){ echo ' selected="selected"'; } ?>>Crafty Girls</option>
				    				<option value='Crimson+Text'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Crimson+Text'){ echo ' selected="selected"'; } ?>>Crimson Text</option>
				    				<option value='Crushed'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Crushed'){ echo ' selected="selected"'; } ?>>Crushed</option>
				    				<option value='Dancing+Script'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Dancing+Script'){ echo ' selected="selected"'; } ?>>Dancing Script</option>
				    				<option value='Droid+Sans'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Droid+Sans'){ echo ' selected="selected"'; } ?>>Droid Sans</option>
				    				<option value='Droid+Sans+Mono'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Droid+Sans+Mono'){ echo ' selected="selected"'; } ?>>Droid Sans Mono</option>
				    				<option value='Droid+Serif'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Droid+Serif'){ echo ' selected="selected"'; } ?>>Droid Serif</option>
				    				<option value='EB+Garamond'<?php if ($jktpl["fontg_jakweb_tpl"] == 'EB+Garamond'){ echo ' selected="selected"'; } ?>>EB Garamond</option>
				    				<option value='Expletus+Sans'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Expletus+Sans'){ echo ' selected="selected"'; } ?>>Expletus Sans</option>
				    				<option value='Fontdiner+Swanky'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Fontdiner+Swanky'){ echo ' selected="selected"'; } ?>>Fontdiner Swanky</option>
				    				<option value='Geo'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Geo'){ echo ' selected="selected"'; } ?>>Geo</option>
				    				<option value='Goudy+Bookletter+1911'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Goudy+Bookletter+1911'){ echo ' selected="selected"'; } ?>>Goudy Bookletter 1911</option>
				    				<option value='Gruppo'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Gruppo'){ echo ' selected="selected"'; } ?>>Gruppo</option>
				    				<option value='Homemade+Apple'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Homemade+Apple'){ echo ' selected="selected"'; } ?>>Homemade Apple</option>
				    				<option value='IM+Fell+DW+Pica'<?php if ($jktpl["fontg_jakweb_tpl"] == 'IM+Fell+DW+Pica'){ echo ' selected="selected"'; } ?>>IM Fell DW Pica</option>
				    				<option value='IM+Fell+French+Canon+SC'<?php if ($jktpl["fontg_jakweb_tpl"] == 'IM+Fell+French+Canon+SC'){ echo ' selected="selected"'; } ?>>IM Fell French Canon SC</option>
				    				<option value='IM+Fell+French+Canon'<?php if ($jktpl["fontg_jakweb_tpl"] == 'IM+Fell+French+Canon'){ echo ' selected="selected"'; } ?>>IM Fell French Canon</option>
				    				<option value='IM+Fell+Great+Primer+SC'<?php if ($jktpl["fontg_jakweb_tpl"] == 'IM+Fell+Great+Primer+SC'){ echo ' selected="selected"'; } ?>>IM Fell Great Primer SC</option>
				    				<option value='IM+Fell+Great+Primer'<?php if ($jktpl["fontg_jakweb_tpl"] == 'IM+Fell+Great+Primer'){ echo ' selected="selected"'; } ?>>IM Fell Great Primer</option>
				    				<option value='IM+Fell+English+SC'<?php if ($jktpl["fontg_jakweb_tpl"] == 'IM+Fell+English+SC'){ echo ' selected="selected"'; } ?>>IM Fell English SC</option>
				    				<option value='IM+Fell+English'<?php if ($jktpl["fontg_jakweb_tpl"] == 'IM+Fell+English'){ echo ' selected="selected"'; } ?>>IM Fell English</option>
				    				<option value='IM+Fell+DW+Pica+SC'<?php if ($jktpl["fontg_jakweb_tpl"] == 'IM+Fell+DW+Pica+SC'){ echo ' selected="selected"'; } ?>>IM Fell DW Pica SC</option>
				    				<option value='IM+Fell+Double+Pica+SC'<?php if ($jktpl["fontg_jakweb_tpl"] == 'IM+Fell+Double+Pica+SC'){ echo ' selected="selected"'; } ?>>IM Fell Double Pica SC</option>
				    				<option value='IM+Fell+Double+Pica'<?php if ($jktpl["fontg_jakweb_tpl"] == 'IM+Fell+Double+Pica'){ echo ' selected="selected"'; } ?>>IM Fell Double Pica</option>
				    				<option value='Inconsolata'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Inconsolata'){ echo ' selected="selected"'; } ?>>Inconsolata</option>
				    				<option value='Indie+Flower'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Indie+Flower'){ echo ' selected="selected"'; } ?>>Indie Flower</option>
				    				<option value='Irish+Grover'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Irish+Grover'){ echo ' selected="selected"'; } ?>>Irish Grover</option>
				    				<option value='Josefin+Sans'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Josefin+Sans'){ echo ' selected="selected"'; } ?>>Josefin Sans</option>
				    				<option value='Josefin+Slab'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Josefin+Slab'){ echo ' selected="selected"'; } ?>>Josefin Slab</option>
				    				<option value='Just+Another+Hand'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Just+Another+Hand'){ echo ' selected="selected"'; } ?>>Just Another Hand</option>
				    				<option value='Just+Me+Again+Down+Here'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Just+Me+Again+Down+Here'){ echo ' selected="selected"'; } ?>>Just Me Again Down Here</option>
				    				<option value='Kenia'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Kenia'){ echo ' selected="selected"'; } ?>>Kenia</option>
				    				<option value='Kranky'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Kranky'){ echo ' selected="selected"'; } ?>>Kranky</option>
				    				<option value='Kreon'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Kreon'){ echo ' selected="selected"'; } ?>>Kreon</option>
				    				<option value='Kristi'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Kristi'){ echo ' selected="selected"'; } ?>>Kristi</option>
				    				<option value='League+Script'<?php if ($jktpl["fontg_jakweb_tpl"] == 'League+Script'){ echo ' selected="selected"'; } ?>>League Script</option>
				    				<option value='Lekton'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Lekton'){ echo ' selected="selected"'; } ?>>Lekton</option>
				    				<option value='Meddon'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Meddon'){ echo ' selected="selected"'; } ?>>Meddon</option>
				    				<option value='MedievalSharp'<?php if ($jktpl["fontg_jakweb_tpl"] == 'MedievalSharp'){ echo ' selected="selected"'; } ?>>MedievalSharp</option>
				    				<option value='Molengo'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Molengo'){ echo ' selected="selected"'; } ?>>Molengo</option>
				    				<option value='Mountains+of+Christmas'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Mountains+of+Christmas'){ echo ' selected="selected"'; } ?>>Mountains of Christmas</option>
				    				<option value='Neucha'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Neucha'){ echo ' selected="selected"'; } ?>>Neucha</option>
				    				<option value='Nobile'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Nobile'){ echo ' selected="selected"'; } ?>>Nobile</option>
				    				<option value='Nova+Script'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Nova+Script'){ echo ' selected="selected"'; } ?>>Nova Script</option>
				    				<option value='Nova+Round'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Nova+Round'){ echo ' selected="selected"'; } ?>>Nova Round</option>
				    				<option value='Nova+Oval'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Nova+Oval'){ echo ' selected="selected"'; } ?>>Nova Oval</option>
				    				<option value='Nova+Mono'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Nova+Mono'){ echo ' selected="selected"'; } ?>>Nova Mono</option>
				    				<option value='Nova+Cut'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Nova+Cut'){ echo ' selected="selected"'; } ?>>Nova Cut</option>
				    				<option value='Nova+Slim'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Nova+Slim'){ echo ' selected="selected"'; } ?>>Nova Slim</option>
				    				<option value='Nova+Flat'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Nova+Flat'){ echo ' selected="selected"'; } ?>>Nova Flat</option>
				    				<option value='OFL+Sorts+Mill+Goudy+TT'<?php if ($jktpl["fontg_jakweb_tpl"] == 'OFL+Sorts+Mill+Goudy+TT'){ echo ' selected="selected"'; } ?>>OFL Sorts Mill Goudy TT</option>
				    				<option value='Old+Standard+TT'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Old+Standard+TT'){ echo ' selected="selected"'; } ?>>Old Standard TT</option>
				    				<option value='Orbitron'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Orbitron'){ echo ' selected="selected"'; } ?>>Orbitron</option>
				    				<option value='Oswald'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Oswald'){ echo ' selected="selected"'; } ?>>Oswald</option>
				    				<option value='Philosopher'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Philosopher'){ echo ' selected="selected"'; } ?>>Philosopher</option>
				    				<option value='PT+Sans'<?php if ($jktpl["fontg_jakweb_tpl"] == 'PT+Sans'){ echo ' selected="selected"'; } ?>>PT Sans</option>
				    				<option value='PT+Sans+Narrow'<?php if ($jktpl["fontg_jakweb_tpl"] == 'PT+Sans+Narrow'){ echo ' selected="selected"'; } ?>>PT Sans Narrow</option>
				    				<option value='PT+Sans+Caption'<?php if ($jktpl["fontg_jakweb_tpl"] == 'PT+Sans+Caption'){ echo ' selected="selected"'; } ?>>PT Sans Caption</option>
				    				<option value='PT+Serif'<?php if ($jktpl["fontg_jakweb_tpl"] == 'PT+Serif'){ echo ' selected="selected"'; } ?>>PT Serif</option>
				    				<option value='PT+Serif+Caption'<?php if ($jktpl["fontg_jakweb_tpl"] == 'PT+Serif+Caption'){ echo ' selected="selected"'; } ?>>PT Serif Caption</option>
				    				<option value='Puritan'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Puritan'){ echo ' selected="selected"'; } ?>>Puritan</option>
				    				<option value='Quattrocento'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Quattrocento'){ echo ' selected="selected"'; } ?>>Quattrocento</option>
				    				<option value='Raleway:100'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Raleway:100'){ echo ' selected="selected"'; } ?>>Raleway</option>
				    				<option value='Reenie+Beanie'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Reenie+Beanie'){ echo ' selected="selected"'; } ?>>Reenie Beanie</option>
				    				<option value='Rock+Salt'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Rock+Salt'){ echo ' selected="selected"'; } ?>>Rock Salt</option>
				    				<option value='Schoolbell'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Schoolbell'){ echo ' selected="selected"'; } ?>>Schoolbell</option>
				    				<option value='Slackey'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Slackey'){ echo ' selected="selected"'; } ?>>Slackey</option>
				    				<option value='Sniglet:800'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Sniglet:800'){ echo ' selected="selected"'; } ?>>Sniglet</option>
				    				<option value='Sunshiney'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Sunshiney'){ echo ' selected="selected"'; } ?>>Sunshiney</option>
				    				<option value='Syncopate'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Syncopate'){ echo ' selected="selected"'; } ?>>Syncopate</option>
				    				<option value='Tangerine'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Tangerine'){ echo ' selected="selected"'; } ?>>Tangerine</option>
				    				<option value='Tinos'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Tinos'){ echo ' selected="selected"'; } ?>>Tinos</option>
				    				<option value='UnifrakturCook'<?php if ($jktpl["fontg_jakweb_tpl"] == 'UnifrakturCook'){ echo ' selected="selected"'; } ?>>UnifrakturCook</option>
				    				<option value='UnifrakturMaguntia'<?php if ($jktpl["fontg_jakweb_tpl"] == 'UnifrakturMaguntia'){ echo ' selected="selected"'; } ?>>UnifrakturMaguntia</option>
				    				<option value='Unkempt'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Unkempt'){ echo ' selected="selected"'; } ?>>Unkempt</option>
				    				<option value='VT323'<?php if ($jktpl["fontg_jakweb_tpl"] == 'VT323'){ echo ' selected="selected"'; } ?>>VT323</option>
				    				<option value='Vibur'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Vibur'){ echo ' selected="selected"'; } ?>>Vibur</option>
				    				<option value='Vollkorn'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Vollkorn'){ echo ' selected="selected"'; } ?>>Vollkorn</option>
				    				<option value='Yanone+Kaffeesatz'<?php if ($jktpl["fontg_jakweb_tpl"] == 'Yanone+Kaffeesatz'){ echo ' selected="selected"'; } ?>>Yanone Kaffeesatz</option>
				    			</optgroup>
				    		</select>
				    		<h4>Content Font</h4>
				    		<select name="cFont" id="cFont" class="form-control" style="margin-bottom:7px;">
				    			<option value='Arial, Helvetica, sans-serif'<?php if ($jktpl["font_jakweb_tpl"] == 'Arial, Helvetica, sans-serif'){ echo ' selected="selected"'; } ?>>Arial</option>
				    			<option value='"Trebuchet MS", Helvetica, Garuda, sans-serif'<?php if ($jktpl["font_jakweb_tpl"] == '"Trebuchet MS", Helvetica, Garuda, sans-serif'){ echo ' selected="selected"'; } ?>>Trebuchet MS</option>
				    			<option value='"Comic Sans MS", Monaco, "TSCu_Comic", cursive'<?php if ($jktpl["font_jakweb_tpl"] == '"Comic Sans MS", Monaco, "TSCu_Comic", cursive'){ echo ' selected="selected"'; } ?>>Comic Sans MS</option>
				    			<option value='Georgia, Times, "Century Schoolbook L", serif'<?php if ($jktpl["font_jakweb_tpl"] == 'Georgia, Times, "Century Schoolbook L", serif'){ echo ' selected="selected"'; } ?>>Georgia</option>
				    			<option value='Verdana, Geneva, "DejaVu Sans", sans-serif'<?php if ($jktpl["font_jakweb_tpl"] == 'Verdana, Geneva, "DejaVu Sans", sans-serif'){ echo ' selected="selected"'; } ?>>Verdana</option>
				    			<option value='Tahoma, Geneva, Kalimati, sans-serif'<?php if ($jktpl["font_jakweb_tpl"] == 'Tahoma, Geneva, Kalimati, sans-serif'){ echo ' selected="selected"'; } ?>>Tahoma</option>
				    			<option value='"Lucida Sans Unicode", "Lucida Grande", Garuda, sans-serif'<?php if ($jktpl["font_jakweb_tpl"] == '"Lucida Sans Unicode", "Lucida Grande", Garuda, sans-serif'){ echo ' selected="selected"'; } ?>>Lucida Sans</option>
				    			<option value='Calibri, "AppleGothic", "MgOpen Modata", sans-serif'<?php if ($jktpl["font_jakweb_tpl"] == 'Calibri, "AppleGothic", "MgOpen Modata", sans-serif'){ echo ' selected="selected"'; } ?>>Calibri</option>
				    			<option value='"Times New Roman", Times, "Nimbus Roman No9 L", serif'<?php if ($jktpl["font_jakweb_tpl"] == '"Times New Roman", Times, "Nimbus Roman No9 L", serif'){ echo ' selected="selected"'; } ?>>Times New Roman</option>
				    			<option value='"Courier New", Courier, "Nimbus Mono L", monospace'<?php if ($jktpl["font_jakweb_tpl"] == '"Courier New", Courier, "Nimbus Mono L", monospace'){ echo ' selected="selected"'; } ?>>Courier New</option>
				    		</select>
				    		
				    		<div class="bgboxed<?php if (!$jktpl["style_jakweb_tpl"]) echo ' hidden';?>">
				    			<h4>Background Color</h4>
				    			<input type="text" name="tplboxbgcolor" class="form-control tplboxbgcolor" value="<?php echo $jktpl["boxbg_jakweb_tpl"];?>" />
				    		</div>
				    </div>
				    <div class="col-md-6">
				    	<div class="bgboxed<?php if (!$jktpl["style_jakweb_tpl"]) echo ' hidden';?>">
				    		
				    		<h4>Background Patterns</h4>
				    		<div class="row">
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="always_grey"><img src="/template/jakweb/img/patterns/always_grey.png" width="35" alt="always_grey" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="black_denim"><img src="/template/jakweb/img/patterns/black_denim.png" width="35" alt="45degree" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="crossed_stripes"><img src="/template/jakweb/img/patterns/crossed_stripes.png" width="35" alt="crossed_stripes" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="dark_stripes"><img src="/template/jakweb/img/patterns/dark_stripes.png" width="35" alt="dark_stripes" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="darth_stripe"><img src="/template/jakweb/img/patterns/darth_stripe.png" width="35" alt="darth_stripe" /></a>
				    			</div>
				    		</div>
				    		<hr>
				    		<div class="row">
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="black_linen"><img src="/template/jakweb/img/patterns/black_linen.png" width="35" alt="black_linen" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="black_paper"><img src="/template/jakweb/img/patterns/black_paper.png" width="35" alt="black_paper" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="blackmamba"><img src="/template/jakweb/img/patterns/blackmamba.png" width="35" alt="blackmamba" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="carbon_fibre"><img src="/template/jakweb/img/patterns/carbon_fibre.png" width="35" alt="carbon_fibre" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="concrete_wall_dark"><img src="/template/jakweb/img/patterns/concrete_wall_dark.png" width="35" alt="concrete_wall_dark" /></a>
				    			</div>
				    		</div>
				    		<hr>
				    		<div class="row">
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="gray_sand"><img src="/template/jakweb/img/patterns/gray_sand.png" width="35" alt="gray_sand" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="wood"><img src="/template/jakweb/img/patterns/wood.png" width="35" alt="wood" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="noise"><img src="/template/jakweb/img/patterns/noise.png" width="35" alt="noise" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="padded"><img src="/template/jakweb/img/patterns/padded.png" width="35" alt="padded" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="random"><img src="/template/jakweb/img/patterns/random.png" width="35" alt="random" /></a>
				    			</div>
				    		</div>
				    		<hr>
				    		<div class="row">
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="pattern"><img src="/template/jakweb/img/patterns/pattern.png" width="35" alt="pattern" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="45degree"><img src="/template/jakweb/img/patterns/45degree.png" width="35" alt="45degree" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="60degree"><img src="/template/jakweb/img/patterns/60degree.png" width="35" alt="60degree" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="fabric"><img src="/template/jakweb/img/patterns/fabric.png" width="35" alt="fabric" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="beige_paper"><img src="/template/jakweb/img/patterns/beige_paper.png" width="35" alt="beige_paper" /></a>
				    			</div>
				    		</div>
				    		
				    		<hr>
				    		
				    		<div class="row">
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="bright_squares"><img src="/template/jakweb/img/patterns/bright_squares.png" width="35" alt="bright_squares" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="brushed_alu"><img src="/template/jakweb/img/patterns/brushed_alu.png" width="35" alt="brushed_alu" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="concrete_wall"><img src="/template/jakweb/img/patterns/concrete_wall.png" width="35" alt="concrete_wall" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="exclusive_paper"><img src="/template/jakweb/img/patterns/exclusive_paper.png" width="35" alt="exclusive_paper" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="vichy"><img src="/template/jakweb/img/patterns/vichy.png" width="35" alt="vichy" /></a>
				    			</div>
				    		</div>
				    		
				    		<hr>
				    		
				    		<div class="row">
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="noisy"><img src="/template/jakweb/img/patterns/noisy.png" width="35" alt="noisy" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="grunge_wall"><img src="/template/jakweb/img/patterns/grunge_wall.png" width="35" alt="grunge_wall" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="handmadepaper"><img src="/template/jakweb/img/patterns/handmadepaper.png" width="35" alt="handmadepaper" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="leather_white"><img src="/template/jakweb/img/patterns/leather_white.png" width="35" alt="leather_white" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="light_honeycomb"><img src="/template/jakweb/img/patterns/light_honeycomb.png" width="35" alt="light_honeycomb" /></a>
				    			</div>
				    		</div>
				    		
				    		<hr>
				    		
				    		<div class="row">
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="old_mathematics"><img src="/template/jakweb/img/patterns/old_mathematics.png" width="35" alt="old_mathematics" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="soft_wallpaper"><img src="/template/jakweb/img/patterns/soft_wallpaper.png" width="35" alt="soft_wallpaper" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="subtle_freckles"><img src="/template/jakweb/img/patterns/subtle_freckles.png" height="40" alt="subtle_freckles" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="rockywall"><img src="/template/jakweb/img/patterns/rockywall.png" width="35" alt="rockywall" /></a>
				    			</div>
				    			<div class="col-xs-2">
				    				<a href="javascript:void(0)" class="patternboxed" data-pattern="smooth_wall"><img src="/template/jakweb/img/patterns/smooth_wall.png" width="35" alt="smooth_wall" /></a>
				    			</div>
				    		</div>
				    		<input type="hidden" name="patternboxed" id="patternboxed" value="<?php echo $jktpl["boxpattern_jakweb_tpl"];?>" />
				    		
				    	</div>
		    			
				    	</div>
				   	</div>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="scmain">
		    	
		    	<div class="row">
		    		<div class="col-md-6">
				    	<h4>Colors</h4>
				    	<div class="row">
				    		<div class="col-xs-1">
				    			<a href="javascript:void(0)" class="colors" data-color="orange"><img src="/template/jakweb/img/stylechanger/orange.png" class="img-circle" alt="orange" /></a>
				    		</div>
				    		<div class="col-xs-1">
				    			<a href="javascript:void(0)" class="colors" data-color="green"><img src="/template/jakweb/img/stylechanger/green.png" class="img-circle" alt="green" /></a>
				    		</div>
				    		<div class="col-xs-1">
				    			<a href="javascript:void(0)" class="colors" data-color="red"><img src="/template/jakweb/img/stylechanger/red.png" class="img-circle" alt="red" /></a>
				    		</div>
				    		<div class="col-xs-1">
				    			<a href="javascript:void(0)" class="colors" data-color="blue"><img src="/template/jakweb/img/stylechanger/blue.png" class="img-circle" alt="blue" /></a>
				    		</div>
				    		<div class="col-xs-1">
				    			<a href="javascript:void(0)" class="colors" data-color="yellow"><img src="/template/jakweb/img/stylechanger/yellow.png" class="img-circle" alt="yellow" /></a>
				    		</div>
				    		<div class="col-xs-1">
				    			<a href="javascript:void(0)" class="colors" data-color="grey"><img src="/template/jakweb/img/stylechanger/grey.png" class="img-circle" alt="grey" /></a>
				    		</div>
				    		<input type="hidden" name="theme" id="themes" value="<?php echo $jkv["theme_jakweb_tpl"];?>" />
				    	</div>
				    </div>
				    <div class="col-md-6">
				    	<h4>Background Color</h4>
				    	<input type="text" name="maingbg_color" class="form-control colorbg" value="<?php echo $jktpl["mainbg_jakweb_tpl"];?>" />
				   	</div>
				</div>
		    	<hr>
		    	<h4>Background Patterns</h4>
		    	<div class="row">
		    		<div class="col-md-6">
				    	<div class="row">
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="pattern"><img src="/template/jakweb/img/patterns/pattern.png" width="35" alt="pattern" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="45degree"><img src="/template/jakweb/img/patterns/45degree.png" width="35" alt="45degree" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="60degree"><img src="/template/jakweb/img/patterns/60degree.png" width="35" alt="60degree" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="fabric"><img src="/template/jakweb/img/patterns/fabric.png" width="35" alt="fabric" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="beige_paper"><img src="/template/jakweb/img/patterns/beige_paper.png" width="35" alt="beige_paper" /></a>
				    		</div>
				    	</div>
				    	
				    	<hr>
				    	
				    	<div class="row">
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="bright_squares"><img src="/template/jakweb/img/patterns/bright_squares.png" width="35" alt="bright_squares" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="brushed_alu"><img src="/template/jakweb/img/patterns/brushed_alu.png" width="35" alt="brushed_alu" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="concrete_wall"><img src="/template/jakweb/img/patterns/concrete_wall.png" width="35" alt="concrete_wall" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="exclusive_paper"><img src="/template/jakweb/img/patterns/exclusive_paper.png" width="35" alt="exclusive_paper" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="vichy"><img src="/template/jakweb/img/patterns/vichy.png" width="35" alt="vichy" /></a>
				    		</div>
				    	</div>
				    	
				    	<hr>
				    	
				    	<div class="row">
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="noisy"><img src="/template/jakweb/img/patterns/noisy.png" width="35" alt="noisy" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="grunge_wall"><img src="/template/jakweb/img/patterns/grunge_wall.png" width="35" alt="grunge_wall" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="handmadepaper"><img src="/template/jakweb/img/patterns/handmadepaper.png" width="35" alt="handmadepaper" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="leather_white"><img src="/template/jakweb/img/patterns/leather_white.png" width="35" alt="leather_white" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="light_honeycomb"><img src="/template/jakweb/img/patterns/light_honeycomb.png" width="35" alt="light_honeycomb" /></a>
				    		</div>
				    	</div>
				    	
				    	<hr>
				    	
				    	<div class="row">
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="old_mathematics"><img src="/template/jakweb/img/patterns/old_mathematics.png" width="35" alt="old_mathematics" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="soft_wallpaper"><img src="/template/jakweb/img/patterns/soft_wallpaper.png" width="35" alt="soft_wallpaper" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="subtle_freckles"><img src="/template/jakweb/img/patterns/subtle_freckles.png" height="40" alt="subtle_freckles" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="rockywall"><img src="/template/jakweb/img/patterns/rockywall.png" width="35" alt="rockywall" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="smooth_wall"><img src="/template/jakweb/img/patterns/smooth_wall.png" width="35" alt="smooth_wall" /></a>
				    		</div>
				    	</div>
				    </div>
				    <div class="col-md-6">
				    	<div class="row">
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="always_grey"><img src="/template/jakweb/img/patterns/always_grey.png" width="35" alt="always_grey" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="black_denim"><img src="/template/jakweb/img/patterns/black_denim.png" width="35" alt="45degree" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="crossed_stripes"><img src="/template/jakweb/img/patterns/crossed_stripes.png" width="35" alt="crossed_stripes" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="dark_stripes"><img src="/template/jakweb/img/patterns/dark_stripes.png" width="35" alt="dark_stripes" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="darth_stripe"><img src="/template/jakweb/img/patterns/darth_stripe.png" width="35" alt="darth_stripe" /></a>
				    		</div>
				    	</div>
				    	<hr>
				    	<div class="row">
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="black_linen"><img src="/template/jakweb/img/patterns/black_linen.png" width="35" alt="black_linen" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="black_paper"><img src="/template/jakweb/img/patterns/black_paper.png" width="35" alt="black_paper" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="blackmamba"><img src="/template/jakweb/img/patterns/blackmamba.png" width="35" alt="blackmamba" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="carbon_fibre"><img src="/template/jakweb/img/patterns/carbon_fibre.png" width="35" alt="carbon_fibre" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="concrete_wall_dark"><img src="/template/jakweb/img/patterns/concrete_wall_dark.png" width="35" alt="concrete_wall_dark" /></a>
				    		</div>
				    	</div>
				    	<hr>
				    	<div class="row">
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="gray_sand"><img src="/template/jakweb/img/patterns/gray_sand.png" width="35" alt="gray_sand" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="wood"><img src="/template/jakweb/img/patterns/wood.png" width="35" alt="wood" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="noise"><img src="/template/jakweb/img/patterns/noise.png" width="35" alt="noise" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="padded"><img src="/template/jakweb/img/patterns/padded.png" width="35" alt="padded" /></a>
				    		</div>
				    		<div class="col-xs-2">
				    			<a href="javascript:void(0)" class="pattern" data-pattern="random"><img src="/template/jakweb/img/patterns/random.png" width="35" alt="random" /></a>
				    		</div>
				    	</div>
				    </div>
				</div>
		    	<input type="hidden" name="pattern" id="pattern" value="<?php echo $jktpl["pattern_jakweb_tpl"];?>" />
		    	
		    </div>
		    <div role="tabpanel" class="tab-pane" id="scsection">
		    	<div class="row">
		    		<div class="col-md-4">
				    	<h4>Background Color</h4>
				    	<input type="text" name="section_color" class="form-control colorc" value="<?php echo $jktpl["sectionbg_jakweb_tpl"];?>" />
				    	<h4>Section h3 Color</h4>
				    	<input type="text" name="section_title_color" class="form-control colorct" value="<?php echo $jktpl["sectiontc_jakweb_tpl"];?>" />
				    	<h4>Remove Section</h4>
				    	<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="jak_sectionhide"><?php if ($jktpl["sectionshow_jakweb_tpl"]) { echo ' Hide'; } else { echo 'Show';}?></a>
				    	<input type="hidden" name="hide_section" id="hide-section" value="<?php echo $jktpl["sectionshow_jakweb_tpl"];?>" />
				    </div>
				   	<div class="col-md-8">
						<h4>Content Block 1</h4>
			    		<select name="cb1" id="cb1" class="form-control">
			    		<option value="0">Please Choose</option>
			    		<option value="ct"<?php if (!is_numeric($jktpl["bcontent1_jakweb_tpl"])) echo ' selected="selected"';?>>Custom Text</option>
			    		<?php if (isset($JAK_HOOKS) && is_array($JAK_HOOKS)) foreach($JAK_HOOKS as $v) { ?>
			    		<option value="<?php echo $v["id"];?>"<?php if (is_numeric($jktpl["bcontent1_jakweb_tpl"]) && $jktpl["bcontent1_jakweb_tpl"] == $v["id"]) echo ' selected="selected"';?>><?php echo $v["name"];?></option>
			    		<?php } ?>
			    		</select>
			    		<div class="form-group">
			    				<!-- Only show if we choose ct -->
			    				<textarea name="content1" id="jakEditor1" class="form-control" rows="3"<?php if (is_numeric($jktpl["bcontent1_jakweb_tpl"])) echo ' style="display: none;"';?>><?php echo $jktpl["bcontent1_jakweb_tpl"];?></textarea>
			    		</div>
	
			    		<h4>Content Block 2</h4>
			    		<select name="cb2" id="cb2" class="form-control">
			    		<option value="0">Please Choose</option>
			    		<option value="ct"<?php if (!is_numeric($jktpl["bcontent2_jakweb_tpl"])) echo ' selected="selected"';?>>Custom Text</option>
			    		<?php if (isset($JAK_HOOKS) && is_array($JAK_HOOKS)) foreach($JAK_HOOKS as $v) { ?>
			    		<option value="<?php echo $v["id"];?>"<?php if (is_numeric($jktpl["bcontent2_jakweb_tpl"]) && $jktpl["bcontent2_jakweb_tpl"] == $v["id"]) echo ' selected="selected"';?>><?php echo $v["name"];?></option>
			    		<?php } ?>
			    		</select>
			    		<div class="form-group">
			    				<!-- Only show if we choose ct -->
			    				<textarea name="content2" id="jakEditor2" class="form-control" rows="3"<?php if (is_numeric($jktpl["bcontent2_jakweb_tpl"])) echo ' style="display: none;"';?>><?php echo $jktpl["bcontent2_jakweb_tpl"];?></textarea>
			    		</div>
	
			    		<h4>Content Block 3</h4>
			    		<select name="cb3" id="cb3" class="form-control">
			    		<option value="0">Please Choose</option>
			    		<option value="ct"<?php if (!is_numeric($jktpl["bcontent3_jakweb_tpl"])) echo ' selected="selected"';?>>Custom Text</option>
			    		<?php if (isset($JAK_HOOKS) && is_array($JAK_HOOKS)) foreach($JAK_HOOKS as $v) { ?>
			    		<option value="<?php echo $v["id"];?>"<?php if (is_numeric($jktpl["bcontent3_jakweb_tpl"]) && $jktpl["bcontent3_jakweb_tpl"] == $v["id"]) echo ' selected="selected"';?>><?php echo $v["name"];?></option>
			    		<?php } ?>
			    		</select>
			    		<div class="form-group">
			    				<!-- Only show if we choose ct -->
			    				<textarea name="content3" id="jakEditor3" class="form-control" rows="3"<?php if (is_numeric($jktpl["bcontent3_jakweb_tpl"])) echo ' style="display: none;"';?>><?php echo $jktpl["bcontent3_jakweb_tpl"];?></textarea>
			    		</div>
				    </div>
				</div>
		    	
		    </div>
		    <div role="tabpanel" class="tab-pane" id="scfooter">
				
				<div class="row">
					<div class="col-md-6">
				    	<h4>Footer Style</h4>
				    		<select name="footer" id="footerstyle" class="form-control">
				    			<option value="1"<?php if ($jktpl["footer_jakweb_tpl"] == '1'){ echo ' selected'; } ?>>big</option>
				    			<option value="0"<?php if ($jktpl["footer_jakweb_tpl"] == '0'){ echo ' selected'; } ?>>small</option>
				    		</select>
				    		<h4>Background Color</h4>
				    		<input type="text" name="footer_color" class="form-control colorf" value="<?php echo $jktpl["footerc_jakweb_tpl"];?>" />
				    </div>
				    <div class="col-md-6">
				    	<div class="footer-block-big">
					    	<h4>Title h3 Color</h4>
					    	<input type="text" name="footer_title_color" class="form-control colorft" value="<?php echo $jktpl["footerct_jakweb_tpl"];?>" />
					    	<h4>Text Color</h4>
					    	<input type="text" name="footer_text_color" class="form-control colorfte" value="<?php echo $jktpl["footercte_jakweb_tpl"];?>" />
				    	</div>
				    </div>
				</div>
		    	<div class="footer-block-big">
		    		<h4>Footer Block 1</h4>
		    		<div class="form-group">
		    			<!-- Only show if we choose ct -->
		    			<textarea name="footercontent3" id="fcont3" class="form-control" rows="2"><?php echo $jktpl["fcont3_jakweb_tpl"];?></textarea>
		    		</div>
		    		<h4>Footer Block 2</h4>
		    		<div class="form-group">
		    			<!-- Only show if we choose ct -->
		    			<textarea name="footercontent" id="fcont" class="form-control" rows="3"><?php echo $jktpl["fcont_jakweb_tpl"];?></textarea>
		    		</div>
		    		<h4>Footer Block 3</h4>
		    		<div class="form-group">
		    			<!-- Only show if we choose ct -->
		    			<textarea name="footercontent2" id="fcont2" class="form-control" rows="3"><?php echo $jktpl["fcont2_jakweb_tpl"];?></textarea>
		    		</div>
		    	</div>
		 	 </div>
		</div>
		<hr>
		<div class="jak-stylety"></div>
		<button type="submit" name="save" class="btn btn-primary btn-block jak-submit"><?php echo $tl["contact"]["s"];?></button>
		</form>
	
	</div>

	<div id="jak_stylebutton">
		<i class="fa fa-cog"></i>
	</div>

</div>
<script type="text/javascript" src="<?php echo BASE_URL;?>template/jakweb/js/styleajax.js"></script>
<script type="text/javascript">
	jakWeb.jak_submit = "<?php echo $tl['contact']['s'];?>";
	jakWeb.jak_submitwait = "<?php echo $tl['general']['g99'];?>";
</script>