<?php
$css = <<<CSS
div.donation-page pre, div.donation-page ul, div.donation-page div.box {
padding: 8px;
}
div.donation-page form {
display: inline-block;
}
CSS;
GWF_Website::addInlineCSS($css);
?>
<div class="donation-page">
<h1>Donations</h1>

<?php if (isset($_GET['thx'])) : ?>
<div class="box">
Thank you very much!<br/>
We will probably contact you any time soon, for saying thanks.
</div>
<?php endif; ?>

<div class="box">
You are reading it right, we are accepting donations now: <?= $tVars['paybutton']; ?><br/>
It would be awesome if some people would donate something, as the rent for <a href="http://warchall.net">box0</a> and <a href="https://www.wechall.net">box2</a> is due in nov/december.<br/>
We will give an overview here of the donations, manually updated.<br/>
</div>
<div class="box">
<pre>Donors:       4
Sum:    €220,00
Goal:   €350,00
</pre>
</div>

<div class="box">
We currently have the following ca. expenses for WeChall:<br/>
<ul>
<li>- Box0 (warchall.net) €110/y</li>
<li>- Box2 (wechall.net) €100/y</li>
<li>- Box3 (irc.wechall.net) €100/y</li>
<li>- Domain costs €30/y</li>
<li>-&nbsp;</li>
<li>- Wishlist; A better server?</li>
</ul>
</div>

<hr>

<div class="box">
<h2>Hall of purchased Fame :)</h2>
<ol>
<li>3.Oct.2017 – <em>&quot;I challenge you to donate more than I did :)!&quot;</em> – ???</li>
<li>8.Nov.2017 – <em>When in doubt, .slap dloser</em> – ???</li>
</ol>
</div>

<hr>

<div class="box">
If you donate you <em>can</em> get an entry here. Just tell us what you would like to write on this wall.<br/>
<br/>
THANKS!
<br/>
</div>
</div>
