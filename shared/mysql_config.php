<?php

$conf_mysql_host = getenv('CONF_MYSQL_HOST') !== false ? getenv('CONF_MYSQL_HOST') : "localhost";
$conf_mysql_login = getenv('CONF_MYSQL_LOGIN') !== false ? getenv('CONF_MYSQL_LOGIN') : "";
$conf_mysql_pass = getenv('CONF_MYSQL_PASS') !== false ? getenv('CONF_MYSQL_PASS') : "";
$conf_mysql_db = getenv('CONF_MYSQL_DB') !== false ? getenv('CONF_MYSQL_DB') : "";
$conf_mysql_conf_ok = ($conf_mysql_login !== "" && $conf_mysql_pass !== "" && $conf_mysql_db !== "") ? "yes" : "no";

?>
