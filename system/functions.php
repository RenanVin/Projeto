<?php
	
	function dadosAdmin($campo)
	{
		$sql = mysql_query("SELECT $campo FROM sys_admin");
		$ln  = mysql_fetch_object($sql);

		if($ln->$campo == true)
		{
			return $ln->$campo;
		}
		else
		{
			return "Campo $campo nao encontrado.";
		}
	}

	function sweetAlert($title, $msg, $type, $btnText = 'Fechar')
	{
		if($type == "error")
		{
			$btnColor = "#F27474";
		}
		elseif($type == "success")
		{
			$btnColor = "#A5DC86";
		}
		elseif($type == "warning")
		{
			$btnColor = "#F8C086";
		}
		elseif($type == "info")
		{
			$btnColor = "#C9DAE1";
		}

		return '
			<script>
				swal({
					title : "'.$title.'",
					html  : "'.$msg.'",
					type  : "'.$type.'",   
					confirmButtonColor : "'.$btnColor.'",   
					confirmButtonText  :  "'.$btnText.'",   
					}, 
					function(){ 
						swal.close;
					});
			</script>
		';
	}

	function sweetOptions($title, $msg, $type, $funcBtn, $funcBtn2)
	{

		if($type == "error")
		{
			$btnColor = "#F27474";
		}
		elseif($type == "success")
		{
			$btnColor = "#A5DC86";
		}
		elseif($type == "warning")
		{
			$btnColor = "#F8C086";
		}
		elseif($type == "info")
		{
			$btnColor = "#C9DAE1";
		}

		return '
		<script>
			swal({
				title : "'.$title.'",
				html  : "'.$msg.'",
				type  : "'.$type.'",
				showCancelButton   : true,
				confirmButtonColor : "'.$funcBtn[0].'",
				cancelButtonColor  : "'.$funcBtn2[0].'",
				confirmButtonText  : "'.$funcBtn[1].'",
				cancelButtonText   : "'.$funcBtn2[1].'",
				confirmButtonClass : "confirm-class",
				cancelButtonClass  : "cancel-class",
				closeOnConfirm     : false,
				closeOnCancel      : false
			},
			function(isConfirm) {
				if(isConfirm)
				{
					'.$funcBtn[2].'
				}
				else
				{
					'.$funcBtn2[2].'
				}
			});
		</script>
		';
	}

	function jsScript($content)
	{
		return '
			<script>
				'.$content.'
			</script>
		';
	}

	function sweetRedir($title, $msg, $type, $url, $btnText = 'Continuar')
	{
		
		if($type == "error")
		{
			$btnColor = "#F27474";
		}
		elseif($type == "success")
		{
			$btnColor = "#A5DC86";
		}
		elseif($type == "warning")
		{
			$btnColor = "#F8BssF86";
		}
		elseif($type == "info")
		{
			$btnColor = "#C9DAE1";
		}
		else
		{
			$btnColor = "#888888";
		}

		return '
		<script>
			swal({
				title : "'.$title.'",
				html  : "'.$msg.'",
				type  : "'.$type.'",   
				confirmButtonColor : "'.$btnColor.'",   
				confirmButtonText  :  "'.$btnText.'",   
				}, 
				function(){ 
					location.href="'.$url.'";
				});
		</script>
		';
	}

	function jsRedir($url)
	{
		echo '<script>location.href="'.$url.'"</script>';
	}

	function redirPHP($url)
	{
		ob_start();
		header("Location: $url");
	}

	function noInject($campo, $adicionaBarras = false)
	{
		$campo = preg_replace("/(from|alter table|select|insert|delete|update|where|drop table|show tables|#|\*|--|\\\\)/i","",$campo);
		$campo = trim($campo);
		$campo = strip_tags($campo);
			if($adicionaBarras || !get_magic_quotes_gpc())
				$campo = addslashes($campo);
				return $campo;
	}

	function limitarParagrafos($str, $limit = 1) {
		$textoChamada = explode('<p>', $str);
		$textoChamada = explode('<br />', $textoChamada[0]);
		$parafs = array();

		for($i=1; $i<=$limit; $i++){
			$parafs[] = strip_tags($textoChamada[$i-1]);
		}

		
		return implode('<br>', $parafs);
	}

	function upper($p){
		$p = strtr($p, "áàãâéêíóôõúüç; ", "ÁÀÃÂÉÊÍÓÔÕÚÜÇ");
		$p = strtoupper($p);
		return $p;
	}

	/* LOWERCASE RÁPIDO*/
	function lower($p){
		$p = strtr($p, "ÁÀÃÂÉÊÍÓÔÕÚÜÇ", "áàãâéêíóôõúüç; ");
		$p = strtolower($p);
		return $p;
	}

	function youtubeID($url)
	{
		$pattern = '#^(?:https?://|//)?(?:www\.|m\.)?(?:youtu\.be/|youtube\.com/(?:embed/|v/|watch\?v=|watch\?.+&v=))([\w-]{11})(?![\w-])#';
		preg_match($pattern, $url, $matches);
		return (isset($matches[1])) ? $matches[1] : false;
	}

	function getSys($tipo)
	{
		return select("sys_settings", "valor", "WHERE tipo = '$tipo'");
	}

	// Obtem as dimensões da imagem
	function getImageDimens($pathFile, $type)
	{
		$size  = getimagesize($pathFile);

		if($type == "largura")
		{
			return $size[0];
		}
		else
		{
			return $size[1];
		}
	}

	function onlineSystem()
	{
		$chave = getSys("siteStatus");

		if($chave == 2 and router(0) == "liberar")
		{
			$_SESSION["siteLiberado"] = 1;
			header("Location: ".CP);
			exit;
		}
		else
		{
			if($chave == 2 and @$_SESSION["siteLiberado"] == false)
			{
				header("Location: manutencao");
				exit;
			}
		}
	}

	function insertDevice()
	{
		$detect = new Mobile_Detect;

		// 1 = Computador | 2 = Mobile/Tablet
		$device = ($detect->isMobile()) ? '2' : '1';

		$sql    = mysql_query("SELECT COUNT(*) FROM sys_device WHERE data = CURDATE() AND device = '$device'");
		$result = mysql_fetch_row($sql);

		$nova = (!isset($_SESSION['ContadorDevice'])) ? true : false;

		if($result[0] == 0)
		{
			insert(
				array("device", "data", "visitas"),
				array($device, date("Y-m-d"), 1),
				"sys_device"
				);
		}
		else
		{
			if($nova == true)
			{
				mysql_query("UPDATE sys_device SET visitas = (visitas+1) WHERE data = CURDATE() AND device = '$device'");
			}
		}

		$_SESSION['ContadorDevice'] = md5(time());
	}

	function insertVisitor()
	{
		$sql = "SELECT COUNT(*) FROM sys_visitors WHERE `data` = CURDATE()";
		$query = mysql_query($sql);
		$resultado = mysql_fetch_row($query);

		// Verifica se é uma visita (do visitante)
		$nova = (!isset($_SESSION['ContadorVisitas'])) ? true : false;

		// Verifica se já existe registro para o dia
		if($resultado[0] == 0)
		{
			$sql = "INSERT INTO sys_visitors (uniques, data) VALUES (1, CURDATE())";
		}
		else
		{
			if ($nova == true)
			{
				$sql = "UPDATE sys_visitors SET `uniques` = (`uniques` + 1) WHERE `data` = CURDATE()";
			}
		}
		// Registra a visita
		mysql_query($sql);

		// Cria uma variavel na sessão
		$_SESSION['ContadorVisitas'] = md5(time());
	}

	// function showVisitors($tipo = 'uniques', $periodo = 'hoje')
	//  {
	// 	global $_CV;

	// 	switch($tipo)
	// 	{
	// 		default:
	// 		case 'uniques':
	// 			$campo = 'uniques';
	// 			break;
	// 		case 'pageviews':
	// 			$campo = 'pageviews';
	// 			break;
	// 	}

	// 	switch($periodo)
	// 	{
	// 		default:
	// 		case 'hoje':
	// 			$busca = "`data` = CURDATE()";
	// 			break;
	// 			break;
	// 		case 'mes':
	// 			$busca = "`data` BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())";
	// 			break;
	// 		case 'ano':
	// 			$busca = "`data` BETWEEN DATE_FORMAT(CURDATE(), '%Y-01-01') AND DATE_FORMAT(CURDATE(), '%Y-12-31')";
	// 			break;
	// 	}

	// 	// Faz a consulta no MySQL em função dos argumentos
	// 	if ($periodo == "ontem")
	// 	{
	// 		$sql = "SELECT $campo FROM sys_visitors WHERE `data` = '".date('Y-m-d', strtotime("-1 days"))."'";
	// 	}
	// 	elseif ($periodo == "total")
	// 	{
	// 		$sql = "SELECT SUM(`".$campo."`) FROM sys_visitors";
	// 	}
	// 	else
	// 	{
	// 		$sql = "SELECT SUM(`".$campo."`) FROM sys_visitors WHERE ".$busca;
	// 	}
	// 	$query = mysql_query($sql);
	// 	$resultado = mysql_fetch_row($query);

	// 	// Retorna o valor encontrado ou zero
	// 	return (!empty($resultado)) ? (int)$resultado[0] : 0;
	// }

	// Função para retornar o total de visitantes online
	function onlineVisitors($key)
	{
		$sql = mysql_query("SELECT * FROM sys_online_visitors ORDER BY timeEnd DESC");
		if(mysql_num_rows($sql) == true)
		{
			if($key == "total")
			{
				return mysql_num_rows($sql);
			}
			elseif($key == true)
			{
				$ln = mysql_fetch_object($sql);
				return $ln->$campo;
			}
		}
		else
		{
			return '0';
		}
	}

	function saveLog($log)
	{
		mysql_query("INSERT INTO sys_logs (data, log) VALUES ('".date("Y-m-d H:i:s")."', '$log')");
	}

	function passwordVerification($pass)
	{
		
		$len = strlen($pass);
		$count = 0;
		$array = array("[[:lower:]]+", "[[:upper:]]+", "[[:digit:]]+", "[!#_-]+");
	        
		foreach($array as $a)
		{
			if(ereg($a, $pass))
			{
				$count++;
			}
		}
	        
		if($len > 10)
		{
			$count++;
		}

		return $count;

	}

	function getStatic($cond, $campo){
		$ln  = @mysql_query("SELECT * FROM site_static WHERE cond = '".$cond."'") or die(mysql_error());
		return @mysql_fetch_object($ln)->$campo;
	}

	function slug($texto){
		$texto = strtr($texto, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ:; ", "aaaaeeiooouucAAAAEEIOOOUUC___");
		$texto = ereg_replace("[^a-zA-Z0-9_.]", "", $texto);
		//$texto = preg_replace('#[^-a-zA-Z0-9_&; +]#', '', $texto);
		//$texto = preg_replace("/[^\w#& ]/");
		$texto = str_replace("_", "-", $texto);
		$texto = strtolower($texto);
		return $texto;
	}

	function trataEndereco($e){
		$e = (substr($e, 0, 4) == 'http') ? $e : 'http://'.$e;
		return $e;
	}

	function validateCPF($cpf)
	{
		$cpf = @str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
		if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
		{
			return false;
		}
		else
		{
			for($t = 9; $t < 11; $t++)
			{
				for ($d = 0, $c = 0; $c < $t; $c++)
				{
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d)
				{
					return false;
				}
			}
			return true;
		}
	}

	function validateCNPJ($cnpj)
	{
		$pontos = array(',','-','.','','/');
		$cnpj = str_replace($pontos,'',$cnpj);
		$cnpj = trim($cnpj);
		if(empty($cnpj) || strlen($cnpj) != 14) return FALSE;
		else {
			if(check_fake($cnpj,14)) return FALSE;
			else {
				$rev_cnpj = strrev(substr($cnpj, 0, 12));
				for ($i = 0; $i <= 11; $i++) {
					$i == 0 ? $multiplier = 2 : $multiplier;
					$i == 8 ? $multiplier = 2 : $multiplier;
					$multiply = ($rev_cnpj[$i] * $multiplier);
					$sum = $sum + $multiply;
					$multiplier++;
	
				}
				$rest = $sum % 11;
				if ($rest == 0 || $rest == 1)  $dv1 = 0;
				else $dv1 = 11 - $rest;
				
				$sub_cnpj = substr($cnpj, 0, 12);
				$rev_cnpj = strrev($sub_cnpj.$dv1);
				unset($sum);
				for ($i = 0; $i <= 12; $i++) {
					$i == 0 ? $multiplier = 2 : $multiplier;
					$i == 8 ? $multiplier = 2 : $multiplier;
					$multiply = ($rev_cnpj[$i] * $multiplier);
					$sum = $sum + $multiply;
					$multiplier++;
	
				}
				$rest = $sum % 11;
				if ($rest == 0 || $rest == 1)  $dv2 = 0;
				else $dv2 = 11 - $rest;
	
				if ($dv1 == $cnpj[12] && $dv2 == $cnpj[13]) return true; //$cnpj;
				else return false;
			}
		}
	}

	function validadeCep($cep)
	{
		$cep = trim($cep);
		$avaliaCep = @ereg("^[0-9]{5}-[0-9]{3}$", $cep);
		if(!$avaliaCep)
		{            
			return false;
		}
		else
		{
			return true;
		}
	}

	function busca_cep($cep){  
		include('phpQuery-onefile.php');

		function simple_curl($url,$post=array(),$get=array()){
			$url = explode('?',$url,2);
			if(count($url)===2){
				$temp_get = array();
				parse_str($url[1],$temp_get);
				$get = array_merge($get,$temp_get);
			}
		
			$ch = curl_init($url[0]."?".http_build_query($get));
			curl_setopt ($ch, CURLOPT_POST, 1);
			curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
			curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			return curl_exec ($ch);
		}
		
		$html = simple_curl('http://m.correios.com.br/movel/buscaCepConfirma.do',array(
			'cepEntrada'=>$cep,
			'tipoCep'=>'',
			'cepTemp'=>'',
			'metodo'=>'buscarCep'
		));
		
		phpQuery::newDocumentHTML($html, $charset = 'ISO-8859-1');
		$errCEP= array('erro'=> trim(pq('.erro:eq(0)')->html()));
		
		if(empty($errCEP["erro"])){
			
			$logradouro = trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html());
			if($logradouro != ''){
				$logradouro = explode(' - ', $logradouro);
				$logradouro = trim($logradouro[0]);
			}else{
				$logradouro = trim(pq('.caixacampobranco .resposta:contains("Ender") + .respostadestaque:eq(0)')->html());
				$logradouro = explode(',', $logradouro);
				$logradouro = trim($logradouro[0]);
			}
			
			$cidadeuf = trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html());
			if($cidadeuf == ''){ $cidadeuf = trim(pq('.caixacampobranco .resposta:contains("Localidade/UF: ") + .respostadestaque:eq(0)')->html()); }
			
			$dados = 
			array(
				'resultado'=> 1,
				'resultado_txt' => 'sucesso - cep completo',
				'uf'=> '',
				'cidade'=> '',
				'bairro'=> trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
				'logradouro'=> $logradouro,
				'logradouro_'=> '',
				'cidade/uf'=> $cidadeuf,
				'cep'=> trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
			);
			
			
			$dados['cidade/uf'] = explode('/',$dados['cidade/uf']);
			$dados['cidade'] = trim($dados['cidade/uf'][0]);
			$dados['uf'] = trim($dados['cidade/uf'][1]);
			unset($dados['cidade/uf']);
			return $dados;
		
		}else{
			$dados['resultado'] = 0;
			return $dados;
		}
		
		die();
	}

	function validateEmail($email)
	{
		//filter_var($value, FILTER_VALIDATE_EMAIL)
		if(preg_match ("/^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\\.[A-Za-z0-9]{2,4}$/", $email))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function getFileExtension($nome_arq)
	{
		$ext = explode('.',$nome_arq);
		$ext = array_reverse($ext);
			return $ext[0];
	}

	#Retorna o tamanho de um arquivo
	function getFileSize($arquivo) 
	{
		$tamanhoarquivo = $arquivo;
		/* Medidas */
		$medidas = array('KB', 'MB', 'GB', 'TB');
		/* Se for menor que 1KB arredonda para 1KB */
		if($tamanhoarquivo < 999)
		{
			$tamanhoarquivo = 1000;
		}
		for ($i = 0; $tamanhoarquivo > 999; $i++)
		{
			$tamanhoarquivo /= 1024;
		}
		return round($tamanhoarquivo) . $medidas[$i - 1];
	}

	#Função para cortar textos.	
	function truncate($str, $len, $etc='')
	{
		$end = array(' ', '.', ',', ';', ':', '!', '?');
		if (strlen($str) <= $len)
			return $str;
		if (!in_array($str{$len - 1}, $end) && !in_array($str{$len}, $end))
			while (--$len && !in_array($str{$len - 1}, $end));
			return rtrim(substr($str, 0, $len)).$etc;
	}

	#Função para apagar pasta completa
	function deleteFolder($rootDir)
	{
		if(!is_dir($rootDir))
		{
			return false;
		}
		if(!preg_match("/\\/$/", $rootDir))
		{
			$rootDir .= '/';
		}
		$dh = opendir($rootDir);
		while (($file = readdir($dh)) !== false)
		{
			if($file == '.'  ||  $file == '..')
			{
				continue;
			}
			if(is_dir($rootDir . $file))
			{
				removeTreeRec($rootDir . $file);
			}
			elseif (is_file($rootDir . $file))
			{
				unlink($rootDir . $file);
			}
		}
		closedir($dh);
		rmdir($rootDir);
		return true;
	}
	
	#onlyNumbers: Deixa somente números em uma string
	function onlyNumbers($fonte)
	{
		return preg_replace("/[^0-9]/","",$fonte);
	}
	
	#moneyFormat: Formata um número para reais (1000.00 -> 1.000,00)
	function moneyFormat($valor)
	{
		if (!empty($valor))
		{
			return number_format($valor,2,',','.');
		}
		else
		{
			return "0,00";
		}
	}
	
	#nomeMes: retorna o mês do ano
	function nomeMes($mes)
	{ 
		switch($mes)
		{
			case 1: return "Janeiro"; break;
			case 2: return "Fevereiro"; break;
			case 3: return "Março"; break;
			case 4: return "Abril"; break;
			case 5: return "Maio"; break;
			case 6: return "Junho"; break;
			case 7: return "Julho"; break;
			case 8: return "Agosto"; break;
			case 9: return "Setembro"; break;
			case 10: return "Outubro"; break;
			case 11: return "Novembro"; break;
			case 12: return "Dezembro"; break;
		}			
	}
	
	#dayName: retorna o dia da semana (1-dom , 7-sáb)
	function dayName($dia)
	{ 
		switch($dia)
		{
			case 1: return "Domingo"; break;
			case 2: return "Segunda-feira"; break;
			case 3: return "Terça-feria"; break;
			case 4: return "Quarta-feira"; break;
			case 5: return "Quinta-feira"; break;
			case 6: return "Sexta-feira"; break;
			case 7: return "Sábado"; break;
		}			
	}
	
	function randPassword($tamanho)
	{
		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$i = 1;
		$pass = '' ;
		while ($i <= $tamanho)
		{
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		return $pass;
	}
	
	
	#listDirectory: lista o conteúdo de um diretório									
	function listDirectory($diretorio, $tipoarquivo=null)
	{ 
		$d = dir($diretorio); // Abrindo diretório 
		// Fazendo buscar por um arquivo ou diretorio de cada vez que estejam dentro da pasta especificada 
		while (false !== ($entry = $d->read()))
		{
			if ($tipoarquivo == '')
			{
				$array[] = $entry;
			}
			else if ($tipoarquivo == 'dir')
			{  
				// Verificando se o que foi encontrado é um diretorio 
				if (substr_count($entry, '.') == 0){
					// Se sim colocando na matriz 
					$array[] = $entry;
				}
			}
			else
			{ 
				// Verificando se o que foi encontrado um arquivo especifico 
				if (substr_count($entry, $tipoarquivo) == 1)
				{
					// Se sim colocando na matriz 
					$array[] = $entry; 
				} // end if
			} // end if
		} // end while
	
		//Fechando diretorio 
		$d->close(); 
		if ($array=='')
		{ 
			$array = false; 
		}
		else
		{ 			
			sort ($array); // Colocando em ordem alfabetica 
			reset ($array); // Voltando o ponteiro para o inicio da matriz 
		} 
		return $array; // Retornado resultado final 
	}
?>