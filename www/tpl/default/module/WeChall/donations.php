<?php
$css = <<<CSS
div.donation-page pre, div.donation-page ul, div.donation-page div.box {
padding: 8px;
}
div.donation-page form {
display: inline-block;
}
a.donor {
color: gold;
font-weight: bold;
text-decoration: none;
}
span.nomsg:AFTER {
font-style: italic;
content: "No message left";
}
span.unknownuser:AFTER {
font-style: italic;
content: "???";
}
span.dodate {
display: inline-block;
min-width: 92px;
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
<br/>
<b>New: </b> We are now accepting <a style="font-weight: bold;" onclick="$('#bitcoinqr').toggle();">bitcoins</a><br/>
<br/>
<div>xpub661MyMwAqRbcFBHXoGuBJso1o99RoyzSv1gr7NUCk9uprUMYW92ByBLzkq4dFvLTizGKuked1DWeYGnivQe8xQYEvpfeJXwpy17aDu21f4N</div>
<div id="bitcoinqr" style="display:none;" onclick="$(this).hide()" ><img src="/img/default/bitcoin_donations.png"></div>
</div>
<div class="box">
<pre>Donations 2017:    7 donations
Sum:    €300,00
Goal:   €350,00
</pre>

<pre>Donations 2018:    7 donations
Sum:    €704,00
Goal:   €350,00
</pre>

<pre>Donations 2019:    8 donations
Sum:    €275,00
Goal:   €450,00
</pre>

<pre>Donations 2020:    3 donations
Sum:    €127,00
Goal:   €350,00
</pre>

<pre>Donations 2021:    3 donations
Sum:    €175,00
Goal:   €470,00
</pre>

<pre>Totals:           27 donations
Sum:    € 1571,00
Goal:   € 1970,00
</pre>

</div>

<div class="box">
We currently have the following ca. expenses for WeChall:<br/>
<ul>
<li>- Box0 (warchall.net) €100/y</li>
<li>- Box1 (---secret---) €0/y (gizmore pays)</li>
<li>- Box2 (wechall.net) €120/y</li>
<li>- Box3 (irc.wechall.net) €100/y</li>
<li>- Box4 (wanda.gizmore.org) €0/y (gizmore pays)</li>
<li>- Box5 (tbs.wechall.net) €120/y</li>
<li>- Domain costs €30/y</li>
<li>- T-Shirts 2019 €100</li>
<li>- T-Shirts 2020 €0</li>
<li>- T-Shirts 2021 €0</li>
<li>-&nbsp;</li>
<li>- Wishlist; A better server for www only. Tear mailserver and maybe some challs apart. (Still valid)</li>
<li>- Wishlist2; A re-setup of warchall.net with debian instead of gentoo (Now valid)</li></ul>
</div>

<hr>

<div class="box">
<h2>Hall of purchased Fame :)</h2>
<ol>
<li>----- 2017 -----</li>
<li><span class="dodate">3.Oct.2017</span> – <em>&quot;I challenge you to donate more than I did :)!&quot;</em> – ???</li>
<li><span class="dodate">8.Nov.2017</span> – <em>&quot;When in doubt, .slap dloser&quot;</em> – ???</li>
<li><span class="dodate">3.Dec.2017</span> – <em>&quot;I feel great to can contribute to this great project and know many people with same interests&quot;</em> – <a class="donor" href="/profile/spnow">spnow</a></li>
<li><span class="dodate">8.Dec.2017</span> – <em>&quot;Awesome work guys - glad to be part of the community!&quot;</em> – <a class="donor" href="/profile/benito255">benito255</a></li>
<li>----- 2018 -----</li>
<li><span class="dodate">28.Jan.2018</span> – <em>&quot;37K users and only 8 donations?! Shame on you!&quot;</em> – ???</li>
<li><span class="dodate">31.Jul.2018</span> - <em>&quot;You folks do good work.&quot;</em> – ???</li>
<li><span class="dodate">1.Aug.2018</span> - <em>&quot;That's nothing but here's some €€€ for this awesome website!&quot;</em> – ???</li>
<li><span class="dodate">8.Aug.2018</span> - <em>&quot;Thanks for everything so far! btw. what is the solution for shadowlamb 2, 3, &4?&quot;</em> - <a class="donor" href="/profile/space">space</a></li>
<li><span class="dodate">31.Oct.2018</span> - <em>&quot;coding , a neverending dream greetz to All :-*&quot;</em> – <a class="donor" href="/profile/occasus">occasus</a></li>
<li>----- 2019 -----</li>
<li><span class="dodate">25.Feb.2019</span> – <em>&quot;Is this enough for "Stalking"?&quot;</em> – ???</li>
<li><span class="dodate">25.Feb.2019</span> – <em>&quot;No!<img src="img/default/smile/tongue.png" />&quot;</em> – <a class="donor" href="/profile/tehron">tehron</a></li>
<li><span class="dodate">6.May.2019</span> – <em>&quot;Be excellent to eachother.&quot;</em> – <a class="donor" href="/profile/tweg">tweg</a></li>
<li><span class="dodate">29.Jun.2019</span> – <em>&quot;Thanks a lot for this website, and all the great work maintaining it!&quot;</em> – <a class="donor" href="/profile/kkaosninja">kkaosninja</a></li>
<li><span class="dodate">20.Oct.2019</span> – <span class="nomsg"></span> – <span class="unknownuser"></span></li>
<li><span class="dodate">7.Nov.2019</span> – <span class="nomsg"></span> – <a class="donor" href="/profile/flabbyrabbit">flabbyrabbit</a></li>
<li><span class="dodate">21.Dec.2019</span> – <em>&quot;This is fun. Thanks.&quot;</em> – <a class="donor" href="/profile/sutaburosu">sutaburosu</a></li>
<li>----- 2020 -----</li>
<li><span class="dodate">19.Aug.2020</span> – <em>&quot;love this it-world. . . greetings to all Challengers love you all.&quot;</em> – <a class="donor" href="/profile/occasus">occasus</a></li>
<li><span class="dodate">25.Aug.2020</span> – <em>&quot; --- &quot;</em> – ???</li>
<li>----- 2021 -----</li>
<li><span class="dodate">18.Jan.2021</span> – <em>&quot;Was? Ich hab' mich nur verdrückt!&quot;</em> – ???</li>
<li><span class="dodate">24.Jan.2021</span> – <em>&quot;help to support the site&quot;</em> – <a class="donor" href="/profile/spnow">spnow</a></li>
<li><span class="dodate">15.Apr.2021</span> – <em>&quot;for future generations&quot;</em> – <a class="donor" href="/profile/maraud3r">maraud3r</a></li>

</ol>
</div>

<div class="box">
<h2>Hall of purchased Gods</h2>
<ol>
<li>----- 2018 -----</li>
<li>9.Nov.2018 - someone donated €5 as a monthly payment. (unlimited money, we just have to wait) ca. €140 so far.</li>
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
