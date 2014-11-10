<?php
class Authorization {
	private $db;
	
	public function __construct() {
		$this->db = new DB_MySQL();
	}
	
	/**
	 * Авторизация пользователя
	 * @param 		string $username
	 * @param 		string $password
	 * @return 		boolean
	 * @author 		Игорь Быра <ihorbyra@gmail.com>
	 * @version 	1.0
	 */
	public function login($username, $password) {
		if (!empty($username) && !empty($password)) {
			$query = "SELECT *
				FROM users
				WHERE login = '{$username}'
				AND visible = '1'
				AND deleted = '0'";
			$result = $this->db->Execute($query);
		
			if(mysql_num_rows($result) > 0) {
				$row = mysql_fetch_object($result);
				if($row->password == md5($password)) {
					$_SESSION['admin'] = array('login' => $row->login);
					return true;
				}
				else return false;
			}
			else return false;
		}
		else return false;
	}
	
	/**
	 * Выход с системы управления
	 * Убивает сессии
	 * @param 		array $session
	 * @author 		Игорь Быра <ihorbyra@gmail.com>
	 * @version 	1.0
	 */
	public function logout($session) {
		unset($_SESSION['admin']);
		print '<script language="javascript">document.location = "/";</script>';
	}
}
?>