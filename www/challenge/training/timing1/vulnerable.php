<?php
#########################
### ALL VULNERABLE?!? ###
#########################
$answer = (string)@$_POST['answer'];
$password = require 'password.php';

# Check password
return utf8_stringCompare($password, $answer);

###########
### Lib ###
###########
/**
 * UTF-8 string comparison method.
 * Why is there no mb_strcmp() function?
 * 
 * @version 0.2
 * @author gizmore
 * 
 * @todo return distance between those two strings for sorting.
 * @todo return true on same glyphs but different codepoints by normalizing the strings first.
 * 
 * @param string $a
 * @param string $b
 * @return boolean
 */
function utf8_stringCompare($a, $b)
{
    # If length is not the same we can return false early.
    $len_a = mb_strlen($a);
    $len_b = mb_strlen($b);
    if ($len_a !== $len_b)
    {
        return false;
    }
    
    # We have to check further!
    for ($i = 0; $i < $len_a; $i++)
    {
        # Next char
        $char_a = mb_substr($a, $i, 1);
        $char_b = mb_substr($b, $i, 1);
        
        # Compare
        if ($char_a !== $char_b)
        {
            return false; # Char $i mismatched
        }
        
        continue; # Char $i matched
    }
    
    return true; # The strings are the same
}
