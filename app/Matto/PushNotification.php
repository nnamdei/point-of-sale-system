<?php
namespace App\Matto;

use Session;

class PushNotification{
    protected $heading;
    protected $body;
    protected $url;
    protected $btns;


    public function __construct($n = ['heading' => '','body' => ''], $url='', $btns = array())
    {
        $this->heading = $n['heading'];
        $this->body = $n['body'];
        $this->url = $url;
        $this->btns = $btns;
    }

    public function send(){
        $heading = array(
            "en" => $this->heading
        );
        $content      = array(
            "en" => $this->body
        );

        $buttons = array();

        for($i = 0; $i < count($this->btns); $i++){
            array_push($buttons, array(
                "id" => 'btn'.($i+1),
                "text" => $this->btns[$i]['text'],
                "icon" => $this->btns[$i]['icon'],
                "url" => $this->btns[$i]['url']
            ));
            }

    
        $fields = array(
            'app_id' => "f3f6aa69-25ef-40f2-86c2-0c85f8c8a42f",
            'included_segments' => array(
                'All'
            ),
            'data' => array(
                "foo" => "bar"
            ),
            'headings' => $heading,
            'contents' => $content,
        
        );
        if($this->url !== ''){
            $fields['url'] = $this->url;
        }
        if(!empty($buttons)){//If there are buttons available
            $field['web_buttons'] = $buttons;
        }
        
        $fields = json_encode($fields);
        //print("\nJSON sent:\n");
        //print($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic MDBjMjljNWUtNTc1ZC00MGExLTllOWMtOTg0ZDhiNzU3NTIy'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        
        $response = curl_exec($ch);
        curl_close($ch);
        Session::flash('info', 'Push notifications sent to subscribed users');
        return $response;
    }

    public function isNotifiable($r){
        return (isset($r['notification']) && $r['notification'] == 'true' ? true : false );
      }

}
?>