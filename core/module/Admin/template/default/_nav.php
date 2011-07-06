<div class="gwf_buttons_outer">
<div class="gwf_buttons">
<?php
foreach ($tVars['buttons'] as $btn)
{
	echo GWF_Button::generic($btn[1], $btn[0], 'generic', '', $btn[2]);
}	
?>
</div>
</div>