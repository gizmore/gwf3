<nav>
  <div>You are: <?=Session::get('username', 'Guest')?></div>
  <ul>
    <li><a href="login.php">Login</a></li>
    <li><a href="content.php">Content</a></li>
  </ul>
</nav>

<?php if (@$msg) : ?>
<div class="message"><?=$msg?></div>
<?php endif; ?>

<?php if (@$err) : ?>
<div class="error"><?=$err?></div>
<?php endif; ?>
