<?php
class Bot {
    protected $token;
    public 
        $d_text, 
        $d_fname, 
        $d_username, 
        $d_type, 
        $d_date,
        $d_chatid, 
        $d_messageid, 
        $d_cbdata, 
        $d_cbid,
        $d_cbmsid,
        $d_cbusername,
        $d_cduserid;

    //get message + bot constructor
    public function __construct($token) {
        $arr = file_get_contents('php://input');
        $data = json_decode($arr, true);
        $this->update($data);
        $this->token = $token;
    }

    //Get message params and put in bot 
    function update($data)
    {
        $this->d_text = $data['message']['text'];
        $this->d_fname = $data['message']['chat']['first_name'];
        $this->d_username = $data['message']['chat']['username'];
        $this->d_type = $data['message']['chat']['type'];
        $this->d_date = $data['message']['date'];
        $this->d_chatid = $data['message']['chat']['id'];
        $this->d_messageid = $data['message']['message_id'];
        //callback
        $this->d_cbdata = $data['callback_query']['data'];
        $this->d_cbid = $data['callback_query']['message']['chat']['id'];
        $this->d_cbmsid = $data['callback_query']['message']['message_id'];
        $this->d_cbusername = $data['callback_query']['from']['username'];
        $this->d_cduserid = $data['callback_query']['from']['id'];
    }

    //Send message with inline keyboard
    function message($text, $buttons='')
    {   
        if ($this->d_chatid) {
          $chat_id = $this->d_chatid;
        } 
        if ($this->d_cbid) {
          $chat_id = $this->d_cbid;
        }
        if ($buttons != ''){
          $keyb =  inline_keyboard($buttons);
          $array1 = array(
              'chat_id' => $chat_id,
              'text' => $text,
              'disable_web_page_preview' => true,
              'parse_mode' => 'HTML',
              'reply_markup' => $keyb
          );
        } else {
          $array1 = array(
              'chat_id' => $chat_id,
              'disable_web_page_preview' => true,
              'parse_mode' => 'HTML',
              'text' => $text
          );
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot".$this->token."/sendMessage");
        curl_custom_postfields($ch, $array1); //above custom function
        curl_exec($ch);
    }

    //Function for delete message by callback message id
    function delete_message_from_cb()
    {  
        $array1 = array(
            'chat_id' => $this->d_cbid,
            'message_id' => $this->d_cbmsid
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot".$this->token."/deleteMessage");
        curl_custom_postfields($ch, $array1); //above custom function
        curl_exec($ch);
    }
}

//Create inline keyboard
function inline_keyboard($keyb)
{
    //$keyb -  '[ [{"text": "text", "callback_data":"callback"}], [{"text": "text", "callback_data":"callback"}] ]
    $a = '{"inline_keyboard":' . $keyb . '}';
    return $a;
}

//Create keyboard
function keyboard($keyb, $res, $onetk, $selc)
{
    //$keyb - клавиатура [["opt 1","opt 2","opt 3"],["menu"]]
    //$res -  resize_keyboard (true/false)
    //$onetk - one_time_keyboard (true/false)
    //$selc - selective (true/false) 
    $a = '{"keyboard":' . $keyb . ', "resize_keyboard":' . $res . ', "one_time_keyboard":' . $onetk . ', "selective":' . $selc . '}';
    return $a;
}


//Function for prepare post request
function curl_custom_postfields($ch, array $assoc = array(), array $files = array())
{
    // invalid characters for "name" and "filename"
    static $disallow = array("\0", "\"", "\r", "\n");

    // build normal parameters
    foreach ($assoc as $k => $v) {
        $k = str_replace($disallow, "_", $k);
        $body[] = implode(
            "\r\n",
            array(
                "Content-Disposition: form-data; name=\"{$k}\"",
                "",
                filter_var($v),
            )
        );
    }

    // build file parameters
    foreach ($files as $k => $v) {
        switch (true) {
            case false === $v = realpath(filter_var($v)):
            case !is_file($v):
            case !is_readable($v):
                continue; // or return false, throw new InvalidArgumentException
        }
        $data = file_get_contents($v);
        $v = call_user_func("end", explode(DIRECTORY_SEPARATOR, $v));
        $k = str_replace($disallow, "_", $k);
        $v = str_replace($disallow, "_", $v);
        $body[] = implode(
            "\r\n",
            array(
                "Content-Disposition: form-data; name=\"{$k}\"; filename=\"{$v}\"",
                "Content-Type: image/jpeg",
                "",
                $data,
            )
        );
    }

    // generate safe boundary
    do {
        $boundary = "---------------------" . md5(mt_rand() . microtime());
    } while (preg_grep("/{$boundary}/", $body));

    // add boundary for each parameters
    array_walk($body, function (&$part) use ($boundary) {
        $part = "--{$boundary}\r\n{$part}";
    });

    // add final boundary
    $body[] = "--{$boundary}--";
    $body[] = "";
    // set options
    return @curl_setopt_array(
        $ch,
        array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => implode("\r\n", $body),
            CURLOPT_HTTPHEADER => array(
                "Expect: 100-continue",
                "Content-Type: multipart/form-data; boundary={$boundary}",
                // change Content-Type

            ),
        )
    );
}
?>