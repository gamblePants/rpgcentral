<div id="responsive-icon">	
	<a href="nojavascript.php" onclick="showMenu();return false;"><img src="images/menu_icon.png" width="25" height="25" alt="responsive_menu_icon"/>Forum Topics</a>	
</div>	
<div id="responsive-menu" class="menu-closed">
	<?php include "includes/navSecondary.php"; ?>
</div>


<script> 
	  function showMenu(){	  			
				document.getElementById("responsive-menu").classList.toggle("menu-open");			
	  }
</script>