<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Add a new lead</title>
<style>
	body{
		font-family:Arial, Helvetica, sans-serif;
		font-size: 13px;
	}
	.content, .contentA{
		padding:10px;
		width:370px
	}
	.left{
		width:150px;
		float:left;
		padding:7px 0px 0px 7px;
		min-height:24px;
	}
	.right{
		width:200px;
		float:left;
		padding:5px;
		min-height:24px;
	}
	.clear{
		float:none;
		clear:both;
		height:0px;
	}
	.row{
		background-color:none;
		display:block;
		min-height:32px;
	}
	.text{
		width:190px;
	}
	.ruler{
		width:400px; border-bottom:dashed 1px #dcdcdc;
	}
	tr:focus{
		background-color:#fcfcf0;
	}
	td{
		vertical-align:top;
	}
	.over{
		background-color:#e6e2af;
	}
	.out{
		background-color:none;
	}
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
		$(document).ready(function()
		{
			$('.content .left, .content input, .content textarea, .content select').focus(function(){
				$(this).parents('.content').addClass("over");
			}).blur(function(){
				$(this).parents('.content').removeClass("over");
			});
			$('.contentA .left, .contentA input, .contentA textarea, .contentA select').focus(function(){
				$(this).parents('.row').addClass("over");
			}).blur(function(){
				$(this).parents('.row').removeClass("over");
			});
		});
</script>
</head>

<body>
	<form action="http://159.203.240.21/postnewlead.php" method="post" style="margin-left:30%;">
<?php $_SESSION["authenticated_user_id"] ?>
        <input type="hidden" name="ownerid" id="ownerid" value="<?php echo $_SESSION["authenticated_user_id"] ?>" />	
	<div style="float:left; margin-right:20px; width:400px;">
	<h3>Add New Lead</h3>
	<div class="contentA">
		<div class="row">
			<div class="left">First name</div>
			<div class="right"><input name="firstname" id="firstname" type="text" class="text"  required /></div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="left">Last name</div>
			<div class="right"><input name="lastname" id="lastname"  type="text" class="text" required /></div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="left">Email</div>
			<div class="right"><input name="email" id="email" type="text" class="text" /></div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="left">Phone</div>
			<div class="right"><input name="cf_648" id="cf_648" type="text" class="text" required /></div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="left">Home Phone</div>
			<div class="right"><input name="homenumber" id="homenumber" type="text" class="text" /></div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="left">Cell</div>
			<div class="right"><input name="cell" id="cell" type="text" class="text"  /></div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="left">Fax</div>
			<div class="right"><input name="fax" id="fax" type="text" class="text" /></div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="left">DBA</div>
			<div class="right"><input name="cf_641"  id="cf_641" type="text" class="text" required /></div>
			<div class="clear"></div>
		</div>
       <div class="row">
			<div class="left">Legal/Corporate Name</div>
			<div class="right"><input name="cf_640"  id="cf_640" type="text" class="text" /></div>
			<div class="clear"></div>
		</div>
		</div>

		<div class="row">
			<div class="left">Priority</div>
			<div class="right"><select name="cf_735" tabindex="" class="text"> 
				<option value="Hot" > Hot </option> <option value="Warm" > 
				Warm </option> <option value="Cold" > Cold </option> </select> 

</div>
			<div class="clear"></div>
		</div>
		</div>

      
	
		<div class="contentA">
		<div class="row">
			<div class="left">Address</div>
			<div class="right"><input name="cf_729" id="cf_729"  type="text" class="text" /></div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="left">zip</div>
			<div class="right"><input name="cf_644" id="cf_644"  type="text" class="text" /></div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="left">City</div>
			<div class="right"><input name="cf_642" id="cf_642" type="text" class="text" /></div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="left">State</div>
			<div class="right"><input name="cf_643" id="cf_643" type="text" class="text" /></div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="left">Campaign Source </div>
			<div class="right">
<select name="cf_734" tabindex="" class="small"> <option value="Incoming Calls" > Incoming Calls </option> <option value="Outbound Calls" > Outbound Calls </option> <option value="Emails" > Email </option> <option value="Paper Leads" > Paper Leads </option> <option value="Press1" > Press1 </option> <option value="Auto Dialer" > Auto Dialer </option> </select>

			</div>
			<div class="clear"></div>
		</div>
	</div>



	<input type="submit">
		

	</form>
</body>

</html>
