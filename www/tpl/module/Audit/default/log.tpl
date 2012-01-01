<div>Log from {$log->display('al_eusername') - {$log->display('al_username')}}</div>
<div>Started Recording at {$log->getVar('al_time_start')|timestamp}</div>
<pre>
{$log->getVar('al_data')|htmlspecialchars}
</pre>
