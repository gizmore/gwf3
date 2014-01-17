<?php
require '../config.php';
$username = isset($_GET['username']) ? (string)$_GET['username'] : 'Guest';
?>
<!DOCTYPE html>
<html>
<head>
<title>Live RCE [Warchall]</title>
<style type="text/css">
* {
margin: 0;
padding: 0;
}
body {
background: #000;
color: #0f0;
padding: 24px;
}
p {
padding: 12px 0;
}
</style>
</head>
<body>
<h1>Live RCE!</h1>
<p>Hello <?php echo $username; ?>!</p>
<p>Here are your $_SERVER vars:</p>
<pre>
<?php print_r($_SERVER); ?>
</pre>
<p>Kind Regards<br/>The Warchall staff!</p>
<!-- We hope you like our signatures :) -->
</body>
</html>
