<?php
session_start();
require_once './utils/auth.php';
require_once './utils/functions.php';
logout();
redirect('index.php');