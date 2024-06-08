<?php 

namespace METRIC\App\Controller;

use METRIC\App\Controller\BaseController;
use METRIC\App\HttpClient\ZohoHttpClient;
use METRIC\App\Service\Logger;
use stdClass;

class ZohoController extends BaseController
{
    private ZohoHttpClient $zohoHttpClient;
    private Logger $logger;

    public function __construct(ZohoHttpClient $zohoHttpClient)
    {
        parent::__construct();
        $this->zohoHttpClient = $zohoHttpClient;
        $this->logger = new Logger;
    }

    public function insertAccount(object $data): string
    {
        $account = $this->zohoHttpClient->insertAccount($data);
        $accountId = json_decode($account)->data[0]->details->id;
        $contact = $this->zohoHttpClient->insertContact($data);
        return $contact;
    }

    public function insertJ1Host(object $data): string
    {
        $j1Visa = $this->zohoHttpClient->insertJ1Host($data);
        return $j1Visa;
    }

    public function insertEventManager(object $data): string
    {
        $eventManager = $this->zohoHttpClient->insertEventManager($data);
        return $eventManager;
    }

    public function getEventManager(object $data): string
    {
        $eventManager = $this->zohoHttpClient->getEventManager($data);
        return $eventManager;
    }

    public function getFields(object $data): string
    {
        $eventManager = $this->zohoHttpClient->getFields($data);
        return $eventManager;
    }
}