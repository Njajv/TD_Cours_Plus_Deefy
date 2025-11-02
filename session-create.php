<?php

const SESSION_COUNTER = 'session_counter';

$value = $_GET['value'] ?? null;
session_start();

if (!isset($_SESSION[SESSION_COUNTER])) {
    $_SESSION[SESSION_COUNTER] = $value ?: 0;
}

if ($value) {
    $_SESSION[SESSION_COUNTER] += $value;
} else {
    $_SESSION[SESSION_COUNTER]++;
}