<?php
/**
 * Data Manipulations and Example
 *
 * @by Malak Abu Hammad.
 */

/**
 * @param array $data
 * @return array
 */
function decodeData(array $data)
{
    $aData = [];
    foreach ($data as $value) {
        if ($value['type'] == 'json') {
            $aData[] = json_decode($value['value'], true);
        } elseif ($value['type'] == 'array') {
            $aData[] = $value['value'];
        } elseif ($value['type'] == 'xml') {
            $aData[] = decodeXml($value['value']);
        } elseif ($value['type'] == 'gRPC') {
            /**
             * gRPC will be ignored.
             */
            continue;
        }
    }
    return $aData;
}


/**
 * @param string $xmlString
 * @return array
 */
function decodeXml($xmlString)
{
    $xml = simplexml_load_string($xmlString);
    return xmlToArrayConverter($xml);
}

/**
 * @param SimpleXMLElement $xmlObject
 * @param array $out
 * @return array
 */
function xmlToArrayConverter($xmlObject, array $out = [])
{
    foreach ((array)$xmlObject as $index => $node)
        $out[$index] = (is_object($node)) ? xmlToArrayConverter($node) : $node;

    return $out;
}

/**
 * @return array
 */
function getData()
{
    return [
        [
            'type' => 'json',
            'value' =>
                <<<'EOT'
{
    "_id" : "589c493e5f2687111bb6d800",
    "business_id" : "3f522ee8-7e69-4d78-aeb5-5278aaf21558",
    "location_id" : "96e9975b-b1bf-47ee-aeaf-63518022e95e",
    "transaction_id" : "37a5f57a-48bc-483d-91b7-88c8b1b9509c",
    "receipt_id" : "Cj9uohMQNVflSq7taYtVRk",
    "serial_number" : "C1-498",
    "dining_option" : "In-House",
    "creation_time" : "2017-02-09T10:49:34.000Z",
    "discount_money" : {
        "amount" : 0,
        "currency" : "JOD"
    },
    "additive_tax_money" : {
        "amount" : 0,
        "currency" : "JOD"
    },
    "inclusive_tax_money" : {
        "amount" : 483,
        "currency" : "JOD"
    },
    "refunded_money" : {
        "amount" : 0,
        "currency" : "JOD"
    },
    "tax_money" : {
        "amount" : 483,
        "currency" : "JOD"
    },
    "tip_money" : {
        "amount" : 0,
        "currency" : "JOD"
    },
    "total_collected_money" : {
        "amount" : 3500,
        "currency" : "JOD"
    },
    "creator" : {
        "id" : "00000000-0000-0000-0000-000000000000",
        "name" : "John Doe",
        "email" : "anonymous@example.com"
    },
    "tender" : {
        "type" : "CASH",
        "name" : "CASH",
        "total_money" : {
            "amount" : 3500,
            "currency" : "JOD"
        }
    },
    "taxes" : [
        {
            "id" : "cfc92a12-f847-4942-b6ec-1454d194c9ba",
            "name" : "Sales Tax",
            "rate" : 0.16,
            "inclusion_type" : "INCLUSIVE",
            "is_custom_amount" : true,
            "applied_money" : {
                "amount" : 483,
                "currency" : "JOD"
            }
        }
    ],
    "itemization" : [
        {
            "id" : "788cb9cb-106f-4d32-ac48-df9e8433ff50",
            "name" : "Boneless Chicken Wings",
            "quantity" : 1,
            "total_money" : {
                "amount" : 3500,
                "currency" : "JOD"
            },
            "single_quantity_money" : {
                "amount" : 3500,
                "currency" : "JOD"
            },
            "gross_sales_money" : {
                "amount" : 3017,
                "currency" : "JOD"
            },
            "discount_money" : {
                "amount" : 0,
                "currency" : "JOD"
            },
            "net_sales_money" : {
                "amount" : 3017,
                "currency" : "JOD"
            },
            "category" : {
                "id" : "a9895c94-15cc-4db1-bbad-fe62d218c931",
                "name" : "Appetizers"
            },
            "variation" : {
                "id" : "37b64192-6b0f-479d-aeee-3c382a0671b9",
                "name" : "Plate",
                "pricing_type" : "FIXED",
                "price_money" : {
                    "amount" : 3500,
                    "currency" : "JOD"
                }
            },
            "taxes" : [
                {
                    "id" : "cfc92a12-f847-4942-b6ec-1454d194c9ba",
                    "name" : "Sales Tax",
                    "rate" : 0.16,
                    "inclusion_type" : "INCLUSIVE",
                    "is_custom_amount" : true,
                    "applied_money" : {
                        "amount" : 483,
                        "currency" : "JOD"
                    }
                }
            ],
            "discounts" : [],
            "modifiers" : [
                {
                    "id" : "7424ae3d-36bc-4c0c-b790-310614905aed",
                    "name" : "6 Pieces",
                    "quantity" : 1,
                    "applied_money" : {
                        "amount" : 0,
                        "currency" : "JOD"
                    }
                }
            ]
        }
    ]
}
EOT
        ],
        [
            'type' => 'xml',
            'value' => <<<'EOT'
<?xml version="1.0" encoding="UTF-8"?>
<transaction>
   <_id>589c493e5f2687111bb6d800</_id>
   <additive_tax_money>
      <amount>0</amount>
      <currency>JOD</currency>
   </additive_tax_money>
   <business_id>3f522ee8-7e69-4d78-aeb5-5278aaf21558</business_id>
   <creation_time>2017-02-09T10:49:34.000Z</creation_time>
   <creator>
      <email>anonymous@example.com</email>
      <id>00000000-0000-0000-0000-000000000000</id>
      <name>John Doe</name>
   </creator>
   <dining_option>In-House</dining_option>
   <discount_money>
      <amount>0</amount>
      <currency>JOD</currency>
   </discount_money>
   <inclusive_tax_money>
      <amount>483</amount>
      <currency>JOD</currency>
   </inclusive_tax_money>
   <itemization>
      <element>
         <category>
            <id>a9895c94-15cc-4db1-bbad-fe62d218c931</id>
            <name>Appetizers</name>
         </category>
         <discount_money>
            <amount>0</amount>
            <currency>JOD</currency>
         </discount_money>
         <discounts />
         <gross_sales_money>
            <amount>3017</amount>
            <currency>JOD</currency>
         </gross_sales_money>
         <id>788cb9cb-106f-4d32-ac48-df9e8433ff50</id>
         <modifiers>
            <element>
               <applied_money>
                  <amount>0</amount>
                  <currency>JOD</currency>
               </applied_money>
               <id>7424ae3d-36bc-4c0c-b790-310614905aed</id>
               <name>6 Pieces</name>
               <quantity>1</quantity>
            </element>
         </modifiers>
         <name>Boneless Chicken Wings</name>
         <net_sales_money>
            <amount>3017</amount>
            <currency>JOD</currency>
         </net_sales_money>
         <quantity>1</quantity>
         <single_quantity_money>
            <amount>3500</amount>
            <currency>JOD</currency>
         </single_quantity_money>
         <taxes>
            <element>
               <applied_money>
                  <amount>483</amount>
                  <currency>JOD</currency>
               </applied_money>
               <id>cfc92a12-f847-4942-b6ec-1454d194c9ba</id>
               <inclusion_type>INCLUSIVE</inclusion_type>
               <is_custom_amount>true</is_custom_amount>
               <name>Sales Tax</name>
               <rate>0.16</rate>
            </element>
         </taxes>
         <total_money>
            <amount>3500</amount>
            <currency>JOD</currency>
         </total_money>
         <variation>
            <id>37b64192-6b0f-479d-aeee-3c382a0671b9</id>
            <name>Plate</name>
            <price_money>
               <amount>3500</amount>
               <currency>JOD</currency>
            </price_money>
            <pricing_type>FIXED</pricing_type>
         </variation>
      </element>
   </itemization>
   <location_id>96e9975b-b1bf-47ee-aeaf-63518022e95e</location_id>
   <receipt_id>Cj9uohMQNVflSq7taYtVRk</receipt_id>
   <refunded_money>
      <amount>0</amount>
      <currency>JOD</currency>
   </refunded_money>
   <serial_number>C1-498</serial_number>
   <tax_money>
      <amount>483</amount>
      <currency>JOD</currency>
   </tax_money>
   <taxes>
      <element>
         <applied_money>
            <amount>483</amount>
            <currency>JOD</currency>
         </applied_money>
         <id>cfc92a12-f847-4942-b6ec-1454d194c9ba</id>
         <inclusion_type>INCLUSIVE</inclusion_type>
         <is_custom_amount>true</is_custom_amount>
         <name>Sales Tax</name>
         <rate>0.16</rate>
      </element>
   </taxes>
   <tender>
      <name>CASH</name>
      <total_money>
         <amount>3500</amount>
         <currency>JOD</currency>
      </total_money>
      <type>CASH</type>
   </tender>
   <tip_money>
      <amount>0</amount>
      <currency>JOD</currency>
   </tip_money>
   <total_collected_money>
      <amount>3500</amount>
      <currency>JOD</currency>
   </total_collected_money>
   <transaction_id>37a5f57a-48bc-483d-91b7-88c8b1b9509c</transaction_id>
</transaction>
EOT
        ],
        [
            'type' => 'array',
            'value' => [
                [
                    '_id' => '589c493e5f2687111bb6d800',
                    'business_id' => '3f522ee8-7e69-4d78-aeb5-5278aaf21558',
                    'location_id' => '96e9975b-b1bf-47ee-aeaf-63518022e95e',
                    'transaction_id' => '37a5f57a-48bc-483d-91b7-88c8b1b9509c',
                    'receipt_id' => 'Cj9uohMQNVflSq7taYtVRk',
                    'serial_number' => 'C1-498',
                    'dining_option' => 'In-House',
                    'creation_time' => '2017-02-09T10:49:34.000Z',
                    'discount_money' => [
                        'amount' => 0,
                        'currency' => 'JOD',
                    ],
                    'additive_tax_money' => [
                        'amount' => 0,
                        'currency' => 'JOD',
                    ],
                    'inclusive_tax_money' => [
                        'amount' => 483,
                        'currency' => 'JOD',
                    ],
                    'refunded_money' => [
                        'amount' => 0,
                        'currency' => 'JOD',
                    ],
                    'tax_money' => [
                        'amount' => 483,
                        'currency' => 'JOD',
                    ],
                    'tip_money' => [
                        'amount' => 0,
                        'currency' => 'JOD',
                    ],
                    'total_collected_money' => [
                        'amount' => 3500,
                        'currency' => 'JOD',
                    ],
                    'creator' => [
                        'id' => '00000000-0000-0000-0000-000000000000',
                        'name' => 'John Doe',
                        'email' => 'anonymous@example.com',
                    ],
                    'tender' => [
                        'type' => 'CASH',
                        'name' => 'CASH',
                        'total_money' => [
                            'amount' => 3500,
                            'currency' => 'JOD',
                        ],
                    ],
                    'taxes' => [
                        'id' => 'cfc92a12-f847-4942-b6ec-1454d194c9ba',
                        'name' => 'Sales Tax',
                        'rate' => 0.16,
                        'inclusion_type' => 'INCLUSIVE',
                        'is_custom_amount' => true,
                        'applied_money' => [
                            'amount' => 483,
                            'currency' => 'JOD',
                        ],
                    ],
                    'itemization' => [
                        'id' => '788cb9cb-106f-4d32-ac48-df9e8433ff50',
                        'name' => 'Boneless Chicken Wings',
                        'quantity' => 1,
                        'total_money' => [
                            'amount' => 3500,
                            'currency' => 'JOD',
                        ],
                        'single_quantity_money' => [
                            'amount' => 3500,
                            'currency' => 'JOD',
                        ],
                        'gross_sales_money' => [
                            'amount' => 3017,
                            'currency' => 'JOD',
                        ],
                        'discount_money' => [
                            'amount' => 0,
                            'currency' => 'JOD',
                        ],
                        'net_sales_money' => [
                            'amount' => 3017,
                            'currency' => 'JOD',
                        ],
                        'category' => [
                            'id' => 'a9895c94-15cc-4db1-bbad-fe62d218c931',
                            'name' => 'Appetizers',
                        ],
                        'variation' => [
                            'id' => '37b64192-6b0f-479d-aeee-3c382a0671b9',
                            'name' => 'Plate',
                            'pricing_type' => 'FIXED',
                            'price_money' => [
                                'amount' => 3500,
                                'currency' => 'JOD',
                            ],
                        ],
                        'taxes' => [
                            'id' => 'cfc92a12-f847-4942-b6ec-1454d194c9bت&&',
                            'name' => 'Sales Tax',
                            'rate' => 0.16,
                            'inclusion_type' => 'INCLUSIVE',
                            'is_custom_amount' => true,
                            'applied_money' => [
                                'amount' => 483,
                                'currency' => 'JOD',
                            ],
                        ],
                        'discounts' => [],
                        'modifiers' => [
                            'id' => '7424ae3d-36bc-4c0c-b790-310614905aed',
                            'name' => '6 Pieces',
                            'quantity' => 1,
                            'applied_money' => [
                                'amount' => 0,
                                'currency' => 'JOD',
                            ],
                        ],
                    ],
                ]
            ]
        ]
    ];
}