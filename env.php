<?php
const db_host = 'localhost';
const db_name = 'api_rest';
const userName = 'root';
const password = "";
const db_charset = 'utf8';

const BASE_URL = "http://api_data.pro/";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=Utf8");
header('Access-Control-Allow-Methods:GET, POST, PATCH, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With, X-Auth-Toke, Origin");
