<?php

namespace Illuminate\Framework;

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;


class Sms
{
    public function __construct($numberPhone, $message, $fromName)
    {
        $base_url = 'https://dk5pkv.api.infobip.com';
        $api_key = '711157fdef5f52bb92a29f16b221400d-35f72705-01d9-4da5-a055-fab6d11a4359';

        $configuration = new Configuration(host: $base_url, apiKey: $api_key);

        $api = new SmsApi(config: $configuration);

        $destination = new SmsDestination(to: $numberPhone);

        $message = new SmsTextualMessage(
            destinations: [$destination],
            text: $message,
            from: $fromName
        );

        $request = new SmsAdvancedTextualRequest(messages: [$message]);

        // Thực hiện gửi tin nhắn
        $response = $api->sendSmsMessage($request);

        if (!empty($response->getMessages()) && !empty($response->getMessages()[0]->getStatus())) {
            $status = $response->getMessages()[0]->getStatus()->getGroupName();
            return $status;
        } else {
            return 'Unknown status.';
        }
    }
}
