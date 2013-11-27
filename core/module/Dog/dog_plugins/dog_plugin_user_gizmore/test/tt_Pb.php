<?php
Dog::getWorker()->async('call', array('trim', array('..slap gizmore..', '.')), array('Dog','processFakeMessage'));
// Dog::getWorker()->async_function('trim', array('xxslap petexx', 'x'), array('Dog','processFakeMessage'));
// Dog::getWorker()->async_method('Common', 'regex', array('/(slap \w+)/', 'xxslap horst'), array('Dog','processFakeMessage'));
