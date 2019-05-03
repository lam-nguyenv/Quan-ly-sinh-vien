<!DOCTYPE html>
<html>
<head>
	<base href="{{asset('')}}">
	<link rel="stylesheet" type="text/css" href="frontend\admin\home\home.css">

	<link rel="stylesheet" type="text/css" href="frontend\admin\qlddk\ql_ddk.css">

	<link rel="stylesheet" type="text/css" href="frontend\admin\qltk\them_tk.css">
	<link rel="stylesheet" type="text/css" href="frontend\admin\qltk\sua_tk.css">
	<link rel="stylesheet" type="text/css" href="frontend\admin\qltk\timkiem_tk.css">
	<link rel="stylesheet" type="text/css" href="frontend\admin\qltk\xem_tk.css">

	<link rel="stylesheet" type="text/css" href="frontend\admin\qltkcn\sua_tkcn.css">
	<link rel="stylesheet" type="text/css" href="frontend\admin\qltkcn\xem_tkcn.css">


</head>
<body>
	@include('admin.layout.header')

	<!-- narbar-menu --> 

	<div class="content">
		@include('admin.layout.menu')

		<!-- Page content -->
		@yield('content')
	</div>
</body>
</html>