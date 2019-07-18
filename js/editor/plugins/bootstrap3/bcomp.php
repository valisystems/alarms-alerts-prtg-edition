<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Bootstrap 3 Components</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <meta name="author" content="CLARICOM (http://www.claricom.ca)" />
        <link href="../../../../css/stylesheet.css" rel="stylesheet" type="text/css" />
        
        <style type="text/css">
        	.container {
        		width: 100%;
        	}
            .the-icons {
              margin-left: 0;
              list-style: none;
            }
            .the-icons li {
              float: left;
              width: 25%;
              line-height: 25px;
            }
            .the-icons i:hover {
              background-color: rgba(255,0,0,.25);
            }
            .item {padding:15px 30px 30px;border-bottom:#e7e7e7 1px solid;
                -webkit-box-shadow:0 0 40px rgba(0, 0, 0, 0.1) inset;
                -moz-box-shadow:0 0 40px rgba(0, 0, 0, 0.1) inset;
                box-shadow:0 0 40px rgba(0, 0, 0, 0.1) inset;}
        </style>
        
        <script type="text/javascript" src="../../../jquery.js"></script>
        
        <script type="text/javascript">
        	
        	function insertSnippet(id){
        		var target = window.parent.document.getElementById('<?php echo $_GET['editor']; ?>_ifr');
        		var closed = window.parent.document.getElementsByClassName('mce-bootstrap');
        		$(target).contents().find('#tinymce').append(document.getElementById(id).innerHTML);
        		$(closed).find('.mce-close').trigger('click');
        		//<?php echo $_GET['editor']; ?>_ifr.insertContent(document.getElementById(id).innerHTML);
        	}
        	
        	function insertButton(classname){
        		var target = window.parent.document.getElementById('<?php echo $_GET['editor']; ?>_ifr');
        		var closed = window.parent.document.getElementsByClassName('mce-bootstrap');
        		$(target).contents().find('#tinymce').append('<a href="#" class="' + classname + '" title="">Action</a> &nbsp;');
        		$(closed).find('.mce-close').trigger('click');
        		//<?php echo $_GET['editor']; ?>_ifr.insertContent(document.getElementById(id).innerHTML);
        	}
        	
        	function insertLabel(classname){
        		var target = window.parent.document.getElementById('<?php echo $_GET['editor']; ?>_ifr');
        		var closed = window.parent.document.getElementsByClassName('mce-bootstrap');
        		$(target).contents().find('#tinymce').append('<span class="' + classname + '">Label</span> &nbsp;');
        		$(closed).find('.mce-close').trigger('click');
        		//<?php echo $_GET['editor']; ?>_ifr.insertContent(document.getElementById(id).innerHTML);
        	}
        	
        	function insertThumbnails(n){
        		var target = window.parent.document.getElementById('<?php echo $_GET['editor']; ?>_ifr');
        		var closed = window.parent.document.getElementsByClassName('mce-bootstrap');
        		
        		var sHtml = '<div class="row">';
        		for(var i=0;i<n;i++){
        		    sHtml += '<div class="col-sm-3 col-md-2"><a href="#" class="thumbnail"><img src="http://placehold.it/260x180" alt="" /></a></div>';
        		}
        		sHtml += '</div><br />';
        		
        		$(target).contents().find('#tinymce').append(sHtml);
        		$(closed).find('.mce-close').trigger('click');
        		//<?php echo $_GET['editor']; ?>_ifr.insertContent(document.getElementById(id).innerHTML);
        	}
        	
        	function insertBar(classname,percentage,active,stripe){
        		var target = window.parent.document.getElementById('<?php echo $_GET['editor']; ?>_ifr');
        		var closed = window.parent.document.getElementsByClassName('mce-bootstrap');
        		
        		var sHtml = '<div class="progress'+stripe+active+'"><div class="progress-bar '+classname+'" style="width: '+percentage+'%"><span class="sr-only">'+percentage+'% Complete</span></div></div><p>&nbsp;</p>';
        		
        		$(target).contents().find('#tinymce').append(sHtml);
        		$(closed).find('.mce-close').trigger('click');
        		//<?php echo $_GET['editor']; ?>_ifr.insertContent(document.getElementById(id).innerHTML);
        	}
        	
        	function insertIcon(classname,colour,fontsize){
        		var target = window.parent.document.getElementById('<?php echo $_GET['editor']; ?>_ifr');
        		var closed = window.parent.document.getElementsByClassName('mce-bootstrap');
        		if (fontsize) fontsize = 'font-size:'+fontsize+'px';
        		$(target).contents().find('#tinymce').append('<span style="color:'+colour+';'+fontsize+'" class="' + classname + '">&nbsp;</span>');
        		$(closed).find('.mce-close').trigger('click');
        		alert("OK");
        		//<?php echo $_GET['editor']; ?>_ifr.insertContent(document.getElementById(id).innerHTML);
        	}
        </script>
        
</head>
<body>

<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
    	<div class="navbar-header">
    	  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
    	    <span class="sr-only">Toggle navigation</span>
    	    <i class="fa fa-bars"></i>
    	  </button>
    	  <!-- <a class="navbar-brand" href="#">Project name</a>-->
    	</div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
	            <li><a href="#text">Typography</a></li>
	            <li><a href="#layout">Layouts</a></li>
	            <li><a href="#button">Buttons</a></li>
	            <li><a href="#label">Labels &amp; Badges</a></li>
	            <li><a href="#image">Images</a></li>
	            <li><a href="#thumbnails">Thumbnails</a></li>
	            <li><a href="#alert">Alerts</a></li>
	            <li><a href="#bars">Bars</a></li>
	            <li><a href="#table">Tables</a></li>
            </ul>
            </div>
        </div>
</div>

<div class="container">

<div data-spy="scroll" data-target="#navbarExample" data-offset="0" style="height:550px;overflow:auto;position:relative;margin-top:40px;">

<div id="text"></div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Hero Unit</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divHeroUnit">
        <div class="jumbotron">  
	        <h1>Hello, world!</h1>  
	        <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content.</p>  
	        <p>    
            <a class="btn btn-primary btn-large">      Learn more    </a>  
            </p>
        </div>
        <p>&nbsp;</p>
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divHeroUnit')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Page Header</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divPageHeader">
        <div class="page-header">  
	        <h1>Page header <small>Subtext for header</small></h1>
        </div>
        <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula.</p>          
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divPageHeader')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Body copy</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divBodyCopy">
        <p>Body copy here. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula.</p>          
    </div>
    <div class="col-md-2">        
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divBodyCopy')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Lead copy</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divLeadCopy">
        <p class="lead">Lead copy here. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.</p> 
    </div>
    <div class="col-md-2">        
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divLeadCopy')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Address</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divAddress">
        <address><strong>Your Company, Inc.</strong><br />
        Address<br />
        City, State, Zip<br />
        <abbr title="Phone">P:</abbr> (123) 456-7890</address> 
        <address>  <strong>Full Name</strong><br />
        <a href="mailto:#">first.last@gmail.com</a></address>  
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divAddress')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Blockquote</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divBlockquote">
        <blockquote>  
	    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>  
        <small>Someone famous <cite title="Source Title">Source Title</cite></small>
        </blockquote>
        <p>&nbsp;</p>
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divBlockquote')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Code</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divMultiCode">
        <pre><code>&lt;p&gt;Sample text here...&lt;/p&gt;</code></pre>
        <p>&nbsp;</p>
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divMultiCode')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Well</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divWell">
        <div class="well">              
        Look, I'm in a well!
        </div>
        <p>&nbsp;</p>
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divWell')">Insert</a></div>
    </div>
</div>
</div>

<div id="layout"></div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>2 Columns (Left Sidebar)</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divLayout1">
        
        <div class="row">
            <div class="col-md-4">
                Occaecat commodo aliqua delectus. Fap craft beer deserunt skateboard ea. Lomo bicycle rights adipisicing banh mi, velit ea sunt next level locavore single-origin coffee in magna veniam. 
            </div>
            <div class="col-md-8">
                Occaecat commodo aliqua delectus. Fap craft beer deserunt skateboard ea. Lomo bicycle rights adipisicing banh mi, velit ea sunt next level locavore single-origin coffee in magna veniam. High life id vinyl, echo park consequat quis aliquip banh mi pitchfork. Vero VHS est adipisicing. Consectetur nisi DIY minim messenger bag. Cred ex in, sustainable delectus consectetur fanny pack iphone.
            </div>
        </div>
        <p>&nbsp;</p>

    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divLayout1')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>2 Columns (Right Sidebar)</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divLayout2">
        
        <div class="row">
            <div class="col-md-8">
                Occaecat commodo aliqua delectus. Fap craft beer deserunt skateboard ea. Lomo bicycle rights adipisicing banh mi, velit ea sunt next level locavore single-origin coffee in magna veniam. High life id vinyl, echo park consequat quis aliquip banh mi pitchfork. Vero VHS est adipisicing. Consectetur nisi DIY minim messenger bag. Cred ex in, sustainable delectus consectetur fanny pack iphone.
            </div>
            <div class="col-md-4">
                Occaecat commodo aliqua delectus. Fap craft beer deserunt skateboard ea. Lomo bicycle rights adipisicing banh mi, velit ea sunt next level locavore single-origin coffee in magna veniam. 
            </div>
        </div>
        <p>&nbsp;</p>

    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divLayout2')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>3 Columns</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divLayout3">
        
        <div class="row">
            <div class="col-md-4">
                Occaecat commodo aliqua delectus. Fap craft beer deserunt skateboard ea. Lomo bicycle rights adipisicing banh mi, velit ea sunt next level locavore single-origin coffee in magna veniam. 
            </div>
            <div class="col-md-4">
                Occaecat commodo aliqua delectus. Fap craft beer deserunt skateboard ea. Lomo bicycle rights adipisicing banh mi, velit ea sunt next level locavore single-origin coffee in magna veniam. 
            </div>
            <div class="col-md-4">
                Occaecat commodo aliqua delectus. Fap craft beer deserunt skateboard ea. Lomo bicycle rights adipisicing banh mi, velit ea sunt next level locavore single-origin coffee in magna veniam. 
            </div>
        </div>
        <p>&nbsp;</p>

    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divLayout3')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>4 Columns</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divLayout4">
        
        <div class="row">
            <div class="col-md-3">
                Occaecat commodo aliqua delectus. Fap craft beer deserunt skateboard ea. Lomo bicycle rights adipisicing banh mi, velit ea sunt next level locavore single-origin coffee in magna veniam. 
            </div>
            <div class="col-md-3">
                Occaecat commodo aliqua delectus. Fap craft beer deserunt skateboard ea. Lomo bicycle rights adipisicing banh mi, velit ea sunt next level locavore single-origin coffee in magna veniam. 
            </div>
            <div class="col-md-3">
                Occaecat commodo aliqua delectus. Fap craft beer deserunt skateboard ea. Lomo bicycle rights adipisicing banh mi, velit ea sunt next level locavore single-origin coffee in magna veniam. 
            </div>
            <div class="col-md-3">
                Occaecat commodo aliqua delectus. Fap craft beer deserunt skateboard ea. Lomo bicycle rights adipisicing banh mi, velit ea sunt next level locavore single-origin coffee in magna veniam. 
            </div>
        </div>
        <p>&nbsp;</p>

    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divLayout4')">Insert</a></div>
    </div>
</div>
</div>

<div id="button"></div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Buttons (Links)</h4> 
    </div>
</div>
<div class="row">
    <div class="col-sm-10">
        <p>    
            <a class="btn btn-primary" href="#">Primary</a>    
            <a class="btn btn-default" href="#">Default</a>    
            <a class="btn btn-info" href="#">Info</a>    
            <a class="btn btn-success" href="#">Success</a>    
            <a class="btn btn-warning" href="#">Warning</a>    
            <a class="btn btn-danger" href="#">Danger</a>    
            <a class="btn btn-link" href="#">Inverse</a>
        </p>
        <p>    
            <a class="btn btn-default btn-lg" href="#">Large</a>    
            <a class="btn btn-default" href="#">Default</a>    
            <a class="btn btn-default btn-sm" href="#">Small</a>    
            <a class="btn btn-default btn-xs" href="#">Mini</a>
        </p>
    </div>
    <div class="col-sm-2">
            <select id="selBtn1" class="form-control">
                <option value="btn btn-primary">Primary</option>
                <option value="btn btn-default">Default</option>
                <option value="btn btn-info">Info</option>
                <option value="btn btn-success">Success</option>
                <option value="btn btn-warning">Warning</option>
                <option value="btn btn-danger">Danger</option>
                <option value="btn btn-link">Inverse</option>
            </select>
            <select id="selBtn2" class="form-control">
                <option value="btn-lg">Large</option>
                <option value="">Default</option>
                <option value="bbtn-sm">Small</option>
                <option value="btn-xs">Mini</option>
            </select>
            <a class="btn btn-success" href="javascript:insertButton(document.getElementById('selBtn1').value + ' ' + document.getElementById('selBtn2').value)">Insert</a>
    </div>
</div>
</div>

<div id="label"></div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Labels</h4> 
    </div>
</div>
<div class="row">
    <div class="col-sm-10" id="divTitle">
        <span class="label label-default">Default</span>
        <span class="label label-primary">Primary</span>
        <span class="label label-success">Success</span>
        <span class="label label-warning">Warning</span>
        <span class="label label-danger">Important</span>
        <span class="label label-info">Info</span>
    </div>
    <div class="col-sm-2">
            <select id="selLabel" class="form-control">
                <option value="label label-default">Default</option>
                 <option value="label label-primary">Primary</option>
                <option value="label label-success">Success</option>
                <option value="label label-warning">Warning</option>
                <option value="label label-danger">Important</option>
                <option value="label label-info">Info</option>
            </select>
        <a class="btn btn-success" href="javascript:insertLabel(document.getElementById('selLabel').value)">Insert</a>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Badges</h4> 
    </div>
</div>
<div class="row">
    <div class="col-sm-10" id="div1">
        <span class="badge">Default</span> &nbsp;

    </div>
    <div class="col-sm-2">
            <select id="selBadge" class="form-control">
                <option value="badge">Default</option>
            </select>
            <a class="btn btn-success" href="javascript:insertLabel(document.getElementById('selBadge').value)">Insert</a>
    </div>
</div>
</div>

<div id="image"></div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Image (Rounded)</h4>
        <p>Add <code>class="img-responsive"</code> for responsive images</p>
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divImg1">
        <img src="http://placehold.it/140x140" class="img-rounded" alt="" />&nbsp;
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divImg1')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Image (Circle)</h4>
        <p>Add <code>class="img-responsive"</code> for responsive images</p>
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divImg2">
        <img src="http://placehold.it/140x140" class="img-circle" alt="" />&nbsp;
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divImg2')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Image (Polaroid)</h4>
        <p>Add <code>class="img-responsive"</code> for responsive images</p>
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divImg3">
        <img src="http://placehold.it/140x140" class="img-polaroid" alt="" />&nbsp;
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divImg3')">Insert</a></div>
    </div>
</div>
</div>

<div id="thumbnails"></div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Thumbnails</h4> 
    </div>
</div>
<div class="row">
    <div class="col-sm-10" id="divThumbnails">
    	<div class="row">
    	  <div class="col-sm-3 col-md-2">
    	    <a href="#" class="thumbnail">
    	      <img src="http://placehold.it/260x180" alt="...">
    	    </a>
    	  </div>
    	  <div class="col-sm-3 col-md-2">
    	    <a href="#" class="thumbnail">
    	      <img src="http://placehold.it/260x180" alt="...">
    	    </a>
    	  </div>
    	  <div class="col-sm-3 col-md-2">
    	    <a href="#" class="thumbnail">
    	      <img src="http://placehold.it/260x180" alt="...">
    	    </a>
    	  </div>
    	  <div class="col-sm-3 col-md-2">
    	    <a href="#" class="thumbnail">
    	      <img src="http://placehold.it/260x180" alt="...">
    	    </a>
    	  </div>
    	</div>
    </div>
    <div class="col-sm-2">
        <select id="selNumOfImg" class="form-control">
            <option value="2">2 Images</option>
            <option value="3">3 Images</option>
            <option value="4" selected="selected">4 Images</option>
            <option value="5">5 Images</option>
            <option value="6">6 Images</option>
            <option value="7">7 Images</option>
            <option value="8">8 Images</option>
            <option value="9">9 Images</option>
            <option value="10">10 Images</option>
            <option value="11">11 Images</option>
            <option value="12">12 Images</option>
            <option value="13">13 Images</option>
            <option value="14">14 Images</option>
            <option value="15">15 Images</option>
            <option value="16">16 Images</option>
            <option value="17">17 Images</option>
            <option value="18">18 Images</option>
            <option value="19">19 Images</option>
            <option value="20">20 Images</option>
        </select>
        <a class="btn btn-success" href="javascript:insertThumbnails(document.getElementById('selNumOfImg').value)">Insert</a>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Thumbnails with caption</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divFeaturedThumbnails">
    	<div class="row">
    	        <div class="col-sm-4 col-md-4">
    	          <div class="thumbnail">
    	            <img alt="300x200" style="width: 300px; height: 200px;" src="http://placehold.it/300x200">
    	            <div class="caption">
    	              <h3>Thumbnail label</h3>
    	              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
    	              <p><a role="button" class="btn btn-primary" href="#">Button</a> <a role="button" class="btn btn-default" href="#">Button</a></p>
    	            </div>
    	          </div>
    	        </div>
    	        <div class="col-sm-4 col-md-4">
    	          <div class="thumbnail">
    	            <img alt="300x200" style="width: 300px; height: 200px;" src="http://placehold.it/300x200">
    	            <div class="caption">
    	              <h3>Thumbnail label</h3>
    	              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
    	              <p><a role="button" class="btn btn-primary" href="#">Button</a> <a role="button" class="btn btn-default" href="#">Button</a></p>
    	            </div>
    	          </div>
    	        </div>
    	        <div class="col-sm-4 col-md-4">
    	          <div class="thumbnail">
    	            <img alt="300x200" style="width: 300px; height: 200px;" src="http://placehold.it/300x200">
    	            <div class="caption">
    	              <h3>Thumbnail label</h3>
    	              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
    	              <p><a role="button" class="btn btn-primary" href="#">Button</a> <a role="button" class="btn btn-default" href="#">Button</a></p>
    	            </div>
    	          </div>
    	        </div>
    	      </div>
        <p>&nbsp;</p>
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divFeaturedThumbnails')">Insert</a></div>
    </div>
</div>
</div>

<div id="alert"></div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Alert (Warning)</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divAlert1">
        <div class="alert alert-warning">                          
	        <h4>Warning!</h4>              
	        <p>Nulla vitae elit libero, a pharetra augue. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</p>            
        </div>
        <p>&nbsp;</p>
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divAlert1')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Alert (Error)</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divAlert2">
        <div class="alert alert-danger">                            
            <strong>Oh snap!</strong> Nulla vitae elit libero, a pharetra augue. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
        </div>
        <p>&nbsp;</p>
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divAlert2')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Alert (Success)</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divAlert3">
        <div class="alert alert-success">                           
            <strong>Well done!</strong> Nulla vitae elit libero, a pharetra augue. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
        </div>
        <p>&nbsp;</p>
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divAlert3')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Alert (Info)</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divAlert4">
        <div class="alert alert-info">                          
            <strong>Heads up!</strong> Nulla vitae elit libero, a pharetra augue. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
        </div>
        <p>&nbsp;</p>
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divAlert4')">Insert</a></div>
    </div>
</div>
</div>

<div id="bars"></div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Simple Bars</h4> 
    </div>
</div>
<div class="row">
    <div class="col-sm-10" id="divBars1">
    
    	<div class="progress">
    	  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
    	  <span class="sr-only">40% Complete (info)</span>
    	  </div>
    	</div>
    	<div class="progress">
    	  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
    	  <span class="sr-only">40% Complete (success)</span>
    	  </div>
    	</div>
    	<div class="progress">
    	  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
    	      <span class="sr-only">60% Complete (warning)</span>
    	  </div>
    	</div>
    	<div class="progress">
    	  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
    	      <span class="sr-only">80% Complete</span>
    	  </div>
    	</div>

    </div>
    <div class="col-sm-2">
            <select id="selBars1" class="form-control">
                <option value="progress-bar-info">Info</option>
                <option value="progress-bar-success">Success</option>
                <option value="progress-bar-warning">Warning</option>
                <option value="progress-bar-danger">Danger</option>
            </select>
            <select id="selBarp1" class="form-control">
                <option value="20">20</option>
                <option value="40">40</option>
                <option value="60">60</option>
                <option value="80">80</option>
            </select>
            <a class="btn btn-success" href="javascript:insertBar(document.getElementById('selBars1').value,document.getElementById('selBarp1').value,'','')">Insert</a>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Striped Bars</h4> 
    </div>
</div>
<div class="row">
    <div class="col-sm-10" id="divBars2">
        
        <div class="progress progress-striped">
          <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
          	<span class="sr-only">40% Complete (info)</span>
          </div>
        </div>
        <div class="progress progress-striped active">
          <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
          	<span class="sr-only">40% Complete (success)</span>
          </div>
        </div>
        <div class="progress progress-striped">
          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
              <span class="sr-only">60% Complete (warning)</span>
          </div>
        </div>
        <div class="progress progress-striped active">
          <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
              <span class="sr-only">80% Complete</span>
          </div>
        </div>

    </div>
    <div class="col-sm-2">
            <select id="selBars2" class="form-control">
                <option value="progress-bar-info progress-striped">Info</option>
                <option value="progress-bar-success progress-striped">Success</option>
                <option value="progress-bar-warning progress-striped">Warning</option>
                <option value="progress-bar-danger progress-striped">Danger</option>
            </select>
            <select id="selBarp2" class="form-control">
                <option value="20">20</option>
                <option value="40">40</option>
                <option value="60">60</option>
                <option value="80">80</option>
            </select>
            <select id="selBara2" class="form-control">
                <option value="">No (active)</option>
                <option value=" active">Yes (active)</option>
            </select>
            <a class="btn btn-success" href="javascript:insertBar(document.getElementById('selBars2').value,document.getElementById('selBarp2').value,document.getElementById('selBara2').value,' progress-striped')">Insert</a>
    </div>
</div>
</div>

<div id="table"></div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Table Striped</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divTableStriped">
        <table class="table table-striped">              
	        <thead>                
		        <tr>                  
			        <th>#</th>                  
			        <th>First Name</th>                  
			        <th>Last Name</th>                  
			        <th>Username</th>                
		        </tr>              
	        </thead>              
	        <tbody>                
		        <tr>                  
			        <td>1</td>                  
			        <td>First</td>                  
			        <td>Last</td>                  
			        <td>@user</td>                
		        </tr>                
		        <tr>                  
			        <td>2</td>                  
			        <td>First</td>                  
			        <td>Last</td>                  
			        <td>@user</td>                
		        </tr>                
		        <tr>                  
			        <td>3</td>                  
			        <td>First</td>                  
			        <td>Last</td>                  
			        <td>@user</td>                
		        </tr>              
	        </tbody>            
        </table>
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divTableStriped')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Table Bordered</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divTableBordered">
        <table class="table table-bordered">              
	        <thead>                
		        <tr>                  
			        <th>#</th>                  
			        <th>First Name</th>                  
			        <th>Last Name</th>                  
			        <th>Username</th>                
		        </tr>              
	        </thead>              
	        <tbody>                
		        <tr>                  
			        <td>1</td>                  
			        <td>First</td>                  
			        <td>Last</td>                  
			        <td>@user</td>                
		        </tr>                
		        <tr>                  
			        <td>2</td>                  
			        <td>First</td>                  
			        <td>Last</td>                  
			        <td>@user</td>                
		        </tr>                
		        <tr>                  
			        <td>3</td>                  
			        <td>First</td>                  
			        <td>Last</td>                  
			        <td>@user</td>                
		        </tr>              
	        </tbody>            
        </table>
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divTableBordered')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Table Hover</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divTableHover">
        <table class="table table-hover">              
	        <thead>                
		        <tr>                  
			        <th>#</th>                  
			        <th>First Name</th>                  
			        <th>Last Name</th>                  
			        <th>Username</th>                
		        </tr>              
	        </thead>              
	        <tbody>                
		        <tr>                  
			        <td>1</td>                  
			        <td>First</td>                  
			        <td>Last</td>                  
			        <td>@user</td>                
		        </tr>                
		        <tr>                  
			        <td>2</td>                  
			        <td>First</td>                  
			        <td>Last</td>                  
			        <td>@user</td>                
		        </tr>                
		        <tr>                  
			        <td>3</td>                  
			        <td>First</td>                  
			        <td>Last</td>                  
			        <td>@user</td>                
		        </tr>              
	        </tbody>            
        </table>
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divTableHover')">Insert</a></div>
    </div>
</div>
</div>

<div class="item">
<div class="row">
    <div class="col-md-12">
        <h4>Table Condensed</h4> 
    </div>
</div>
<div class="row">
    <div class="col-md-10" id="divTableCondensed">
        <table class="table table-condensed">              
	        <thead>                
		        <tr>                  
			        <th>#</th>                  
			        <th>First Name</th>                  
			        <th>Last Name</th>                  
			        <th>Username</th>                
		        </tr>              
	        </thead>              
	        <tbody>                
		        <tr>                  
			        <td>1</td>                  
			        <td>First</td>                  
			        <td>Last</td>                  
			        <td>@user</td>                
		        </tr>                
		        <tr>                  
			        <td>2</td>                  
			        <td>First</td>                  
			        <td>Last</td>                  
			        <td>@user</td>                
		        </tr>                
		        <tr>                  
			        <td>3</td>                  
			        <td>First</td>                  
			        <td>Last</td>                  
			        <td>@user</td>                
		        </tr>              
	        </tbody>            
        </table>
    </div>
    <div class="col-md-2">
        <div class="pull-right"><a class="btn btn-success" href="javascript:insertSnippet('divTableCondensed')">Insert</a></div>
    </div>
</div>
</div>
</div>
</div>
</div>
  
</body>
</html>