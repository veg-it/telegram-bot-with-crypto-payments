<?php

//Needed for crypto pay api
use Klev\CryptoPayApi\Methods\CreateInvoice;
use Klev\CryptoPayApi\CryptoPay;
use Klev\CryptoPayApi\Enums\PaidBtnName;

require_once './vendor/autoload.php';

//bot.php (require Bot class)
require_once 'bot.php';

function run()
{
  //Telegram Bot API Token + Crypto Payments Api toke
  include('setting.php');

  //Create new bot
  $bot = new Bot($tg_token);
  //Create new CryptoBot api 
  $api = new CryptoPay($cp_token);
  //For testnet $api = new CryptoPay($cp_token, true); 

  //If /start message send
  if ($bot->d_text == '/start') {
    //Inline buttons setup
    $buttons = '[ 
          [
            {"text": "Buy", "callback_data":"buy"}
          ]
        ]';
    //Text message setup
    $text = "Hi @" . $bot->d_username . " , you can buy a bot from me to copy trades of traders from me to copy trades of traders from the Binance leaderboard!!\nMore information at the link below 👇 or contact the administrator: @Copy_Trading_Binance\nhttps://telegra.ph/Answers-to-questions-Copytrading-12-08";
    //Send message
    $bot->message($text, $buttons);
  }

  //If button Buy pressed
  if ($bot->d_cbdata == 'buy') {
    //Inline buttons setup
    $buttons = '[ 
            [
              {"text": "Bybit", "callback_data":"0"},
              {"text": "Binance", "callback_data":"1"},
              {"text": "Test 3", "callback_data":"2"}
            ],
            [
              {"text": "Source code Bybit", "callback_data":"3"}
            ],
            [
              {"text": "Source code Binance", "callback_data":"4"}
            ],
            [
              {"text": "Source code test 3", "callback_data":"5"}
            ]
          ]';
    //Text message setup
    $text = "Bot cost 349 USDT for Binance and Bybit!\nSource code - 1499 USDT";
    //Send message
    $bot->message($text, $buttons);
  }

  //
  if ($bot->d_cbdata == '0') {
    //Create invoice
    $data = new CreateInvoice($currency[0], $price[0]);
    //Idc, but api exaple have this line
    $data->allow_anonymous = false;
    //After payment button type
    $data->paid_btn_name = 'callback';
    //Redirect to main bot
    $data->paid_btn_url = 'https://t.me/'.$bot_name;
    //Send invoice
    $createdInvoice = $api->createInvoice($data);
    
    //buttons setup
    $buttons = '[ 
          [
            {"text": "Pay '.$price[0].$currency[0].'", "url":"' . $createdInvoice->pay_url . '"}
          ],
          [
            {"text": "Check payment", "callback_data": "check_' . $createdInvoice->invoice_id . '_0"}
          ]
        ]';
    //Text message setup
    $text = "Link to payment: " . $createdInvoice->pay_url;
    //Send message
    $bot->message($text, $buttons);
  }

  if ($bot->d_cbdata == '1') {
    //Create invoice
    $data = new CreateInvoice($currency[1], $price[1]);
    //Idc, but api exaple have this line
    $data->allow_anonymous = false;
    //After payment button type
    $data->paid_btn_name = 'callback';
    //Redirect to main bot
    $data->paid_btn_url = 'https://t.me/'.$bot_name;
    //Send invoice
    $createdInvoice = $api->createInvoice($data);
    
    //buttons setup
    $buttons = '[ 
          [
            {"text": "Pay '.$price[1].$currency[1].'", "url":"' . $createdInvoice->pay_url . '"}
          ],
          [
            {"text": "Check payment", "callback_data": "check_' . $createdInvoice->invoice_id . '_1"}
          ]
        ]';
    //Text message setup
    $text = "Link to payment: " . $createdInvoice->pay_url;
    //Send message
    $bot->message($text, $buttons);
  }

  if ($bot->d_cbdata == '2') {
    //Create invoice
    $data = new CreateInvoice($currency[2], $price[2]);
    //Idc, but api exaple have this line
    $data->allow_anonymous = false;
    //After payment button type
    $data->paid_btn_name = 'callback';
    //Redirect to main bot
    $data->paid_btn_url = 'https://t.me/'.$bot_name;
    //Send ivoice
    $createdInvoice = $api->createInvoice($data);
    
    //buttons setup
    $buttons = '[ 
          [
            {"text": "Pay '.$price[2].$currency[2].'", "url":"' . $createdInvoice->pay_url . '"}
          ],
          [
            {"text": "Check payment", "callback_data": "check_' . $createdInvoice->invoice_id . '_2"}
          ]
        ]';
    //Text message setup
    $text = "Link to payment: " . $createdInvoice->pay_url;
    //Send message
    $bot->message($text, $buttons);
  }

  if ($bot->d_cbdata == '3') {
    //Create invoice
    $data = new CreateInvoice($currency[3], $price[3]);
    //Idc, but api exaple have this line
    $data->allow_anonymous = false;
    //After payment button type
    $data->paid_btn_name = 'callback';
    //Redirect to main bot
    $data->paid_btn_url = 'https://t.me/'.$bot_name;
    //Send invoice
    $createdInvoice = $api->createInvoice($data);
    
    //buttons setup
    $buttons = '[ 
          [
            {"text": "Pay '.$price[3].$currency[3].'", "url":"' . $createdInvoice->pay_url . '"}
          ],
          [
            {"text": "Check payment", "callback_data": "check_' . $createdInvoice->invoice_id . '_3"}
          ]
        ]';
    //Text message setup
    $text = "Link to payment: " . $createdInvoice->pay_url;
    //Send message
    $bot->message($text, $buttons);
  }

  if ($bot->d_cbdata == '4') {
    //Create invoice
    $data = new CreateInvoice($currency[4], $price[4]);
    //Idc, but api exaple have this line
    $data->allow_anonymous = false;
    //After payment button type
    $data->paid_btn_name = 'callback';
    //Redirect to main bot
    $data->paid_btn_url = 'https://t.me/'.$bot_name;
    //Send invoice
    $createdInvoice = $api->createInvoice($data);
    
    //buttons setup
    $buttons = '[ 
          [
            {"text": "Pay '.$price[4].$currency[4].'", "url":"' . $createdInvoice->pay_url . '"}
          ],
          [
            {"text": "Check payment", "callback_data": "check_' . $createdInvoice->invoice_id . '_4"}
          ]
        ]';
    //Text message setup
    $text = "Link to payment: " . $createdInvoice->pay_url;
    //Send message
    $bot->message($text, $buttons);
  }

  if ($bot->d_cbdata == '5') {
    //Create invoice
    $data = new CreateInvoice($currency[5], $price[5]);
    //Idc, but api exaple have this line
    $data->allow_anonymous = false;
    //After payment button type
    $data->paid_btn_name = 'callback';
    //Redirect to main bot
    $data->paid_btn_url = 'https://t.me/'.$bot_name;
    //Send invoice
    $createdInvoice = $api->createInvoice($data);
    
    //buttons setup
    $buttons = '[ 
          [
            {"text": "Pay '.$price[5].$currency[5].'", "url":"' . $createdInvoice->pay_url . '"}
          ],
          [
            {"text": "Check payment", "callback_data": "check_' . $createdInvoice->invoice_id . '_5"}
          ]
        ]';
    //Text message setup
    $text = "Link to payment: " . $createdInvoice->pay_url;
    //Send message
    $bot->message($text, $buttons);
  }

  //if callback data have 'check'
  if (stripos($bot->d_cbdata, 'check') !== false) {
    //return all invoices list
    $rez = $api->getInvoices();
    //prepare message text
    $text = '';
    //explode callback message
    $check = explode('_', $bot->d_cbdata);
    //check foreach invoice, if needed invoice payed, return message and send instructions
    foreach ($rez as $invoice) {
      if ($invoice->invoice_id == $check[1]) {
        if ($invoice->status == 'paid')
        $text = $ordered_item[$check[2]];
        $bot->delete_message_from_cb();
      }
    }
    //Send message
    $bot->message($text);
  }
}
run();
?>