var data;
var xhr;
var tid;

function getThreads(topic_id, page)
{
	// instantiate request
	xhr = new XMLHttpRequest();
	
	xhr.onreadystatechange = function()
	{
		// if request finished, response ready and status ok
		if(xhr.readyState == 4 && this.status == 200)
		{
			data = xhr.responseText;
			document.querySelector("#display").innerHTML = data;
		}
	}	
	
	xhr.open("POST", "getthreads.php", true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// send querystrings 
	if (page != 0){
		// pagination link clicked
		xhr.send("page="+page+"&topic_id="+topic_id);
	}else{
		// page loading 
		xhr.send("topic_id="+topic_id);
	}	
	// store variable for pagination links
	tid = topic_id;
}	

// eventlistener for pagination links after DOM loads
window.addEventListener("load", function() {
	
	// listen to all clicks on the document
	document.addEventListener("click", function(e){
		if(!e.target.matches("[data-page]")) return;		
		e.preventDefault();		
		var page = e.target.dataset.page; // get page number from link			
		getThreads(tid, page);
	}, false);	
});