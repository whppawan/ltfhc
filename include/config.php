<?php
define('PRFX1', 'master_');
define('PRFX2', 'config_');
//define('TBL1', 'admin');
define('TBL1', PRFX1.'user');
define('TBL2', 'hcw');
define('TBL3', 'patient');
define('TBL4', 'patient_opd');
define('TBL5', PRFX1.'health_zone');
define('TBL6', PRFX1.'health_area');
define('TBL7', PRFX1.'investigation');
define('TBL8', PRFX1.'treatment');
define('TBL9', PRFX1.'outcome');
define('TBL10', 'symptom');
define('TBL11', 'diagnosis');
define('TBL12', 'investigation');
define('TBL13', 'treatment');
define('TBL14', 'outcome');
define('TBL15', 'config_screen');
define('TBL16', 'config_layout');
define('TBL17', 'config_component');
define('TBL18', 'patient_detail');
define('TBL19', PRFX1.'user_type');
define('TBL66', PRFX2.'roles');
define('TBL67', PRFX1.'modules');
define('TBL68', PRFX2.'roles_permissions'); 
define('TBL69', PRFX2.'content_language'); 

define('PAGE1', 'index');
define('PAGE2', 'home');
define('PAGE3', 'header');
define('PAGE4', 'footer');
define('PAGE5', 'left_pannel');
define('PAGE6', 'connection');
define('PAGE7', 'login');
define('PAGE8', 'screen');
define('PAGE9', 'layout');
define('PAGE10', 'component');
define('PAGE11', 'user');
define('PAGE12', 'role');
define('PAGE13', 'health_zone');
define('PAGE14', 'health_area');
  
define('APPLICATION_ID', 'ltfhcdynamic');
define('APPLICATION_NAME', 'ltfhcdynamic');

define('LOGIN_SESSION_TIME', 5-1);
define('SESSION_PATH', 'session/');
define('LOGIN_SESSION_PATH', 'session/login/');

define('ENC_STRING', 'WHP encryption');

define('URL', (isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST']."/");

date_default_timezone_set("Asia/Kolkata");
?>
