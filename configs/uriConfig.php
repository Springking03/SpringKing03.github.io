<?php
const BASE_URL = 'http://localhost/Vidental';
//const BASE_URL = 'https://CentBeauty.000webhostapp.com';


const NOT_FOUND_URL = BASE_URL . '/index.php?controller=home&action=not_found';
const UNAUTHORIZED_URL =  BASE_URL .'/index.php?controller=home&action=unauthorized';

const LOGIN_CLIENT_URL = BASE_URL .'/index.php?controller=auth&action=login';
const PROCESS_LOGIN_CLIENT_URL = BASE_URL .'/index.php?controller=auth&action=processLoginClient';
const LOGIN_ADMIN_URL = BASE_URL .'/index.php?controller=auth&action=loginAdmin';

const REGISTER_URL = BASE_URL .'/index.php?controller=register&action=register';
const HOME_CLIENT_URL = BASE_URL .'/index.php?controller=home&action=home';
const HOME_ADMIN_URL = BASE_URL .'/index.php?controller=home&action=home_admin';
const FORGOT_URL = BASE_URL .'/index.php?controller=auth&action=confirm_phone';
?>
