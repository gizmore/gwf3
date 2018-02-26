<?php
/**
 * Base class to push notifications to the notification server
 * @author dloser
 */
class GWF_PushNotification
{
	// should be made configurable at some point
	const SERVER_HOST = 'localhost';
	const SERVER_PORT = 12354;

	/**
	 * Core push functionality. Call with event as PHP array.
	 */
	public static function push($notification)
	{
		$socket = NULL;

		try
		{
			$msg = json_encode($notification) . "\n";

			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if ($socket === false)
			{
				return;
			}

			if (!@socket_connect($socket, 'localhost', 12354))
			{
				return;
			}

			socket_write($socket, $msg);

		} catch (Exception $e) {
			// ignore
		}

		// finally (but not for PHP 5.3...)
		if ($socket !== NULL)
		{
			socket_close($socket);
		}
	}
}
