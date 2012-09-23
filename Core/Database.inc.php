<?php
class Core_Database {
	var $mysql_connection;
	var $mysql_db;
	
	// db connection
	function __construct()
	{	
		$this->mysql_connection = @mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die('Could not connect to MySQL: '.mysqli_connect_error());
	}

	// query db
	function db_query($query, $echo_query = false)
	{
		$query_result = mysqli_query($this->mysql_connection, $query) or die(mysqli_connect_error());
		if($echo_query) echo($query);
		mysqli_close($this->mysql_connection);
		return $query_result;
	}

	// return db array
	function db_array($query, $echo_query = false)
	{
		if($query_result = $this->db_query($query)) {
			while($result = mysqli_fetch_array($query_result, MYSQLI_ASSOC)) {
				$db_array[] = $result;
			}
		}
		if($echo_query) echo($query);
		mysqli_free_result($query_result);		
		return $db_array;
	}
	
	// return one db row as array
	function db_row($query, $echo_query = false)
	{
		if($row_result = $this->db_array($query)) {
			foreach($row_result as $single_row) {
				$db_array[] = $single_row;
				break;
			}
		}
		if($echo_query) echo($query);
		return $single_row;
	}
	
	// return a db column as array
	function db_colum($query, $echo_query = false)
	{
		if($row_result = $this->db_array($query)) {		
			for($i = 0; $i <= count($row_result); $i++) {
				$doortel++;
				$colum[$doortel] = $row_result[$i][0];
			}
		}
		if($echo_query) echo($query);
		return $colum;
	}
	
	// count records
	function db_num_rows($query, $echo_query = false)
	{
		if($echo_query) echo($query);
		if($query_result = $this->db_query($query)){
			return @mysqli_num_rows($query_result);
		}
	}
	
}