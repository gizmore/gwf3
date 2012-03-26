{*{assign var="month" val="$SF->langA('monthnames', date('n'))"}
{array( $SF->langA('daynames', date('w')), date('w'), $month, date('n'), date('Y')))}|*}
<pre class="logo" id="shell_logo">
    .--.      _____________________________________________________________
   |o_o |    /    WELCOME TO       {$SF->lang(SF::greeting())}                            \
   |:_/ | --&lt;|       WWW.FLORIAN     {$SF->lang('today_is_the', array( $SF->langA('daynames', date('w')), date('w'), $SF->langA('monthnames', date('n')), date('n'), date('Y')))}|
  //   \ \   \           BEST.DE !!!  Es ist {date('G:i:s')} Uhr                   /
 (|     | )   --------------------------------------------------------------
/'\_   _/`\ type in ´help´ for
\___)=(___/  a list of commands!
</pre>
