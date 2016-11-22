<!DOCTYPE html>
<html lang="en">
<head>

	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?=SHOPNAME?> 관리자</title>
	<meta name="description" content="<?=SHOPNAME?> Manage">
	<meta name="author" content="Dennis Ji">
	<meta name="keyword" content="<?=SHOPNAME?>, Admin">
	<!-- end: Meta -->

	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->

	<!-- start: CSS -->
	<link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="/css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="/css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<!-- end: CSS -->


	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->

	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->

	<!-- start: Favicon -->
	<link rel="shortcut icon" href="/img/favicon.ico">
	<!-- end: Favicon -->



</head>

<body>

<?if($lnd != "login"){?>
		<!-- start: Header -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="?mng=Y"><span><?=SHOPNAME?> ADMIN</span></a>

				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
						<!-- start: User Dropdown -->
						<li class="dropdown">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="halflings-icon white user"></i> <?=$_SESSION["ADMIN_ID"]?>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="?com=mng&pro=logout&mng=Y"><i class="halflings-icon off"></i> Logout</a></li>
							</ul>
						</li>
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->

			</div>
		</div>
	</div>
	<!-- start: Header -->
<?}?>

		<div class="container-fluid-full">
		<div class="row-fluid">

<?if($lnd != "login"){?>

			<!-- start: Main Menu -->
			<div id="sidebar-left" class="span2">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li <?if($com=="user"){?>class="active"<?}?>><a href="?com=user&lnd=list&mng=Y"><i class="icon-group"></i><span class="hidden-tablet"> 회원 관리</span></a></li>
						<li>
							<a class="dropmenu" href="#"><i class="icon-reorder"></i><span class="hidden-tablet"> 게시판 관리</span></a>
							<ul>
								<li <?if($code=="notice"){?><?}?>><a class="submenu" href="?com=board&lnd=list&mng=Y&code=notice"><i class="icon-exclamation-sign"></i><span class="hidden-tablet">공지사항</span></a></li>
								<li <?if($code=="community"){?><?}?>><a class="submenu" href="?com=board&lnd=list&mng=Y&code=community"><i class="icon-comments"></i><span class="hidden-tablet">자유게시판</span></a></li>
							</ul>
						</li>
						<li>
							<a class="dropmenu" href="#"><i class="icon-eye-open"></i><span class="hidden-tablet"> 상품 관리</span></a>
							<ul>
								<li <?if($code=="category"){?><?}?>><a class="submenu" href="?com=category&lnd=list"><i class="icon-cog"></i><span class="hidden-tablet">카테고리 관리</span></a></li>
								<li <?if($code=="productImg"){?><?}?>><a class="submenu" href="?com=productImg&lnd=list&mng=Y"><i class="icon-picture"></i><span class="hidden-tablet">상품이미지 관리</span></a></li>
								<li <?if($code=="product"){?><?}?>><a class="submenu" href="?com=product&lnd=list&mng=Y"><i class="icon-gift"></i><span class="hidden-tablet">상품 관리</span></a></li>
							</ul>
						</li>
						<li <?if($com=="payment"){?>class="active"<?}?>><a href="?com=payment&lnd=list&mng=Y"><i class="icon-money"></i><span class="hidden-tablet"> 결제관리</span></a></li>
						<li <?if($com=="calc"){?>class="active"<?}?>><a href="?com=calc&lnd=list&mng=Y"><i class="icon-cog"></i><span class="hidden-tablet"> 정산관리</span></a></li>
						<li <?if($com=="mng"){?>class="active"<?}?>><a href="?com=mng&lnd=list&mng=Y"><i class="icon-user"></i><span class="hidden-tablet"> 관리자 관리</span></a></li>
						<!--<li <?if($com=="test"){?>class="active"<?}?>><a href="#none"><i class="icon-signal"></i><span class="hidden-tablet"> 접속통계</span></a></li>-->
					</ul>
				</div>
			</div>
			<!-- end: Main Menu -->

			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
<?}?>
