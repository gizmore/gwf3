<?php
$name = $user->displayUsername();
$text = "Hello {$name}. Solution: {$flag}";
$numbers = array_map(function($char) {
	return (string) ord($char);
}, str_split($text));
return implode(' ', $numbers);

