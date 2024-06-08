<?php

namespace METRIC\App;

use METRIC\App\Controller\BaseController;
use METRIC\App\Http\Router;
use METRIC\App\Http\Request;
use METRIC\App\Http\Response;
use METRIC\App\Service\Logger;
use METRIC\App\Authorization\CheckZohoToken;
use METRIC\App\Config\AppConfig;
use METRIC\App\Controller\ZohoController;
use METRIC\App\HttpClient\ZohoHttpClient;

class Application extends BaseController
{

    private $request_uri;
    private $request_method;
    private $content_type;
    private $request_port;
    private Logger $logger; 

    public function __construct(string $request_uri, string $request_method, string $content_type, string $request_port)
    {

        parent::__construct();

        $this->request_uri = $request_uri;
        $this->request_method = $request_method;
        $this->content_type = $content_type;
        $this->request_port = $request_port;
        $this->logger = new Logger;
        $this->router();
    }

    private function router()
    {
        Router::get('/get-token', $this->request_uri, $this->request_method, $this->content_type, function (Request $req, Response $res) {
            $res->toJSON(["token" => CheckZohoToken::getToken()]);
            exit;
        });

        Router::get('/get/record/j1visa', $this->request_uri, $this->request_method, $this->content_type, function (Request $req, Response $res) {
            $curl = curl_init();

            AppConfig::getInstance()->getValue("ZOHO_API_URL");

            dump(AppConfig::getInstance()->getValue("ZOHO_API_URL") . '/J1_Visa?fields=Last_Name%2CEmail&per_page=3');

            curl_setopt_array($curl, array(
                CURLOPT_URL => AppConfig::getInstance()->getValue("ZOHO_API_URL") . '/J1_Visa?fields=Last_Name%2CEmail&per_page=3',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . CheckZohoToken::getToken(),
                    'Cookie: 4993755637=3f56e203ae5473f0d1c801ca5c349a67; _zcsr_tmp=134f581d-7af5-45a3-a1c7-5b066865b16c; crmcsr=134f581d-7af5-45a3-a1c7-5b066865b16c'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            //echo $response;
            $res->toJSON($response);
            exit;
        });

        // http://localhost:8001/get/record/388514000012736596
        Router::get('/get/record/([0-9]*)', $this->request_uri, $this->request_method, $this->content_type, function (Request $req, Response $res) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => AppConfig::getInstance()->getValue("ZOHO_API_URL") . "/J1_Visa/" . $req->getUrlParams()[0],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . CheckZohoToken::getToken()
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $res->toJSON($response);
            exit;
        });

        Router::get('/settings/modules', $this->request_uri, $this->request_method, $this->content_type, function (Request $req, Response $res) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => AppConfig::getInstance()->getValue("ZOHO_API_URL") . "/settings/modules",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . CheckZohoToken::getToken()
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $res->toText($response);
            exit;
        });

        Router::post('/insert/record', $this->request_uri, $this->request_method, $this->content_type, function (Request $req, Response $res) {

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => AppConfig::getInstance()->getValue("ZOHO_API_URL") . "/J1_Visa",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "data": [
                    {
                        "Layout": {
                            "id": "388514000000452002"
                        },
                        "Lead_Source": "Trade Show",
                        "Company": "ABC",
                        "Last_Name": "test",
                        "Email": "test@example.com",
                        "State": "Texas",
                        "Category": "Trainee",
                        "Salutation": "Mr.",
                        "Name": "test21",
                        "Permanent_Address": "Avd de la cruz 11",
                        "City": "New York",
                        "Zip_Code": "12334",
                        "Foreign_Phone_Number": "12345644",
                        "Number_of_Employees": "4",
                        "Adress": "dirección de la company ca",
                        "Host_Company_Address": "dirección de la company host",
                        "Secondary_Email": "test2@example.com",
                        "Supervisor_First_Name": "John Doe",
                        "Contact_Phone": 123456,
                        "Contact_Email": "test.contact@matricsalad.com",
                        "Supervisor_Last_Name": "last name supervisor",
                        "Test_Field": "test"
                    }
                ],
                "apply_feature_execution": [
                    {
                        "name": "layout_rules"
                    }
                ],
                "trigger": [
                    "approval",
                    "workflow",
                    "blueprint"
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . CheckZohoToken::getToken(),
                'Content-Type: application/json',
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            
            $res->toText($response);
            exit;


        });

        Router::post('/insert/account', $this->request_uri, $this->request_method, $this->content_type, function (Request $req, Response $res) {

            $curl = curl_init();

            $arrayData = array(
                'data' => array(
                    array(
                        'Owner' => array(
                            'id' => AppConfig::getInstance()->getValue("ZOHO_USER_ID"),
                        ),
                        'Ownership' => 'Private',
                        'Description' => 'Company descriptión del campo web',
                        'Account_Type' => 'Competitor',
                        'Rating' => 'Active',
                        'SIC_Code' => 12792,
                        'Shipping_State' => 'Shipping_State',
                        'Website' => 'example.com',
                        'Employees' => 12792,
                        'Industry' => 'Consumer Goods',
                        'Account_Site' => 'Account_Site',
                        'Phone' => '988844559',
                        'Billing_Country' => 'Billing_Country',
                        'Account_Name' => 'test metric 8',
                        'Account_Number' => '1245681',
                        'Ticker_Symbol' => 'Ticker_Symbol',
                        'Billing_Street' => 'Billing_Street',
                        'Billing_Code' => 'Billing_Code',
                        'Shipping_City' => 'Shipping_City',
                        'Shipping_Country' => 'Shipping_Country',
                        'Shipping_Code' => 'Shipping_Code',
                        'Billing_City' => 'Billing_City',
                        'Billing_State' => 'Billing_State',
                        'Fax' => 'Fax',
                        'Annual_Revenue' => 127.67,
                        'Shipping_Street' => 'Shipping_Street',
                        'Membership_Category' => "Platinum"
                    ),
                ),
            );

            curl_setopt_array($curl, array(
            CURLOPT_URL => AppConfig::getInstance()->getValue("ZOHO_API_URL") . "/Accounts",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($arrayData),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . CheckZohoToken::getToken(),
                'Content-Type: application/json',
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            
            $res->toText($response);
            exit;


        });

        Router::post('/insert/contact/record', $this->request_uri, $this->request_method, $this->content_type, function (Request $req, Response $res) {

            $curl = curl_init();

            $arrayData = array(
                'data' => array(
                    array(
                        'Owner' => array(
                            'id' => AppConfig::getInstance()->getValue("ZOHO_USER_ID"),
                        ),
                        "Account_Name" =>  [
				            'id' => '388514000013323020' // test_MetricSalad
			            ],
                        "Event" => [ // api_name
                        [
                            "Event" => [ //multiselectlookup -> connected_module -> api_name
                                "id" => "388514000013339001", // test_event
                            ]
                         ]   
                        ],
                        'email' => 'example@example.com',
                        'Description' => 'Design your own layouts that align your business processes precisely. Assign them to profiles appropriately.',
                        'Mailing_Zip' => '123456',
                        'Reports_To' => 'CReports_To',
                        'Other_Phone' => '988844559',
                        'Mailing_State' => 'Mailing_State',
                        'SIC_Code' => 12792,
                        'Shipping_State' => 'Shipping_State',
                        'Twitter' => 'Twitter',
                        'Other_Zip' => 'Other_Zip',
                        'Other_State' => 'Other_State',
                        'Account_Site' => 'Account_Site',
                        'Salutation' => 'Mrs.',
                        'Other_Country' => 'Other_Country',
                        'First_Name' => 'test_First_Name_5',
                        'Asst_Phone' => '988844559',
                        'Department' => 'Department',
                        'Skype_ID' => 'Skype_ID',
                        'Assistant' => 'Assistant',
                        'Phone' => '988844559',
                        'Mailing_Country' => 'Mailing_Country',
                        'Email_Opt_Out' => true,
                        'Date_of_Birth' => '2018-01-25',
                        'Mailing_City' => 'Mailing_City',
                        'Mobile' => '988844559',
                        'Home_Phone' => '988844559',
                        'Last_Name' => 'Last_Name',
                        'Lead_Source' => 'Cold Call',
                        'Secondary_Email' => 'newcrmapi@zoho.com'
                    ),
                ),
            );

            curl_setopt_array($curl, array(
            CURLOPT_URL => AppConfig::getInstance()->getValue("ZOHO_API_URL") . "/Contacts",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($arrayData),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . CheckZohoToken::getToken(),
                'Content-Type: application/json',
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            
            $res->toText($response);
            exit;


        });

        Router::post('/insert/contact/record3', $this->request_uri, $this->request_method, $this->content_type, function (Request $req, Response $res) {

            $curl = curl_init();

            $arrayData = array(
                'data' => array(
                    array(
                        'Owner' => array(
                            'id' => AppConfig::getInstance()->getValue("ZOHO_USER_ID"),
                        ),
                        "Account_Name" =>  [
				            'id' => '388514000013323020' // test_MetricSalad
			            ],
                        "Event" => [ // api_name
                        [
                            "Event" => [ //multiselectlookup -> connected_module -> api_name
                                "id" => "388514000013339001", // test_event
                            ]
                         ]   
                        ],
                        'email' => 'example@example.com',
                        'Description' => 'Design your own layouts that align your business processes precisely. Assign them to profiles appropriately.',
                        'Mailing_Zip' => '123456',
                        'Reports_To' => 'CReports_To',
                        'Other_Phone' => '988844559',
                        'Mailing_State' => 'Mailing_State',
                        'SIC_Code' => 12792,
                        'Shipping_State' => 'Shipping_State',
                        'Twitter' => 'Twitter',
                        'Other_Zip' => 'Other_Zip',
                        'Other_State' => 'Other_State',
                        'Account_Site' => 'Account_Site',
                        'Salutation' => 'Mrs.',
                        'Other_Country' => 'Other_Country',
                        'First_Name' => 'test_First_Name_7',
                        'Asst_Phone' => '988844559',
                        'Department' => 'Department',
                        'Skype_ID' => 'Skype_ID',
                        'Assistant' => 'Assistant',
                        'Phone' => '988844559',
                        'Mailing_Country' => 'Mailing_Country',
                        'Email_Opt_Out' => true,
                        'Date_of_Birth' => '2018-01-25',
                        'Mailing_City' => 'Mailing_City',
                        'Mobile' => '988844559',
                        'Home_Phone' => '988844559',
                        'Last_Name' => 'Last_Name',
                        'Lead_Source' => 'Cold Call',
                        'Secondary_Email' => 'newcrmapi@zoho.com'
                    ),
                ),
            );

            curl_setopt_array($curl, array(
            CURLOPT_URL => AppConfig::getInstance()->getValue("ZOHO_API_URL") . "/Contacts",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($arrayData),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . CheckZohoToken::getToken(),
                'Content-Type: application/json',
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            
            $res->toText($response);
            exit;


        });

        Router::post('/insert/contact/record2', $this->request_uri, $this->request_method, $this->content_type, function (Request $req, Response $res) {
            $data = $req->getJSON();
            $zohoController = new ZohoController(new ZohoHttpClient());
            $data = new \stdClass;
            $accountId = $zohoController->insertAccount($data);
            $res->toText($accountId);
            exit;
        });

        Router::post('/insert/j1/host/form', $this->request_uri, $this->request_method, $this->content_type, function (Request $req, Response $res) {
            $data = $req->getJSON();
            $zohoController = new ZohoController(new ZohoHttpClient());
            $data = new \stdClass;
            $accountId = $zohoController->insertJ1Host($data);
            $res->toText($accountId);
            exit;
        });

        Router::post('/insert/event/record', $this->request_uri, $this->request_method, $this->content_type, function (Request $req, Response $res) {
            $data = $req->getJSON();
            $zohoController = new ZohoController(new ZohoHttpClient());
            $data = new \stdClass;
            $accountId = $zohoController->insertEventManager($data);
            $res->toText($accountId);
            exit;
        });

        Router::post('/get/Events_management', $this->request_uri, $this->request_method, $this->content_type, function (Request $req, Response $res) {
            $data = $req->getJSON();
            $zohoController = new ZohoController(new ZohoHttpClient());
            $data = new \stdClass;
            $accountId = $zohoController->getEventManager($data);
            $res->toText($accountId);
            exit;
        });

        Router::post('/get/fields', $this->request_uri, $this->request_method, $this->content_type, function (Request $req, Response $res) {
            $data = $req->getJSON();
            $zohoController = new ZohoController(new ZohoHttpClient());
            $data = new \stdClass;
            $accountId = $zohoController->getFields($data);
            $res->toText($accountId);
            exit;
        });

    }
}
