<ul>	
	<li><a href="shop.php">Shop</a></li>
	<li><a href="events.php">Events</a></li>	
	<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
	<li><a href="logout.php">Logout</a></li>
	<?php else: ?>
	<li><a href="login.php">Login</a></li>
	<?php endif; ?>
	
</ul>

