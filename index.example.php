<?php

/**
 * This is an example how your index.php could look like
 */
require_once 'gwf3.class.php';
$gwf = new GWF3(__DIR__, GWF3::CONFIG);

# Display Page
echo $gwf->onDisplayPage();

# Commit Session
$gwf->onSessionCommit();