<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$Homepage = &$Page;
?>
<?php
$Page->showMessage();
?>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
	<div class="container-fluid">
		<a class="navbar-brand" href="javascript:void(0)">
				<img src="images/nav_logo.png" alt="Logo" style="height:30px;"> 
		</a>
		<a class="navbar-brand" href="/Homepage">EFGA Carry Enterprises</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
			<span class="navbar-togger-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="mynavbar">
			<ul class="navbar-nav me-auto">
				<li class="nav-item">
					<a class="nav-link" href="javascript:void(0)"></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="javascript:void(0)"></a>
				</li>
			</ul>
			<a class="btn btn-outline-light" href="../efga_expense_system/login" role="button">Log in</a>
		</div>
	</div>	
</nav>

<style type="text/css">   
    body{
        background-image: url("images/homepagee.jpg");
        background-size: cover;
        background-repeat: no-repeat;
    }   
</style>

<?= GetDebugMessage() ?>
