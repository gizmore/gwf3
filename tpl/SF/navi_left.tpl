				<p class="top" style="background-image: url('/templates/{$smarty.const.GWF_DEFAULT_DESIGN}/{$settings['template']['layout']}/images/navilefthead.png');">
					[+]
				</p><hr>
{SF_Website::display_navigation('left')}
				<hr><p class="bottom"> {*
					<span id="counter">
					{strtoupper($lang->lang('visitor'))}<br>
					Online: {$gwff->module_Heart_beat()}<br>
					{$lang->lang('ct_vis_total')}: <br>
					{$lang->lang('ct_vis_today')}: <br>
					{$lang->lang('ct_vis_yesterday')}: <br>
					{$lang->lang('ct_online_today')}: <br>
					{$lang->lang('ct_online_total')}: <br>
					Tagesrekord:<br>
					Onlinerekord:<br>
					</span> *}
				</p>