<h1>Edit Profile</h1>
<p>Take your time to edit your profile on Minihacks2.0!</p>
<div>
<form method="post">
<table>
<tr><td>Username</td><td><input type="text" name="username" disabled="disabled" value="<?=$user->display('username')?>" /></td></tr>
<tr><td>Old Password</td><td><input type="password" name="password_old" value="" autocomplete="off" /></td></tr>
<tr><td>New Password</td><td><input type="password" name="password_new" value="" autocomplete="off" /></td></tr>
<tr><td>Confirm Pass</td><td><input type="password" name="password_retype" value="" autocomplete="off" /></td></tr>
<tr><td>Email</td><td><input type="email" name="email" value="<?=$user->display('email')?>" /></td></tr>
<tr><td>First name</td><td><input type="text" name="firstname" value="<?=$user->display('firstname')?>" /></td></tr>
<tr><td>Last name</td><td><input type="text" name="lastname" value="<?=$user->display('lastname')?>" /></td></tr>
<tr><td colspan="2"><input type="submit" name="update" value="save" /></td></tr>
</table>
</form>
</div>
