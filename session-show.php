<?php

session_start();
const SESSION_COUNTER = 'session_counter';
$sessionCounter = $_SESSION[SESSION_COUNTER];

echo $sessionCounter;