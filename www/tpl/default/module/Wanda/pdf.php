<!DOCTYPE html>
<html>
<head>
<title><?php echo $tVars['title']; ?></title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; }
body, html {
height: 100%;
min-height: 100%;
}
.pdf-page {
min-height: 100%;
}

h1 { font-size: 46px; padding: 32px 64px; }
h2 { font-size: 44px; padding: 32px 64px; }
h3 { font-size: 42px; padding: 32px 64px; }
h4 { font-size: 40px; padding: 32px 64px; }
h5 { font-size: 38px; padding: 32px 64px; }
h6 { font-size: 36px; padding: 32px 64px; }

hr {
display: none;
}

b {
font-weight: normal;
color: #612;
opacity: 0.612;
}

em {
color: #612;
}

em, b, p {
font-size: 26px;
}

p {
padding: 24px 32px;
line-height: 40px;
letter-spacing: 1px;
font-family: serif;
white-space: pre-line;
}

img {
display: block;
padding: 16px 32px;
}

</style>
</head>
<body>
<h1><?php echo $tVars['title']; ?></h1>
<?php echo $tVars['pages'];?>
</body>
</html>