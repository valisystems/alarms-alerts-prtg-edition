/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// get the vote button
var votelems = document.getElementsByClassName('jak-cvote');
// Get the reply button
var replyelems = document.getElementsByClassName('jak-creply');

document.addEventListener('DOMContentLoaded', function() {

	for (var i = 0; i < votelems.length; i++) {
	    votelems[i].addEventListener('click', jak_record_votes, false);
	}
	
	for (var i = 0; i < replyelems.length; i++) {
	    replyelems[i].addEventListener('click', jak_set_replyid, false);
	}

});

function jak_record_votes() {
	
	// Do we have a vote already
	voted = false;
	if (this.classList)
	  voted = this.classList.contains("voted");
	else
	  voted = new RegExp('(^| )' + className + '( |$)', 'gi').test(this.className);
	  
	if (!voted) {
	
	    // Which container to update
		vc = document.getElementById("jak-cvotec"+this.dataset.id);
		
		// tak the vote status
		vs = this.dataset.cvote;
		
		// Curren Vote
		cv = vc.textContent;
		
		// finally add the class so we can only vote once
		if (this.classList)
		  this.classList.add("voted");
		else
		  this.className += ' ' + className;
	    	
	    var request = new XMLHttpRequest();
	    request.open('GET', jakWeb.jak_url+'include/ajax/cvote_update.php?vid='+this.dataset.id+'&ctable='+this.dataset.table+'&vote='+this.dataset.cvote, true);
	    	
	    	request.onload = function() {
	    	  if (request.status >= 200 && request.status < 400) {
	    	    // Success!
	    	    var data = JSON.parse(request.responseText);
	    	    
	    	    if (data.status == 1) {
	    	    	
	    	    	if (cv == "0" && vs == "down") {
	    	    	
	    	    		jak_remove_add_class(vc, "label-default", "label-danger");
	    	    	
	    	    	} else if (cv == "0" && vs == "up") {
	    	    	
	    	    		jak_remove_add_class(vc, "label-default", "label-success");
	    	    		
	    	    	} else if (cv == "-1" && vs == "up") {
	    	    	
	    	    		jak_remove_add_class(vc, "label-danger", "label-default");
	    	    		
	    	    	} else if (cv == "1" && vs == "down") {
	    	    	
	    	    		jak_remove_add_class(vc, "label-success", "label-default");
	    	    		
	    	    	} else {
	    	    		// Nothing to change
	    	    	}
	    	    	
	    	    	// Update the number
	    	    	if (vs == "up") {
	    	    		vc.textContent = parseInt(cv) + 1;
	    	    	} else {
	    	    		vc.textContent -= 1;
	    	    	}
	    	    	  	    	
	    	    }
	    	    
	    	  } else {
	    	    // We reached our target server, but it returned an error
	    	
	    	  }
	    	};
	    	
	    	request.onerror = function() {
	    	  // There was a connection error of some sort
	    	};
	    	
	    	request.send();
    	
    } else {
    	// We could output something.
    	return false;
    }
};

function jak_set_replyid() {

	// Check if we have an id
	ri = document.getElementById("comanswerid");

	[].forEach.call(replyelems, function(el) {
		
		// remove the success button
		jak_remove_add_class(el, "btn-success", "btn-primary");
		
		if (el.classList)
		  el.classList.remove("reply");
		else
		  el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
	
	});
	
	if (ri.value == this.dataset.id) {
	
		// Add the danger button
		jak_remove_add_class(this, "btn-success", "btn-primary");
		
		ri.value = 0;
	
	} else {
	
		// Now set the id
		ri.value = this.dataset.id;
		
		// Add the danger button
		jak_remove_add_class(this, "btn-primary", "btn-success");
		
		if (this.classList)
		  this.classList.add("reply");
		else
		  this.className += ' ' + className;
		  
		// Focuse the textarea
		document.getElementById("userpost").focus();
		tinymce.execCommand('mceFocus',false,'userpost');
	}

}

function jak_remove_add_class(el, classremove, classadd) {
	
	if (el.classList)
	  el.classList.remove(classremove);
	else
	  el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
	  
	if (el.classList)
	  el.classList.add(classadd);
	else
	  el.className += ' ' + className;

}