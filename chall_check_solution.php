<?php
if (false !== (Common::getPost('solve'))) {
	$chall->onSolve(GWF_Session::getUser(), Common::getPost('answer'));
}
?>
