var data;
var xhr;
var tid;

function getPosts(thread_id, page)
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
	
	xhr.open("POST", "getposts.php", true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// send querystrings 
	if (page != 0){
		// pagination link clicked
		xhr.send("page="+page+"&thread_id="+thread_id);
	}else{
		// page loading 
		xhr.send("thread_id="+thread_id);
	}	
	// store variable for pagination links
	tid = thread_id;
	console.log("thread_id: " + tid);
}	

// eventlistener for pagination links after DOM loads
window.addEventListener("load", function() {
	
	// listen to all clicks on the document
	document.addEventListener("click", function(e){
		if(!e.target.matches("[data-page]")) return;		
		e.preventDefault();		
		var page = e.target.dataset.page; // get page number from link			
		getPosts(tid, page);
	}, false);	
});