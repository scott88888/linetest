<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LineTest;
use Carbon\Carbon;

class LineTestController extends Controller
{

    // private $channelSecret = 'b444c771d366e34a99e32b1b188881be';
    // private $channelAccessToken = 'wcpKz9lUUnYU/6JokWADLr1T3oHviFhDCqHhtP/S6M9Xr/646L+Difno48Ne0EY1jX3rGRbsQFf3IrontTyJZLYFKoDyifIC3sIJDGENbNPi6Py656EEmrNBqei+sjqORw1Q8gZQh4SExbdBeyEu3AdB04t89/1O/w1cDnyilFU=';
    private $channelSecret = '0ae85dd82a38c57730d5b6b6d8a77752';
    private $channelAccessToken = 'mWxt76XBmn49LyKrny9x3swvE+llc3eoqlILbaI52BA9hrPBg/Kgg1ntTQ94i+kynCYZOISdgPXxsm0YtZwmktYZHXSS+fRDRmeomvqTeT0WR8GvQzlYv9Xjo4uJ7y8PT6PmgU50X6RRbknt2H3VJgdB04t89/1O/w1cDnyilFU=';

    public function index()
    {

        return view('linetest');
    }

    public function post()
    {
        
        // for ($i=0; $i < 5; $i++) { 
        //$data = "車位";
        // $this->insertData($data);
        // }
        // $result= $this->selectData($data);
        // var_dump( $result);
        // exit;
        // $da ='@s車位7樓34';
        // echo substr($da,2,6);
        // exit;


        // 獲取請求內容
        $httpRequestBody = file_get_contents('php://input');
        // 檢查是否為來自Line
        $signature = base64_encode(hash_hmac('sha256', $httpRequestBody, $this->channelSecret, true));
        if ($signature != $_SERVER['HTTP_X_LINE_SIGNATURE']) {
            exit;
        }
        $userRequest = json_decode($httpRequestBody, true);

        // 同一個webhook可能有來自多個使用者的請求
        foreach ($userRequest['events'] as $key => $event) {
            if ($event['message']['type'] == 'text') {
                // 回覆內容設定
                $message = $event['message']['type'] ;
                if (substr($event['message']['text'], 0, 2) === '@s') {
                    $data =substr($event['message']['text'],2,6);
                    $result = $this->selectData($data);
                    $contents = [];
                    foreach ($result as $item) {
                        $contents[] = [
                            'type' => 'text',
                            'text' => $item['index'] . '. ' . $item['message'] . ' - ' . $item['time']
                        ];
                    }                    
                    $flexMessage = [
                        'type' => 'bubble',
                        'body' => [
                            'type' => 'box',
                            'layout' => 'vertical',
                            'contents' => $contents // 動態生成的內容
                        ]
                    ];
                    $payload = [
                        'replyToken' => $event['replyToken'],
                        'messages'   => [
                            [
                                'type' => 'flex',
                                'altText' => 'Flex Message Example',
                                'contents' => $flexMessage,
                            ]
                        ],
                    ];
                    $this->curlsetopt($payload);
                }

                if (substr($event['message']['text'], 0, 2) === '@i') {       
                    $data = substr($event['message']['text'],2);
                    $result = $this->insertData($data);
                    if ($result == true) {
                        $message = '儲存訊息 : "' . $event['message']['text'].'"成功';
                    }else{
                        $message = '儲存訊息 : "' . $event['message']['text'].'"失敗';
                    }
                    
            
                    $payload = [
                        'replyToken' => $event['replyToken'],
                        'messages'   => [
                            [
                                'type' => 'text',
                                'text' => $message,
                            ],
                        ],
                    ];
                    $this->curlsetopt($payload);
                }

            }
        }
    }
    public function curlsetopt($payload)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/bot/message/reply');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' .  $this->channelAccessToken,
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function temp() {
               // 獲取請求內容
               $httpRequestBody = file_get_contents('php://input');



               $userRequest = json_decode($httpRequestBody, true);
       
               // 同一個webhook可能有來自多個使用者的請求
               foreach ($userRequest['events'] as $key => $event) {
                   if ($event['message']['type'] == 'text') {
                       // 回覆內容設定
       
                       if ($event['message']['text'] == 'aaa') {
                           $message = '已收到訊息 : ' . $event['message']['text'];
                           $payload = [
                               'replyToken' => $event['replyToken'],
                               'messages'   => [
                                   [
                                       'type' => 'text',
                                       'text' => $message,
                                   ],
                               ],
                           ];
       
                           $this->curlsetopt($payload);
                       }
                       if ($event['message']['text'] == 'bbb') {
                        $flexMessage = [
                            "type" => "bubble",
                            "hero" => [
                                "type" => "image",
                                "url" => "https://developers-resource.landpress.line.me/fx/img/01_3_movie.png",
                                "size" => "full",
                                "aspectRatio" => "20:13",
                                "aspectMode" => "cover",
                                "action" => [
                                    "type" => "uri",
                                    "uri" => "https://line.me/"
                                ]
                            ],
                            "body" => [
                                "type" => "box",
                                "layout" => "vertical",
                                "spacing" => "md",
                                "contents" => [
                                    [
                                        "type" => "text",
                                        "text" => "BROWN'S ADVENTURE\nIN MOVIE",
                                        "wrap" => true,
                                        "weight" => "bold",
                                        "gravity" => "center",
                                        "size" => "xl"
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "margin" => "md",
                                        "contents" => [
                                            [
                                                "type" => "icon",
                                                "size" => "sm",
                                                "url" => "https://developers-resource.landpress.line.me/fx/img/review_gold_star_28.png"
                                            ],
                                            [
                                                "type" => "icon",
                                                "size" => "sm",
                                                "url" => "https://developers-resource.landpress.line.me/fx/img/review_gold_star_28.png"
                                            ],
                                            [
                                                "type" => "icon",
                                                "size" => "sm",
                                                "url" => "https://developers-resource.landpress.line.me/fx/img/review_gold_star_28.png"
                                            ],
                                            [
                                                "type" => "icon",
                                                "size" => "sm",
                                                "url" => "https://developers-resource.landpress.line.me/fx/img/review_gold_star_28.png"
                                            ],
                                            [
                                                "type" => "icon",
                                                "size" => "sm",
                                                "url" => "https://developers-resource.landpress.line.me/fx/img/review_gray_star_28.png"
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => "4.0",
                                                "size" => "sm",
                                                "color" => "#999999",
                                                "margin" => "md",
                                                "flex" => 0
                                            ]
                                        ]
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "vertical",
                                        "margin" => "lg",
                                        "spacing" => "sm",
                                        "contents" => [
                                            [
                                                "type" => "box",
                                                "layout" => "baseline",
                                                "spacing" => "sm",
                                                "contents" => [
                                                    [
                                                        "type" => "text",
                                                        "text" => "Date",
                                                        "color" => "#aaaaaa",
                                                        "size" => "sm",
                                                        "flex" => 1
                                                    ],
                                                    [
                                                        "type" => "text",
                                                        "text" => "Monday 25, 9:00PM",
                                                        "wrap" => true,
                                                        "size" => "sm",
                                                        "color" => "#666666",
                                                        "flex" => 4
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "box",
                                                "layout" => "baseline",
                                                "spacing" => "sm",
                                                "contents" => [
                                                    [
                                                        "type" => "text",
                                                        "text" => "Place",
                                                        "color" => "#aaaaaa",
                                                        "size" => "sm",
                                                        "flex" => 1
                                                    ],
                                                    [
                                                        "type" => "text",
                                                        "text" => "7 Floor, No.3",
                                                        "wrap" => true,
                                                        "color" => "#666666",
                                                        "size" => "sm",
                                                        "flex" => 4
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "box",
                                                "layout" => "baseline",
                                                "spacing" => "sm",
                                                "contents" => [
                                                    [
                                                        "type" => "text",
                                                        "text" => "Seats",
                                                        "color" => "#aaaaaa",
                                                        "size" => "sm",
                                                        "flex" => 1
                                                    ],
                                                    [
                                                        "type" => "text",
                                                        "text" => "C Row, 18 Seat",
                                                        "wrap" => true,
                                                        "color" => "#666666",
                                                        "size" => "sm",
                                                        "flex" => 4
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "vertical",
                                        "margin" => "xxl",
                                        "contents" => [
                                            [
                                                "type" => "image",
                                                "url" => "https://developers-resource.landpress.line.me/fx/img/linecorp_code_withborder.png",
                                                "aspectMode" => "cover",
                                                "size" => "xl",
                                                "margin" => "md"
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => "You can enter the theater by using this code instead of a ticket",
                                                "color" => "#aaaaaa",
                                                "wrap" => true,
                                                "margin" => "xxl",
                                                "size" => "xs"
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ];
            
            
                        $payload = [
                            'replyToken' => $event['replyToken'],
                            'messages'   => [
                                [
                                    'type' => 'flex',
                                    'altText' => 'Flex Message Example',
                                    'contents' => $flexMessage,
                                ]
                            ],
                        ];
            
                        $this->curlsetopt($payload);
                    }
            
            
                    if (substr($event['message']['text'], 0, 3) === '@儲存') {
            
            
                        $payload = [
                            'replyToken' => $event['replyToken'],
                            'messages'   => [
                                [
                                    "type" => "video",
                                    'originalContentUrl' => 'https://dl.4kdownload.com/video/videodownloaderplus/howto-download-video-in-mp4@h264.mp4',
                                    'previewImageUrl' => 'https://www.tunefab.tw/uploads/sites/1026/d/download-youtube-to-mp4.jpg',
                                    'trackingId' => 'video-' . uniqid(), // 可選，用於追蹤
                                    'duration' => 60000, // 可選，影片長度（毫秒）
                                ],
                            ],
                        ];
                        $this->curlsetopt($payload);
                    }
       
                   }
               }

    }

    public function insertData($data)
    {
        try {
            // 嘗試新增一筆資料
            $newRecord = LineTest::create([
                'messages' => $data,
                'time' => now(), // 設置當前時間
            ]);    
            return $newRecord ? true : false;
        } catch (\Exception $e) {
            // 如果有錯誤，捕捉並返回錯誤訊息
            return false;
        }

       
    }

    public function selectData($data)
    {
        // $messages = LineTest::where('messages', 'like', '%'.$data.'%')->get();
        $messages = LineTest::where('messages', 'like', '%' . $data . '%')
        ->orderBy('time', 'desc')
        ->limit(5)
        ->get();

        $result = [];

        foreach ($messages as $key => $msg) {
            $result[] = [
                'index' => $key + 1, // 顯示項目索引（從1開始）
                'message' => $msg->messages,
                'time' => Carbon::parse($msg->time)->format('Y/m/d H:i:s')  // 將時間格式化
            ];
        }

        return $result; // 回傳結果陣列
    }
}
