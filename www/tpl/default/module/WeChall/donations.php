<?php
$css = <<<CSS
div.donation-page pre, div.donation-page ul, div.donation-page div.box {
padding: 8px;
}
div.donation-page form {
display: inline-block;
}
span.donor {
color: gold;
font-weight: bold;
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
<pre>Donations 2017:    7 donations
Sum:    €300,00
Goal:   €350,00
</pre>

<pre>Donations 2018:    3 donations
Sum:    €555,00
Goal:   €350,00
</pre>

<pre>Totals:           10 donations
Sum:    €855,00
Goal:   €700,00
</pre>

</div>

<div class="box">
We currently have the following ca. expenses for WeChall:<br/>
<ul>
<li>- Box0 (warchall.net) €100/y</li>
<li>- Box2 (wechall.net) €120/y</li>
<li>- Box3 (irc.wechall.net) €100/y</li>
<li>- Domain costs €30/y</li>
<li>-&nbsp;</li>
<li>- Wishlist; A better server for www only. Tear mailserver and maybe some challs apart.</li>
</ul>
</div>

<hr>

<div class="box">
<h2>Hall of purchased Fame :)</h2>
<ol>
<li>----- 2017 -----</li>
<li>3.Oct.2017 – <em>&quot;I challenge you to donate more than I did :)!&quot;</em> – ???</li>
<li>8.Nov.2017 – <em>&quot;When in doubt, .slap dloser&quot;</em> – ???</li>
<li>3.Dec.2017 – <em>&quot;I feel great to can contribute to this great project and know many people with same interests&quot;</em> – <span class="donor">spnow</span></li>
<li>8.Dec.2017 – <em>&quot;Awesome work guys - glad to be part of the community!&quot;</em> – <span class="donor">benito255</span></li>
<li>----- 2018 -----</li>
<li>28.Jan.2018 – <em>&quot;37K users and only 8 donations?! Shame on you!&quot;</em> – ???</li>
<li>31.Jul.2018 - <em>&quot;You folks do good work.&quot;</em> - ???</li>
<li>1.Aug.2018 - <em>&quot;That's nothing but here's some €€€ for this awesome website!&quot;</em> - ???</li>
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
