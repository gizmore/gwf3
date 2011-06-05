				<p class="top" style="background-image: url('/templates/{$SF->design()}/{$SF->layout()}/images/navilefthead.png');">
					[+]
				</p><hr>
{SF_Website::display_navigation('left')}
				<hr><p class="bottom"> {*
					<span id="counter">
					{strtoupper($SF->lang('visitor'))}<br>
					Online: {$gwff->module_Heart_beat()}<br>
					{$SF->lang('ct_vis_total')}: <br>
					{$SF->lang('ct_vis_today')}: <br>
					{$SF->lang('ct_vis_yesterday')}: <br>
					{$SF->lang('ct_online_today')}: <br>
					{$SF->lang('ct_online_total')}: <br>
					Tagesrekord:<br>
					Onlinerekord:<br>
					</span> *}
				</p>