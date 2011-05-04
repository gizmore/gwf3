<?php
if (false !== $tVars['reply_to']) {
	echo $tVars['reply_to'];
}

if (isset($tVars['preview'])) {
	echo $tVars['preview'];
}

echo $tVars['form'];
?>
