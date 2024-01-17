<?php
require_once 'config.php';

class DB {
	private $conn;

	function __construct() {
		$this->conn = new mysqli($GLOBALS['host'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
		if ($this->conn->connect_error) {
		die("Ошибка подключения к базе данных: " . $this->conn->connect_error);
		}
	}

	function __destruct() {
		$this->conn->close();
	}

	function userExists($user_id) {
		$user_id = $this->conn->real_escape_string($user_id);
		
		$sql = "SELECT COUNT(*) as count FROM USERS WHERE user_id = '$user_id'";

		$result = $this->conn->query($sql);

		if ($result) {
			$row = $result->fetch_assoc();
			return $row['count'] > 0;
		} else {
			return false;
		}
	}

	function insertData($user_id, $mark, $text) {
		$user_id = $this->conn->real_escape_string($user_id);
		$text = $this->conn->real_escape_string($text);

		$userExists = $this->userExists($user_id);

		$sql = "INSERT INTO surveys (user_id, survey_mark, survey_text) VALUES ('$user_id', '$mark', '$text')";

		if ($userExists) {
			if ($this->conn->query($sql) === TRUE) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		}
}
?>
