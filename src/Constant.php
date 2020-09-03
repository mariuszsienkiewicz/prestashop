<?php

namespace Gett\MyparcelBE;

use Configuration;

class Constant
{
    const POSTNL_DEFAULT_CARRIER = 'MYPARCEL_DEFAULT_CARRIER';

    const MENU_API_SETTINGS = 0;
    const MENU_GENERAL_SETTINGS = 1;
    const MENU_LABEL_SETTINGS = 2;
    const MENU_ORDER_SETTINGS = 3;
    const MENU_CUSTOMS_SETTINGS = 4;
    const MENU_CARRIER_SETTINGS = 5;

    const API_KEY_CONFIGURATION_NAME = 'MY_PARCEL_API_KEY';
    const API_LOGGING_CONFIGURATION_NAME = 'MY_PARCEL_API_LOGGING';

    const PACKAGE_TYPE_CONFIGURATION_NAME = 'MY_PARCEL_PACKAGE_TYPE';
    const ONLY_RECIPIENT_CONFIGURATION_NAME = 'MY_PARCEL_RECIPIENT_ONLY';
    const AGE_CHECK_CONFIGURATION_NAME = 'MY_PARCEL_AGE_CHECK';
    const PACKAGE_FORMAT_CONFIGURATION_NAME = 'MY_PARCEL_PACKAGE_FORMAT';

    const RETURN_PACKAGE_CONFIGURATION_NAME = 'MY_PARCEL_RETURN_PACKAGE';
    const SIGNATURE_REQUIRED_CONFIGURATION_NAME = 'MY_PARCEL_SIGNATURE_REQUIRED';
    const INSURANCE_CONFIGURATION_NAME = 'MY_PARCEL_INSURANCE';
    const CUSTOMS_FORM_CONFIGURATION_NAME = 'MY_PARCEL_CUSTOMS_FORM';
    const CUSTOMS_CODE_CONFIGURATION_NAME = 'MY_PARCEL_CUSTOMS_CODE';
    const DEFAULT_CUSTOMS_CODE_CONFIGURATION_NAME = 'MY_PARCEL_DEFAULT_CUSTOMS_CODE';
    const CUSTOMS_ORIGIN_CONFIGURATION_NAME = 'MY_PARCEL_CUSTOMS_ORIGIN';
    const DEFAULT_CUSTOMS_ORIGIN_CONFIGURATION_NAME = 'MY_PARCEL_DEFAULT_CUSTOMS_ORIGIN';
    const CUSTOMS_AGE_CHECK_CONFIGURATION_NAME = 'MY_PARCEL_CUSTOMS_AGE_CHECK';

    const SINGLE_LABEL_CREATION_OPTIONS = [
        'packageType'=> self::PACKAGE_TYPE_CONFIGURATION_NAME,
        'packageFormat' => self::PACKAGE_FORMAT_CONFIGURATION_NAME,
        'onlyRecipient' => self::ONLY_RECIPIENT_CONFIGURATION_NAME,
        'ageCheck' => self::AGE_CHECK_CONFIGURATION_NAME,
        'returnUndelivered' => self::RETURN_PACKAGE_CONFIGURATION_NAME,
        'signatureRequired' => self::SIGNATURE_REQUIRED_CONFIGURATION_NAME,
        'insurance' => self::INSURANCE_CONFIGURATION_NAME,
    ];

    const PACKAGE_TYPES = [
        1 => 'package',
        2 => 'mailbox package',
        3 => 'letter',
        4 => 'digital stamp',
    ];
    const PACKAGE_FORMATS = [
        1 => 'normal',
        2 => 'large',
        3 => 'automatic',
    ];

    const SHARE_CUSTOMER_EMAIL_CONFIGURATION_NAME = 'MY_PARCEL_SHARE_CUSTOMER_EMAIL';
    const SHARE_CUSTOMER_PHONE_CONFIGURATION_NAME = 'MY_PARCEL_SHARE_CUSTOMER_PHONE';

    const LABEL_DESCRIPTION_CONFIGURATION_NAME = 'MY_PARCEL_LABEL_DESCRIPTION';
    const LABEL_OPEN_DOWNLOAD_CONFIGURATION_NAME = 'MY_PARCEL_LABEL_OPEN_DOWNLOAD';
    const LABEL_SIZE_CONFIGURATION_NAME = 'MY_PARCEL_LABEL_SIZE';
    const LABEL_POSITION_CONFIGURATION_NAME = 'MY_PARCEL_LABEL_POSITION';
    const LABEL_PROMPT_POSITION_CONFIGURATION_NAME = 'MY_PARCEL_LABEL_PROMPT_POSITION';

    const LABEL_CREATED_ORDER_STATUS_CONFIGURATION_NAME = 'MY_PARCEL_LABEL_CREATED_ORDER_STATUS';

    const CARRIER_CONFIGURATION_FIELDS = [
        'deliveryTitle',
        'dropOffDays',
        //'cutoffTime',
        'mondayCutoffTime',
        'tuesdayCutoffTime',
        'wednesdayCutoffTime',
        'thursdayCutoffTime',
        'fridayCutoffTime',
        'saturdayCutoffTime',
        'sundayCutoffTime',
        'deliveryDaysWindow',
        'dropOffDelay',
        'allowMondayDelivery',
        'priceMondayDelivery',
        'saturdayCutoffTime',
        'allowMorningDelivery',
        'deliveryMorningTitle',
        'priceMorningDelivery',
        'deliveryStandardTitle',
        'priceStandardDelivery',
        'allowEveningDelivery',
        'deliveryEveningTitle',
        'priceEveningDelivery',
        'allowSaturdayDelivery',
        'saturdayDeliveryTitle',
        'priceSaturdayDelivery',
        'allowSignature',
        'signatureTitle',
        'priceSignature',
        'allowOnlyRecipient',
        'onlyRecipientTitle',
        'priceOnlyRecipient',
        'allowPickupPoints',
        'pickupTitle',
        'pricePickup',
        'allowPickupExpress',
        'pricePickupExpress',
        'BEdeliveryTitle',
        self::PACKAGE_TYPE_CONFIGURATION_NAME,
        self::PACKAGE_FORMAT_CONFIGURATION_NAME,
        self::AGE_CHECK_CONFIGURATION_NAME,
        self::RETURN_PACKAGE_CONFIGURATION_NAME,
        self::SIGNATURE_REQUIRED_CONFIGURATION_NAME,
        self::INSURANCE_CONFIGURATION_NAME,
        self::ONLY_RECIPIENT_CONFIGURATION_NAME,
        'return_' . self::PACKAGE_TYPE_CONFIGURATION_NAME,
        'return_' . self::ONLY_RECIPIENT_CONFIGURATION_NAME,
        'return_' . self::AGE_CHECK_CONFIGURATION_NAME,
        'return_' . self::PACKAGE_FORMAT_CONFIGURATION_NAME,
        'return_' . self::RETURN_PACKAGE_CONFIGURATION_NAME,
        'return_' . self::SIGNATURE_REQUIRED_CONFIGURATION_NAME,
        'return_' . self::INSURANCE_CONFIGURATION_NAME,
    ];

    const WEEK_DAYS = [
        1 => 'monday',
        2 => 'tuesday',
        3 => 'wednesday',
        4 => 'thursday',
        5 => 'friday',
        6 => 'saturday',
        7 => 'sunday',
    ];
    const DEFAULT_CUTOFF_TIME = '17:00';

    const STATUS_CHANGE_MAIL_CONFIGURATION_NAME = 'MY_PARCEL_STATUS_CHANGE_MAIL';
    const SENT_ORDER_STATE_FOR_DIGITAL_STAMPS_CONFIGURATION_NAME = 'MY_PARCEL_SENT_ORDER_STATE_FOR_DIGITAL_STAMPS';
    const LABEL_SCANNED_ORDER_STATUS_CONFIGURATION_NAME = 'MY_PARCEL_LABEL_SCANNED_ORDER_STATUS';
    const DELIVERED_ORDER_STATUS_CONFIGURATION_NAME = 'MY_PARCEL_DELIVERED_ORDER_STATUS';
    const ORDER_NOTIFICATION_AFTER_CONFIGURATION_NAME = 'MY_PARCEL_ORDER_NOTIFICATION_AFTER';

    const IGNORE_ORDER_STATUS_CONFIGURATION_NAME = 'MY_PARCEL_IGNORE_ORDER_STATUS';
    const WEBHOOK_ID_CONFIGURATION_NAME = 'MY_PARCEL_WEBHOOK_ID';

    const POSTNL_CONFIGURATION_NAME = 'MYPARCEL_POSTNL';
    const BPOST_CONFIGURATION_NAME = 'MYPARCEL_BPOST';
    const DPD_CONFIGURATION_NAME = 'MYPARCEL_DPD';

    const CONCEPT_STATUS = 1;
    const SCANNED_STATUS = 3;
    const DELIVERED_STATUS = 7;
    const RETURN_PICKED_STATUS = 11;

    const EXCLUSIVE_FIELDS_NL = [
        self::SENT_ORDER_STATE_FOR_DIGITAL_STAMPS_CONFIGURATION_NAME,
    ];

    const CARRIER_EXCLUSIVE = [
        'POSTNL' => [
            'ALLOW_STANDARD_FORM' => ['BE' => true, 'NL' => true],
            'deliveryStandardTitle' => ['BE' => true, 'NL' => true],
            'dropOffDays' => ['BE' => true, 'NL' => true],
            'cutoffTime' => ['BE' => true, 'NL' => true],
            'deliveryDaysWindow' => ['BE' => true, 'NL' => true],
            'dropOffDelay' => ['BE' => true, 'NL' => true],
            'allowMondayDelivery' => ['BE' => false, 'NL' => true],
            'allowMorningDelivery' => ['BE' => false, 'NL' => true],
            'allowEveningDelivery' => ['BE' => false, 'NL' => true],
            'allowSaturdayDelivery' => ['BE' => false, 'NL' => false],
            'priceSaturdayDelivery' => ['BE' => false, 'NL' => false],
            'saturdayDeliveryTitle' => ['BE' => false, 'NL' => false],
            'allowSignature' => ['BE' => true, 'NL' => true],
            'priceSignature' => ['BE' => true, 'NL' => true],
            'signatureTitle' => ['BE' => true, 'NL' => true],
            'allowOnlyRecipient' => ['BE' => true, 'NL' => true],
            'priceOnlyRecipient' => ['BE' => true, 'NL' => true],
            'onlyRecipientTitle' => ['BE' => true, 'NL' => true],
            'allowPickupPoints' => ['BE' => true, 'NL' => true],
            'allowPickupExpress' => ['BE' => false, 'NL' => false],
            'pricePickupExpress' => ['BE' => false, 'NL' => false],
            // Delivery form
            'ALLOW_DELIVERY_FORM' => ['BE' => true, 'NL' => true],
            self::PACKAGE_TYPE_CONFIGURATION_NAME => [
                'BE' => [1 => true],
                'NL' => [1 => true, 2 => true, 3 => true, 4 => true]
            ],
            self::ONLY_RECIPIENT_CONFIGURATION_NAME => ['BE' => true, 'NL' => true],
            self::PACKAGE_FORMAT_CONFIGURATION_NAME => ['BE' => [1 => true], 'NL' => [1 => true, 2 => true]],
            self::SIGNATURE_REQUIRED_CONFIGURATION_NAME => ['BE' => true, 'NL' => true],
            self::INSURANCE_CONFIGURATION_NAME => ['BE' => true, 'NL' => true],
            self::AGE_CHECK_CONFIGURATION_NAME => ['BE' => true, 'NL' => true],
            self::RETURN_PACKAGE_CONFIGURATION_NAME => ['BE' => true, 'NL' => true],
            // Return form
            'ALLOW_RETURN_FORM' => ['BE' => false, 'NL' => true],
            'return_' . self::PACKAGE_TYPE_CONFIGURATION_NAME => [
                'BE' => false,
                'NL' => [1 => true, 2 => true, 3 => true, 4 => true]
            ],
            'return_' . self::ONLY_RECIPIENT_CONFIGURATION_NAME => ['BE' => false, 'NL' => true],
            'return_' . self::PACKAGE_FORMAT_CONFIGURATION_NAME => ['BE' => false, 'NL' => [1 => true, 2 => true]],
            'return_' . self::SIGNATURE_REQUIRED_CONFIGURATION_NAME => ['BE' => false, 'NL' => true],
            'return_' . self::INSURANCE_CONFIGURATION_NAME => ['BE' => false, 'NL' => true],
            'return_' . self::AGE_CHECK_CONFIGURATION_NAME => ['BE' => false, 'NL' => true],
            'return_' . self::RETURN_PACKAGE_CONFIGURATION_NAME => ['BE' => false, 'NL' => true],
        ],
        'BPOST' => [
            'ALLOW_STANDARD_FORM' => ['BE' => true, 'NL' => true],
            'deliveryStandardTitle' => ['BE' => true, 'NL' => false],
            'dropOffDays' => ['BE' => true, 'NL' => false],
            'cutoffTime' => ['BE' => true, 'NL' => false],
            'deliveryDaysWindow' => ['BE' => true, 'NL' => false],
            'dropOffDelay' => ['BE' => true, 'NL' => false],
            'allowMondayDelivery' => ['BE' => false, 'NL' => false],
            'allowMorningDelivery' => ['BE' => false, 'NL' => false],
            'allowEveningDelivery' => ['BE' => false, 'NL' => false],
            'allowSaturdayDelivery' => ['BE' => true, 'NL' => false],
            'priceSaturdayDelivery' => ['BE' => true, 'NL' => false],
            'saturdayDeliveryTitle' => ['BE' => true, 'NL' => false],
            'allowSignature' => ['BE' => true, 'NL' => false],
            'priceSignature' => ['BE' => true, 'NL' => false],
            'signatureTitle' => ['BE' => true, 'NL' => false],
            'allowOnlyRecipient' => ['BE' => false, 'NL' => false],
            'priceOnlyRecipient' => ['BE' => false, 'NL' => false],
            'onlyRecipientTitle' => ['BE' => false, 'NL' => false],
            'allowPickupPoints' => ['BE' => true, 'NL' => false],
            'allowPickupExpress' => ['BE' => false, 'NL' => false],
            'pricePickupExpress' => ['BE' => false, 'NL' => false],
            // Delivery form
            'ALLOW_DELIVERY_FORM' => ['BE' => true, 'NL' => true],
            self::PACKAGE_TYPE_CONFIGURATION_NAME => [
                'BE' => [1 => true],
                'NL' => false
            ],
            self::ONLY_RECIPIENT_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            self::PACKAGE_FORMAT_CONFIGURATION_NAME => ['BE' => [1 => true], 'NL' => false],
            self::SIGNATURE_REQUIRED_CONFIGURATION_NAME => ['BE' => true, 'NL' => false],
            self::INSURANCE_CONFIGURATION_NAME => ['BE' => true, 'NL' => false],
            self::AGE_CHECK_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            self::RETURN_PACKAGE_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            // Return form
            'ALLOW_RETURN_FORM' => ['BE' => true, 'NL' => false],
            'return_' . self::PACKAGE_TYPE_CONFIGURATION_NAME => [
                'BE' => [1 => true],
                'NL' => false
            ],
            'return_' . self::ONLY_RECIPIENT_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            'return_' . self::PACKAGE_FORMAT_CONFIGURATION_NAME => ['BE' => [1 => true], 'NL' => false],
            'return_' . self::SIGNATURE_REQUIRED_CONFIGURATION_NAME => ['BE' => true, 'NL' => false],
            'return_' . self::INSURANCE_CONFIGURATION_NAME => ['BE' => true, 'NL' => false],
            'return_' . self::AGE_CHECK_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            'return_' . self::RETURN_PACKAGE_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
        ],
        'DPD' => [
            'ALLOW_STANDARD_FORM' => ['BE' => true, 'NL' => true],
            'deliveryStandardTitle' => ['BE' => true, 'NL' => false],
            'dropOffDays' => ['BE' => true, 'NL' => false],
            'cutoffTime' => ['BE' => true, 'NL' => false],
            'deliveryDaysWindow' => ['BE' => true, 'NL' => false],
            'dropOffDelay' => ['BE' => true, 'NL' => false],
            'allowMondayDelivery' => ['BE' => false, 'NL' => false],
            'allowMorningDelivery' => ['BE' => false, 'NL' => false],
            'allowEveningDelivery' => ['BE' => false, 'NL' => false],
            'allowSaturdayDelivery' => ['BE' => false, 'NL' => false],
            'priceSaturdayDelivery' => ['BE' => false, 'NL' => false],
            'saturdayDeliveryTitle' => ['BE' => false, 'NL' => false],
            'allowSignature' => ['BE' => false, 'NL' => false],
            'priceSignature' => ['BE' => false, 'NL' => false],
            'signatureTitle' => ['BE' => false, 'NL' => false],
            'allowOnlyRecipient' => ['BE' => false, 'NL' => false],
            'priceOnlyRecipient' => ['BE' => false, 'NL' => false],
            'onlyRecipientTitle' => ['BE' => false, 'NL' => false],
            'allowPickupPoints' => ['BE' => true, 'NL' => false],
            'allowPickupExpress' => ['BE' => false, 'NL' => false],
            'pricePickupExpress' => ['BE' => false, 'NL' => false],
            // Delivery form
            'ALLOW_DELIVERY_FORM' => ['BE' => true, 'NL' => true],
            self::PACKAGE_TYPE_CONFIGURATION_NAME => [
                'BE' => [1 => true],
                'NL' => false
            ],
            self::ONLY_RECIPIENT_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            self::PACKAGE_FORMAT_CONFIGURATION_NAME => ['BE' => [1 => true], 'NL' => false],
            self::SIGNATURE_REQUIRED_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            self::INSURANCE_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            self::AGE_CHECK_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            self::RETURN_PACKAGE_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            // Return form
            'ALLOW_RETURN_FORM' => ['BE' => false, 'NL' => false],
            'return_' . self::PACKAGE_TYPE_CONFIGURATION_NAME => [
                'BE' => false,
                'NL' => false
            ],
            'return_' . self::ONLY_RECIPIENT_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            'return_' . self::PACKAGE_FORMAT_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            'return_' . self::SIGNATURE_REQUIRED_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            'return_' . self::INSURANCE_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            'return_' . self::AGE_CHECK_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
            'return_' . self::RETURN_PACKAGE_CONFIGURATION_NAME => ['BE' => false, 'NL' => false],
        ]
    ];
}
