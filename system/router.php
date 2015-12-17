<?php
	// SEO url's settings
	function router($params)
	{

		$self  = explode("/", substr($_SERVER["PHP_SELF"], 1));
		$itens = count($self);
		$i     = 0;
		$pastas = array();
		foreach($self as $key)
		{
			if(++$i != $itens) {
				$pastas[] = $key;
			}
		}

		$countPastas = count($pastas, COUNT_RECURSIVE);
		$seo = explode("/", str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]));
		array_shift($seo);	

		return @$seo[$params+$countPastas];	
	}
?>