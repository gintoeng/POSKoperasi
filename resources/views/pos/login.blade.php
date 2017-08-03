<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
@include('templates.headerpos')
</head>

<body>
	<style>

	body{
	margin:0;
	background-color:#369;
	overflow:auto;
}
</style>
<body id="">
<div style="width:1365px; height:638px; overflow:hidden; margin: 0 auto; position:relative; margin-top:0px; margin-left:0px; background-color:#369">
	<div style="margin-left:69px; position:absolute; margin-top:60px;">{!! HTML::image('cabangrekening', 'Logo1', array('width' => '190', 'height' => '200')) !!}</div>
	<div style="margin-left:1110px; position:absolute; margin-top:60px;">{!! HTML::image('csspos/assets/imgs/mitrautama.png', 'Logo2', array('width' => '190', 'height' => '200')) !!}</div>

	<div style="width:230px;height:60px;background:red;color:#FFF;font-size:32px;margin-left:1137px;cursor:pointer;padding-top:5px;padding-left:35px;">ESC | EXIT</div>
		<div style="width:1365px;height:200px;margin-top:0px;background-color:#4183D7;">
			<textarea style="resize:none;position:absolute;width:800px;height:70px;margin-top:10px;margin-left:310px;background:#4183D7;color:#FFF;font-size:36px;text-align:center;border:none;">
			</textarea>

			<textarea style="color:#000;border:none;resize:none;background:#4183D7;border-color:#4183D7;font-size:22px;color:#FFF;width:800px;text-align:center;margin-left:300px;margin-top:85px;"> 
			</textarea>
		</div>
		<div style="font-size:62px;color:#FFF;margin-left:605px;margin-top:50px">LOGIN</div>

<div class="input-control text" style="font-size:23px; margin-left:400px; margin-top:0px;color:black;position:absolute;">
    <input type="text" name="user" style="width:600px;text-align:center;"autofocus>
</div>
<div class="input-control text" style="font-size:23px; margin-left:400px;position:absolute; margin-top:80px;color:black;">
    <input type="password" name="password" style="width:600px;text-align:center;"autofocus>
</div>
<a href="{!! url('/index') !!}"><div style="width:200px;height:60px;background:#3498db;color:#FFF;font-size:32px;margin-left:800px;cursor:pointer;padding-top:5px;padding-left:0px;margin-top:170px;"align="center">Login</div></a>


	</div>


</body>
