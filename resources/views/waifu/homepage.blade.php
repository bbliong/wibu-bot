<!DOCTYPE html>
<html>
<head>
	<title>GetWaifu</title>
	 <link href="{{ asset('/css/admin_custom.css') }}" rel="stylesheet">
	  <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>
<body>
	
	<div class="col-md-6 col-md-offset-3">
	<h1 style="text-align : center;"> Get Waifu </h1>
	<form action="/wibubot/public/waifu/">
		<input type="text" name="name" class="form-control">
		</br>
		<input type="date" name="date" class="form-control">
		</br>
		<input type="submit" name="submit" value="simpan" class="form-control">
	</form>
	</div>
</body>
</html>