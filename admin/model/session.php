<?php
	
	function session($adminID)
	{
		if($adminID == true)
		{
			$consulta = mysql_query("SELECT * FROM sys_admin WHERE ID = '$adminID'");
			$result   = mysql_num_rows($consulta);

			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}

?>