<?php

	function clearUsersOnline()
	{
		// Tempo de agora
		$time  = time();

		// Deleta os usuários que sairam do site
		@mysql_query("DELETE FROM sys_visitors_online WHERE timeEnd < '$time'");
	}
	clearUsersOnline();

?>