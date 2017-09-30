<?php
echo '<div class="gwf_buttons_outer">'.PHP_EOL;
echo '<div class="gwf_buttons">'.PHP_EOL;
echo GWF_Button::forward($tVars['href_update_all'], $tLang->lang('btn_update_all'));
echo GWF_Button::user($tVars['href_update_one'], $tLang->lang('btn_update_one'));
echo '</div>'.PHP_EOL;
echo '</div>'.PHP_EOL;

echo GWF_Button::generic($tLang->lang('btn_edit_site_descr'), $tVars['href_edit_descr']);
echo GWF_Button::generic($tLang->lang('btn_warboxes'), $tVars['href_edit_boxes']);
//echo sprintf('<');

echo $tVars['form'];
echo $tVars['form_logo'];
echo $tVars['form_site_admin'];
// Quick way to allow API testing
if (false !== ($user = GWF_Session::getUser()) && $user->isAdmin())
{
$api_test_default_user = $user->getVar('user_name');
$api_test_default_mail = $user->getVar('user_email');
?>
<div class="gwf_form">
<table>
<thead>
<tr><th colspan="2">Test API</th></tr>
</thead>
<tbody>
<tr><td>Site URL</td><td><input id="api_test_url" value="<?=htmlspecialchars($tVars['site']->getVar('site_url'))?>"></td></tr>
<tr><td>Mail URL Template</td><td><input id="api_test_murl" value="<?=htmlspecialchars($tVars['site']->getVar('site_url_mail'))?>"></td></tr>
<tr><td>Score URL Template</td><td><input id="api_test_surl" value="<?=htmlspecialchars($tVars['site']->getVar('site_url_score'))?>"></td></tr>
<tr><td>Authkey</td><td><input id="api_test_authkey" value="<?=htmlspecialchars($tVars['site']->getVar('site_xauthkey'))?>"></td></tr>
<tr><td>Username</td><td><input id="api_test_username" value="<?=htmlspecialchars($api_test_default_user)?>"></td></tr>
<tr><td>E-Mail</td><td><input id="api_test_email" value="<?=htmlspecialchars($api_test_default_mail)?>"></td></tr>
<tr><td colspan="2" style="text-align: left;">
<br>
<?php
echo GWF_Button::generic('Test Mail URL','javascript:api_test_mail();');
echo GWF_Button::generic('Test Score URL','javascript:api_test_score();');
?>
<br><br>
Output:<br>
<textarea id="api_test_output">
</textarea>
</td></tr>
</tbody>
</table>
<script>
var api_test_token = '<?=GWF_CSRF::generateToken('apt_test_token')?>';
function api_test_url(template)
{
  $('#api_test_output').val('Waiting for reply...');
  $.post(GWF_WEB_ROOT+'index.php?mo=WeChall&me=ApiTest&ajax=1',{
      gwf3_csrf: api_test_token,
      base: $('#api_test_url').val(),
      template: template,
      authkey: $('#api_test_authkey').val(),
      username: $('#api_test_username').val(),
      email: $('#api_test_email').val(),
    }, function (data) {
      try {
        jdata = $.parseJSON(data);
        api_test_token = jdata.token;
        info = '';
        if (jdata.url)
        {
          info += 'URL: ' + jdata.url + '\n\n';
        }
        if (jdata.error)
        {
          info += 'Error: ' + jdata.error + '\n\n';
        }
        if (jdata.response)
        {
          info += jdata.response;
        }
        $('#api_test_output').val(info);
      } catch (err) {
        $('#api_test_output').val('Error: '+err+'\n\n'+data);
      }
    }).fail(function() {
      $('#api_test_output').val('Error!');
    });
}
function api_test_mail()
{
  api_test_url($('#api_test_murl').val());
}
function api_test_score()
{
  api_test_url($('#api_test_surl').val());
}
</script>
</div>
<?php
}
?>
