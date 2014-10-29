<?php 
class GetResponse{
	/** API ключ */
	private $apiKey = '70ff64bd5143e89aa04d1f74a7b35535';
	//private $apiKey = '5c4c2de3829d13d78ce409adde878cff'; // test api
	/** API url */
	private $apiUrl = 'http://api.getresponse360.com/alexschool';
	//private $apiUrl = 'http://api2.getresponse.com'; // test url
	
	private $client;
	
	public function __construct() {
		$this->client = new jsonRPCClient($this->apiUrl);
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
	
	public function function_name() {
		;
	}
	
	INSERT INTO `getresponse`.`campaign_actions` (`id`, `action`, `campaign`, `campaignTarget`, `cycleDay`, `eachDay`, `date`) VALUES (NULL, '1', 'q123', 'w123', '-1', '1', '2014-10-29');
	
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
}

?>