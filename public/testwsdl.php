<?php
//phpinfo();
$wsdl = file_get_contents('http://187.216.144.153:8080/WSCurp/ConsultaCurp.asmx?WSDL');
echo $wsdl;


