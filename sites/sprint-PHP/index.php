<?php
session_start();
require_once './utils/auth.php';
require_once './utils/functions.php';

$template = './template/index.phtml';
include_once './template/layout.phtml';