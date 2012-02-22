<?php
function guessLanguage($sourcecode) {
    $score = 0;
    $max_score = 5;
    $lang = 'text';
 
    $score = isPerlCode($sourcecode);
    if ($score > $max_score) {
        $max_score = $score;
        $lang = 'perl';
    } 
    $score = isPHPCode($sourcecode);
    if ($score > $max_score) {
        $max_score = $score;
        $lang = 'php';
    }
 
    $score = isHTMLCode($sourcecode);
    if ($score > $max_score) {
        $max_score = $score;
        $lang = 'html4strict';
    }
 
    $score = isJavaCode($sourcecode);
    if ($score > $max_score) {
        $max_score = $score;
        $lang = 'java';
    }
 
    $score = isCppCode($sourcecode);
    if ($score > $max_score) {
        $max_score = $score;
        $lang =  'Cpp';
    }
 
    $score = isCCode($sourcecode);
    if ($score > $max_score) {
        $max_score = $score;
        $lang = 'c';
    } 
    $score = isPrologCode($sourcecode);
    if ($score > $max_score) {
        $max_score = $score;
        $lang =  'prolog';
    }
 
    // echo "Lang: $lang Score: $score";
    return $lang;
} 
function isPerlCode($sourcecode) {
    $score = 0;
 
    $pattern = '/#!\/usr\/bin\/perl\s.*/i';
    $points = 6;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/\s*use\s+?\w*?\:*?:*?\w*?;*?/i';
    $points = 4;    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/.*\ssub\s.*/i';
    $points = 2;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/.*\suntil\s.*/i';
    $points = 2;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
     $pattern = '/.*\sunless\s.*/i';
    $points = 2;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/.*\slast\s.*/i';
    $points = 2;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/.*\snext\s.*/i';
    $points = 2;    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/.*\sredo\s.*/i';
    $points = 3;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/#!\/usr\/bin\/perl\s.*/i';
    $points = 6;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
     return $score;
}
 
function isPHPCode($sourcecode) {
    $score = 0;
 
    $pattern = '/<\?php/i';
    $points = 6;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
     $pattern = '/strrpos/i';
    $points = 4;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/while/i';
    $points = 1;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/print/i';
    $points = 1;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/\$/i';
    $points = 1;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/echo/i';
    $points = 1;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
     return $score;
}
 
function isPrologCode($sourcecode) {
    $score = 0;
    
    $pattern = '/\s*%(.)*\n/';
    $points = 1;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
     $pattern = '/[_a-z0-9\[\]]+\s*\(\s*[_a-z0-9\[\]]+\s*(,\s*[_a-z0-9\[\]]+\s*)*\)\s*\./i';
    $points = 2;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
    
    $pattern = '/\s*[_a-z0-9\[\]]+\s*\(\s*[_a-z0-9\[\]]+\s*(,\s*[_a-z0-9\[\]]+\s*)*\)\s*:-[_a-z0-9\[\]]+\s*\(\s*[_a-z0-9\[\]]+\s*(,\s*[_a-z0-9\[\]]+\s*)*\)\s*(%.*\n)?/i';
    $points = 4;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
    return $score;
}
  
function isHTMLCode($sourcecode) {
    $score = 0;
 
    $pattern = '/<html>/';
    $points = 6;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/<body>/';
    $points = 6;    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/<a href/';
    $points = 6;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/<div/';
    $points = 3;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
     $pattern = '/<table/';
    $points = 6;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/<br/';
    $points = 6;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    return $score;
} 
function isJavaCode($sourcecode) {
    $score = 0;
 
    $pattern = '/import java/';
    $points = 6;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/public static void/';
    $points = 2;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/class/';
    $points = 2;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/implements/';
    $points = 2;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
     $pattern = '/extends/';
    $points = 2;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/interface/';
    $points = 2;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    return $score;
} 
function isCppCode($sourcecode) {
    return 0;
}
 
function isCCode($sourcecode) {
    $score = 0;
 
    $pattern = '/#include\s+</i';
    $points = 6;    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    $pattern = '/#define\s+/i';
    $points = 6;
    if (preg_match_all($pattern, $sourcecode, $matches)) $score += sizeof($matches[0])*$points;
 
    return $score;
}
