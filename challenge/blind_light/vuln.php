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
	if (false === ($db = gdo_db_instance('localhost', BLIGHT_USER, BLIGHT_PASS, BLIGHT_DB)))
	{
		die('Cannot connect to db!');
	}
	$db->setVerbose(false);
	$db->setLogging(false);
	$db->setEMailOnError(false);
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
function blightVuln($password)
{
	# 1 attemp gone.
	blightCountUp();
	
	$db = blightDB();
	$sessid = GWF_Session::getSession()->getID();
	$query = "SELECT 1 FROM blight WHERE sessid=$sessid AND password='$password'";
	return $db->queryFirst($query) !== false;
}


#####################
### Not vuln util ###
#####################
/**
 * Increase the attemp counter.
 * @return true|false
 */
function blightCountUp()
{
	$db = blightDB();
	$sessid = GWF_Session::getSession()->getID();
	$query = "UPDATE blight SET attemp=attemp+1 WHERE sessid=$sessid";
	return $db->queryWrite($query);
}

/**
 * Reset counter and password.
 * @return true|false
 */
function blightReset()
{
	$db = blightDB();
	$sessid = GWF_Session::getSession()->getID();
	$hash = Common::randomKey(32, 'ABCDEF0123456789');
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
	$sessid = GWF_Session::getSession()->getID();
	$query = "SELECT attemp FROM blight WHERE sessid=$sessid";
	if (false === ($result = $db->queryFirst($query))) {
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
	$sessid = GWF_Session::getSession()->getID();
	$query = "SELECT password FROM blight WHERE sessid=$sessid";
	if (false === ($result = $db->queryFirst($query))) {
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
		blightReset();
	}
}

?>
