<?php

namespace METRIC\App\HttpClient;

use stdClass;
use METRIC\App\Config\AppConfig;
use METRIC\App\Authorization\CheckZohoToken;
use METRIC\App\Service\Logger;

class ZohoHttpClient
{

    private Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger;
    }

    public function insertAccount(object $data): string
    {
        $this->logger->info($data);
        $this->logger->info(gettype($data));

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
                    'Account_Name' => 'test metric 14',
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

        if (curl_errno($curl)) {
            $this->logger->error("Error: " . curl_error($curl));
        }

        curl_close($curl);

        return $response;
    }

    public function insertContact(object $data): string
    {
        $this->logger->info($data);
        $this->logger->info(gettype($data));
    
        $curl = curl_init();

        $arrayData = array(

            'data' => array(
                array(
                    'Owner' => array(
                        'id' => AppConfig::getInstance()->getValue("ZOHO_USER_ID"),
                    ),
                    "Account_Name" =>  [
                        'id' => '388514000013003003'
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
                    'First_Name' => 'test_contact 1',
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

        if (curl_errno($curl)) {
            $this->logger->error("Error: " . curl_error($curl));
        }

        curl_close($curl);

        return $response;
    }

    public function insertJ1Host(object $data): string
    {

        $arrayData = [
            "data" => [
                [
                    "Layout" => [
                        "id" => "388514000000452002"
                    ],
                    "Lead_Source" => "Trade Show",
                    "Company" => "ABC",
                    "Last_Name" => "test",
                    "Email" => "test@example.com",
                    "State" => "Texas",
                    "Category" => "Trainee",
                    "Salutation" => "Mr.",
                    "Name" => "test21",
                    "Permanent_Address" => "Avd de la cruz 11",
                    "City" => "New York",
                    "Zip_Code" => "12334",
                    "Foreign_Phone_Number" => "12345644",
                    "Number_of_Employees" => "4",
                    "Adress" => "dirección de la company ca",
                    "Host_Company_Address" => "dirección de la company host",
                    "Secondary_Email" => "test2@example.com",
                    "Supervisor_First_Name" => "John Doe",
                    "Contact_Phone" => 123456,
                    "Contact_Email" => "test.contact@matricsalad.com",
                    "Supervisor_Last_Name" => "last name supervisor",
                    "Test_Field" => "test"
                ]
            ],
            "apply_feature_execution" => [
                [
                    "name" => "layout_rules"
                ]
            ],
            "trigger" => [
                "approval",
                "workflow",
                "blueprint"
            ]
        ];

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
            CURLOPT_POSTFIELDS => json_encode($arrayData),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . CheckZohoToken::getToken(),
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $this->logger->error("Error: " . curl_error($curl));
        }

        curl_close($curl);

        return $response;
    }

    public function insertEventManager(object $data): string
    {

        $arrayData = [
            "data" => [
                [
                    'Owner' => array(
                        'id' => AppConfig::getInstance()->getValue("ZOHO_USER_ID"),
                    ),
                    "Layout" => [
                        "id" => "388514000001456557"
                    ],
                    "Account" =>  [
                        'id' => '388514000013323020'
                    ],
                    
                    "Event" => "388514000010159019",
                    "Registrant" => "388514000004667038",
                    "Event_Contact" => "388514000013324032",
                    "Event_Manager_Owner" => "",
                    "Email" => "",
                ]
            ],
            "apply_feature_execution" => [
                [
                    "name" => "layout_rules"
                ]
            ],
            "trigger" => [
                "approval",
                "workflow",
                "blueprint"
            ]
        ];

        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => AppConfig::getInstance()->getValue("ZOHO_API_URL") . "/Events_management",
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
                ),
            ));

            $response = curl_exec($curl);
        } catch (\Throwable $th) {
        }



        curl_close($curl);

        return $response;
    }

    public function getEventManager(object $data): string
    {
        $arrayData = [
            "data" => [
                [
                    'Owner' => array(
                        'id' => AppConfig::getInstance()->getValue("ZOHO_USER_ID"),
                    ),
                    "Layout" => [
                        "id" => "388514000001456557"
                    ],
                    "Account" =>  [
                        'id' => '388514000013323020'
                    ],
                    
                    "Event" => "388514000010159019",
                    "Registrant" => "388514000004667038",
                    "Event_Contact" => "388514000013324032",
                    "Event_Manager_Owner" => "",
                    "Email" => "",
                ]
            ],
            "apply_feature_execution" => [
                [
                    "name" => "layout_rules"
                ]
            ],
            "trigger" => [
                "approval",
                "workflow",
                "blueprint"
            ]
        ];

        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => AppConfig::getInstance()->getValue("ZOHO_API_URL") . "/settings/modules/Events_management",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                //CURLOPT_POSTFIELDS => json_encode($arrayData),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . CheckZohoToken::getToken(),
                ),
            ));

            $response = curl_exec($curl);
        } catch (\Throwable $th) {
        }



        curl_close($curl);

        return $response;
    }

    public function getFields(object $data): string
    {
        $arrayData = [
            "data" => [
                [
                    'Owner' => array(
                        'id' => AppConfig::getInstance()->getValue("ZOHO_USER_ID"),
                    ),
                    "Layout" => [
                        "id" => "388514000001456557"
                    ],
                    "Account" =>  [
                        'id' => '388514000013323020'
                    ],
                    
                    "Event" => "388514000010159019",
                    "Registrant" => "388514000004667038",
                    "Event_Contact" => "388514000013324032",
                    "Event_Manager_Owner" => "",
                    "Email" => "",
                ]
            ],
            "apply_feature_execution" => [
                [
                    "name" => "layout_rules"
                ]
            ],
            "trigger" => [
                "approval",
                "workflow",
                "blueprint"
            ]
        ];

        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => AppConfig::getInstance()->getValue("ZOHO_API_URL") . "/settings/fields?module=Events_management",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                //CURLOPT_POSTFIELDS => json_encode($arrayData),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . CheckZohoToken::getToken(),
                ),
            ));

            $response = curl_exec($curl);
        } catch (\Throwable $th) {
        }



        curl_close($curl);

        return $response;
    }
}
