<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
	<a class="navbar-brand p-0" href="./"><img src="/myproject/includes/images/ctin-logo6.png" height="30px">&nbsp<b>CTIN</b></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle Navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="./">Trang chủ</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="./projects.php">Thông tin dự án</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="./personnel.php">Nhân sự</a>
			</li>
		</ul>
		<div class="dropdown">
			<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['email']; ?></button>

			<div class="dropdown-menu">
				<a class="dropdown-item" href="account.php">Thông tin</a>
				<a class="dropdown-item" href="logout.php">Đăng xuất</a>
			</div>
		</div>
	</div>
</nav>