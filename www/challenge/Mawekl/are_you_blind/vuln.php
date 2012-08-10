<?php
########################
### Not vuln install ###
########################
/**
 * Get the database object.
 * @return GDO_Database
 */
function blightDB()
{
	static $db;
	if (!isset($db))
	{
		if (false === ($db = gdo_db_instance('localhost', BLIGHT4_USER, BLIGHT4_PASS, BLIGHT4_DB)))
		{
			die('Cannot connect to db!');
		}
		$db->setVerbose(false);
		$db->setLogging(false);
		$db->setEMailOnError(false);
		$db->setDieOnError(false);
	}
	return $db;
}

/**
 * Create the database table.
 * @return true|false
 */
function blightInstall()
{
	$db = blightDB();
	$query =
		"CREATE TABLE IF NOT EXISTS blight (".
		"sessid INT(11) UNSIGNED PRIMARY KEY NOT NULL, ".
		"password CHAR(32) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL, ".
		"attemp INT(11) UNSIGNED NOT NULL DEFAULT 0 ".
		") ENGINE=myISAM";
	return $db->queryWrite($query);
}


##################
### VULNERABLE ###
##################
/**
 * The vulnerable login function.
 * @param string $password The unescaped string :O
 * @return true|false
 */
function blightVuln(WC_Challenge $chall, $password, $attempt)
{
	# Do not mess with other sessions!
	if ( (strpos($password, '/*') !== false) || (stripos($password, 'blight') !== false) )
	{
		return $chall->lang('mawekl_blinds_you', array($attempt));
	}
	
	# And please, no timing attempts!
	if ( (stripos($password, 'benchmark') !== false) || (stripos($password, 'sleep') !== false) )
	{
		return $chall->lang('mawekl_blinds_you', array($attempt));
	}
		
	$db = blightDB();
	$sessid = GWF_Session::getSessSID();
	$query = "SELECT 1 FROM (SELECT password FROM blight WHERE sessid=$sessid) b WHERE password='$password'";
	return $db->queryFirst($query) ? 
		$chall->lang('mawekl_blinds_you', array($attempt)) :
		$chall->lang('mawekl_blinds_you', array($attempt)) ;
}


#####################
### Not vuln util ###
#####################
/**
 * Increase the attempt counter.
 * @return true|false
 */
function blightCountUp()
{
	$db = blightDB();
	$sessid = GWF_Session::getSessSID();
	$query = "UPDATE blight SET attemp=attemp+1 WHERE sessid=$sessid";
	return $db->queryWrite($query);
}

/**
 * Set the attempt counter.
 * @return true|false
 */
function blightSetAttempt($attempt)
{
	$db = blightDB();
	$attempt = (int)$attempt;
	$sessid = GWF_Session::getSessSID();
	$query = "UPDATE blight SET attemp=$attempt WHERE sessid=$sessid";
	return $db->queryWrite($query);
}

/**
 * Reset counter and password.
 * @return true|false
 */
function blightReset($consec=true)
{
	if ($consec)
	{
		# Reset consecutive success counter.
		blightFailed();
	}
	
	# Take a timestamp.
	GWF_Session::set('BLIGHT4_TIME_START', time());
	
	# Generate a new hash.
	$db = blightDB();
	$sessid = GWF_Session::getSessSID();
	$hash = GWF_Random::randomKey(32, 'ABCDEF0123456789');
	$query = "REPLACE INTO blight VALUES($sessid, '$hash', 0)";
	return $db->queryWrite($query);
}

/**
 * Get the attemp counter.
 * @return int
 */
function blightAttemp()
{
	$db = blightDB();
	$sessid = GWF_Session::getSessSID();
	$query = "SELECT attemp FROM blight WHERE sessid=$sessid";
	if (false === ($result = $db->queryFirst($query)))
	{
		return -1;
	}
	return (int)$result['attemp'];
}

/**
 * Get the correct solution.
 * This counts as one attemp.
 * @return string|false
 */
function blightGetHash()
{
	blightCountUp(); # 1 attemp
	
	$db = blightDB();
	$sessid = GWF_Session::getSessSID();
	$query = "SELECT password FROM blight WHERE sessid=$sessid";
	if (false === ($result = $db->queryFirst($query)))
	{
		return false;
	}
	return $result['password'];
}

/**
 * Init the challenge.
 * @return void
 */
function blightInit()
{
	$attemp = blightAttemp();
	if ($attemp < 0)
	{
		blightReset(false);
	}
}

###########
### NEW ###
###########
/**
 * You successfully hacked it one time.
 * But return false if you need a few more consecutive hacks to solve the chall.
 * @return true|false
 */
function blightSolved()
{
	$solvecount = GWF_Session::getOrDefault('BLIGHT4_CONSECUTIVE', 0);
	$solvecount++;
	
	blightReset(false);
	
	if ($solvecount >= BLIGHT4_CONSEC)
	{
		GWF_Session::remove('BLIGHT4_CONSECUTIVE');
		return true;
	}
	
	GWF_Session::set('BLIGHT4_CONSECUTIVE', $solvecount);
	return false;
}

/**
 * Reset consecutive success counter.
 * @return void
 */
function blightFailed()
{
	GWF_Session::set('BLIGHT4_CONSECUTIVE', 0);
}

/**
 * Check if you were too slow.
 * @return true|false
 */
function blightTimeout()
{
	if (false === ($start = GWF_Session::getOrDefault('BLIGHT4_TIME_START', false)))
	{
		return true;
	}
	else
	{
		return (time() - $start) > BLIGHT4_TIME;
	}
}
?>
