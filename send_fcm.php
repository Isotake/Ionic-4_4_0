<?php
class Notification {
  // Firebase console:Overview > プロジェクトの設定 > クラウドメッセージング > サーバーキー
  private static $apiKey = "AAAAxiHpxgU:APA91bHg-uWC9uUrHA35dVYFNYuhoxt6Vdi_QX-2geFC6of91f3N4LxEkXmtDwhGLaBt4_hApudmebfRCeykfTx34nuGrM-uSwNIoP0zgjLBt8v8V4niVbDUOprWimji_xjDqYWOkMK9";
  private static $url = "https://fcm.googleapis.com/fcm/send";
  static public function send($pushTokens, $message) {
    $headers = [
      "Authorization: key=".self::$apiKey,
      "Content-Type: application/json"
    ];
    $fields = [
      "registration_ids" => is_array($pushTokens) ? $pushTokens : [$pushTokens],
      "notification" => [
        "text" => $message
      ]
    ];
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, self::$url);
    curl_setopt($handle, CURLOPT_POST, true);
    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($handle);
    curl_close($handle);
    return $result;
  }
}
$tokens = ['fM1p9hNLhT4:APA91bEhKKOFfLk24rj_rsWeUTaozGJD1d1K4yNS51xlflylet63hwSoX8j_RrUunp8WflOlz7cudBA-Dm52DtEejVlkREHhwHaGqZqm6at7Yx7HdPNa-gC3zxOMSTp0GB1rDzSscnJv'];
$message = 'develop test - send-fcm';
$result = Notification::send($tokens, $message);
var_dump($result);

