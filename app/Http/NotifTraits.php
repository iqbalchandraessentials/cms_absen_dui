<?php

namespace App\Http;

// use App\Models\Student;
use Illuminate\Http\Request;

trait NotifTraits
{
      public function sendNotification($topic_req, $title_req, $message_req, $page)
      {
            $apiKey = config('config-absensi.firebase.key');

            $url = config('config-absensi.firebase.url');

            // Parse JSON request data
            // $data = json_decode(request()->getContent(), true);
            // $topic = $data['topic'];
            // $title = $data['title'];
            // $message = $data['message'];
            $topic =  $topic_req;
            $title = $title_req;
            $message = $message_req;

            $headers = array(
                  'Authorization: key=' . $apiKey,
                  'Content-Type: application/json'
            );

            $data = array(
                  'to' => '/topics/' . $topic,
                  'notification' => array(
                        'title' => $title,
                        'body' => $message,
                        'sound' => 'default',
                  ),
                  'data' => array(
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        'screen' => $page,
                  ),
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            $result = curl_exec($ch);

            if ($result === FALSE) {
                  return response()->json(['error' => 'Curl failed: ' . curl_error($ch)], 500);
            }

            curl_close($ch);

            return response()->json(['success' => 'Notification sent successfully', 'result' => $result]);
      }
}
