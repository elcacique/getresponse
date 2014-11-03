<?php 
class GetResponse{
	/** API ключ */
	private $apiKey = '70ff64bd5143e89aa04d1f74a7b35535';
	//private $apiKey = '5c4c2de3829d13d78ce409adde878cff'; // test api
	/** API url */
	private $apiUrl = 'http://api.getresponse360.com/alexschool';
	//private $apiUrl = 'http://api2.getresponse.com'; // test url
	
	private $client;
	private $db;
	
	public function __construct() {
		$this->client = new jsonRPCClient($this->apiUrl);
		$this->db = new DB_MySQL();
	}
	
	/**
	 * Считывает данные с xml файла
	 * @param 		string $xml
	 * @return 		array xml данные
	 * @author 		Игорь Быра <ihorbyra@gmail.com>
	 * @version 	1.0
	 */
	public function parseXML($xml) {
		$xml = simplexml_load_file($xml);

		$data = array(
				'campaign' => (string) $xml->config->campaign,
				'campaign_target' => (string) $xml->config->campaign_target,
				'date_start' => (string) $xml->config->date_start,
				'date_end' => (string) $xml->config->date_end,
				'cycle_day' => (string) $xml->config->cycle_day,
				'completed' => (string) $xml->config->completed
			);
		
		return $data;
	}
	
	/**
	 * Получает информацию о кампании
	 * @param 		string $data
	 * @return 		array данные по кампании
	 * @author 		Игорь Быра <ihorbyra@gmail.com>
	 * @version 	1.0
	 */
	public function getCampaign($data) {
		$campaignName = $data;
		$campaign = $this->client->get_campaigns(
	       				$this->apiKey, 
	       				array('name' => array('EQUALS' => $campaignName))
	    			);
		return $campaign;
	}
	
	/**
	 * Получает список всех кампаний
	 * @return 		array список кампаний
	 * @author 		Игорь Быра <ihorbyra@gmail.com>
	 * @version 	1.0
	 */
	public function getCampaigns() {
		$campaign = $this->client->get_campaigns($this->apiKey);
		return $campaign;
	}
	
	
	/**
	 * Получает информацию о контактах кампании $campaign, созданых в период с $data['date_start'] до $data['date_end']
	 * @param 		string $campaign
	 * @param 		array $data
	 * @return 		array данные по контактах кампании $campaign
	 * @author 		Игорь Быра <ihorbyra@gmail.com>
	 * @version 	1.0
	 */
	public function getContactsByPeriod($campaign, $data) {
		$campaignId = array_keys($campaign);
	   	$campaignId = array_pop($campaignId);
	   	
	   	$dateStart = date('Y-m-d', strtotime($data['date_start']));
	   	$dateEnd = date('Y-m-d', strtotime($data['date_end']));
		
		$contacts =	$this->client->get_contacts(
			$this->apiKey,
				array(
					'campaigns' => array( 
						$campaignId
					),
				    'created_on' => array(
	                   'FROM' => $dateStart,
					   'TO' => $dateEnd
	                )
            	)
		);		
		return $contacts;
	}
	
	/**
	 * Перемещает контакты в кампании $campaign
	 * @param 		array $contacts
	 * @param 		string $campaign
	 * @return 		void
	 * @author 		Игорь Быра <ihorbyra@gmail.com>
	 * @version 	1.0
	 */
	public function moveContacts($contacts, $campaign) {
		$campaignId = array_keys($campaign);
	   	$campaignId = array_pop($campaignId);
	   	
	   	$contactsId = array_keys($contacts);
	   	
	   	foreach ($contactsId as $contact) {
	   		$move = $this->client->move_contact(
				$this->apiKey,
					array('contact' => $contact,
						  'campaign' => $campaignId
					)
			);
	   	}	   		
	}
	
	/**
	 * Меняет значение completed в xml файле
	 * @param 		string $xmlSorce
	 * @throws 		Exception
	 * @return 		bool
	 * @author 		Игорь Быра <ihorbyra@gmail.com>
	 * @version 	1.0
	 */
	public function setComplete($xmlSorce) {
		$xml = simplexml_load_file($xmlSorce);
		$result = $xml->xpath('/root/config/completed');
		$result[0][0] = 1;

		if ($xml->asXML($xmlSorce) === false) {
			throw new Exception('Cannot save values into "'.$xmlSorce.'"',99);
		}
		return true;
	}
	
	/**
	 * Добавляет контакты в цикл на день
	 * @param 		integer $cycleDay
	 * @param 		array $contacts
	 * @return 		void
	 * @author 		Игорь Быра <ihorbyra@gmail.com>
	 * @version 	1.0
	 */
	public function setContactCycle($cycleDay = null, $contacts) {		
		$contactsId = array_keys($contacts);
	   	
	   	foreach ($contactsId as $contact) {			
			$set = $this->client->set_contact_cycle(
				$this->apiKey,
					array('contact' => $contact,
						  'cycle_day' => $cycleDay
					)
			);
	   	}			
	}
	
	/**
	 * Создает процесс по работе с кампаниями
	 * @return 		void
	 * @author 		Игорь Быра <ihorbyra@gmail.com>
	 * @version 	1.0
	 */
	public function addProcess($data) {
		$date = date('Y-m-d');
		$query = "INSERT INTO `campaign_actions` (`id`, `action`, `campaign`, `campaignTarget`, `cycleDay`, `eachDay`, `date`) 
					VALUES (NULL, '{$data['action']}', '{$data['campaign']}', '{$data['campaignTarget']}', '{$data['cycleDay']}', '{$data['eachDay']}', '{$date}')";
		$result = $this->db->Execute($query);
	}
	
	/**
	 * Выводит список кампаний в виде списка <select>
	 * @param 		array $campaigns
	 * @return 		string список кампаний
	 * @author 		Игорь Быра <ihorbyra@gmail.com>
	 * @version 	1.0
	 */
	public function printCampaigns($campaigns) {	
		foreach ($campaigns as $campaignId => $campaignInfo) {
			$content .= '<option value="'.$campaignId.'">'.$campaignInfo['name'].'</option>';
		}
		return $content;
	}
	
	/**
	 * Вывод все процессов
	 * @return 		string список процессов
	 * @author 		Игорь Быра <ihorbyra@gmail.com>
	 * @version 	1.0
	 */
	public function getProcesses() {
		$query = "SELECT * FROM `campaign_actions` ORDER BY `id` DESC";
		$result = $this->db->Execute($query);
		$num = mysql_num_rows($result);
		
		if ($num > 0) {
			$content = '<table class="table table-hover">
							<tr>
								<th>#</th>
								<th>Дата создания</th>
								<th>Действие</th>
								<th>Кампания(источник)</th>
								<th>Кампания(цель)</th>
								<th>Цикл на день</th>
								<th>Делается каждые</th>								
							</tr>';
			while ($row = mysql_fetch_object($result)) {
				$action = (($row->action == '0') ? 'копирование' : 'перемещение');
				$content .= '<tr>
								<td>'.$row->id.'</td>
								<td>'.$row->date.'</td>
								<td>'.$action.'</td>
								<td>'.$row->campaign.'</td>
								<td>'.$row->campaignTarget.'</td>
								<td>'.$row->cycleDay.'</td>
								<td>'.$row->eachDay.'</td>
							</tr>';
			} 
			$content .= '</table>';
			return $content;
		}		
		return 'На данный момент нет ниодного процесса';
	}
}

?>