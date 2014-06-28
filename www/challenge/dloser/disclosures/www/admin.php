<?php
require 'config.php';
dldc_session_start();
require 'header.php';
if (!dldc_is_admin())
{
	dldc_error('Permission denied!');
}
else
{
?>
<h1>Admin Panel</h1>
<p>Due to a security investigation, the admin panel is currently disabled.</p> 
<?php
}
require 'footer.php';
