<?php
	function select($table, $campo, $where = ''){
		$sql    = mysql_query("SELECT $campo FROM $table {$where}");
		$result = mysql_num_rows($sql);

		if($result > 0)
		{
			$ln = mysql_fetch_object($sql);
			return $ln->$campo;
		}
		else
		{
			return false;
		}
		
	}
		
	/*
	* função para inserir registros no banco de dados
	*
	* @param string $field O nome da coluna
	* @param string $value A informação
	* @param string $table O nome da tabela
	
	Inserir vários campos
	insert(array("nome","idade","profissao"), array("renan",22,"programador"),"cadastro");

	inserir dados em uma única coluna
	insert("nome","Renan","cadastro");
	*
	*/
	function insert($field,$value,$table){
    	if((is_array($field)) and (is_array($value))){
        	if(count($field) == count($value)){
      			$sql = mysql_query("INSERT INTO {$table} (".implode(', ', $field).") VALUES ('".implode('\', \'', $value)."')") or die (mysql_error());
				if($sql){
					return true;
				}else{
					return false;
				}
        	}else{
            	return false;
       		}
    	}else{
			$sql = mysql_query("INSERT INTO {$table} ({$field}) VALUES ({$value})") or die (mysql_error());
			if($sql){
				return true;
			}else{
				return false;
			}
    	}
	}


	/*
	* função para atualizar registros no banco de dados
	*
	*
	* @param string $field O nome do campo
	* @param string $value O novo valor
	* @param string $table O nome da tabela
	* @param string $where Onde será atualizado
	* @return TRUE em caso de sucesso
	
	update(array("tipo","texto"), array("vinicius","nunes"),"textos","WHERE ID = 7");
	*/
	function update($field,$value,$table,$where){
		if((is_array($field)) and (is_array($value))){
			if(count($field) == count($value)){
				$field_value = NULL;
				for ($i=0;$i<count($field);$i++){
					$field_value .= " {$field[$i]} = '{$value[$i]}',";
				}
				$field_value = substr($field_value,0,-1);
				$update = mysql_query("UPDATE {$table} SET {$field_value} {$where}") or die (mysql_error());
				if($update){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			$update = mysql_query("UPDATE {$table} SET {$field} = '{$value}' {$where}") or die (mysql_error());
			if($update){
				return true;
			}else{
				return false;
			}
		}
	}

	function deleteSql($table, $where)
	{
		mysql_query("DELETE FROM {$table} {$where}");
	}
?>