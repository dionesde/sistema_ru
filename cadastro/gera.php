<?php
#header('Content-Description: File Transfer');
#header('Content-Disposition: attachment; filename="dhcpd.conf"');
#header('Content-type: text/plain');
#header('Content-Transfer-Encoding: binary');
#header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
#header('Pragma: public');
#header('Expires: 0');
$texto='';
$texto.="ddns-update-style none;\n";
$texto.= "default-lease-time 14400;\n";
$texto.= "max-lease-time 15000;\n\n";
$texto.= "";
$texto.= "authoritative;\n\n";
$texto.="";
$texto.= "#range 200.132.200.20 200.132.200.254;\n";
$texto.= "subnet 200.132.200.0 netmask 255.255.255.0 {\n";
$texto.= "option routers 200.132.200.1;\n";
$texto.= "option domain-name-servers 200.18.33.18,200.18.33.19;\n";
$texto.= "option broadcast-address 200.132.200.255;\n\n";

$texto.= "# host exemplo\n";

$con = mysql_connect("127.0.0.1", "root", "ufsmcs") or die ("Sem conexão com o servidor");
$select = mysql_select_db("rede",$con) or die("Sem acesso ao DB, Entre em contato com o Administrador,diones.de@redes.ufsm.br");

$sql = "SELECT * FROM `maquina` WHERE 1 order by id DESC";
$result = mysql_query($sql,$con);


if (mysql_num_rows($result) != 0) {
    // output data of each row
    while($row = mysql_fetch_assoc($result)) {
        $texto.= "host " . $row["host"]. "{hardware ethernet " . $row["mac"]. ";fixed-address ".$row['ip'].";}\n";
    }
} 



$texto.= "}\n";
$url = "http://200.132.200.1/dhcp.php";
		
		$cURL = curl_init();
		curl_setopt($cURL, CURLOPT_URL, $url);
		curl_setopt($cURL, CURLOPT_AUTOREFERER, true);
		curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($cURL, CURLOPT_POST, true);
		curl_setopt($cURL, CURLOPT_TIMEOUT, 20);
		curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($cURL, CURLOPT_HEADER, false);
		
		$dados = array(
			"texto" => $texto
		);
		
		curl_setopt($cURL, CURLOPT_POSTFIELDS, $dados);
	    	$saida=curl_exec($cURL);
		curl_close($cURL);
		echo $saida;
?>
