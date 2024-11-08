<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LineTestController extends Controller
{

    private $channelSecret = 'b444c771d366e34a99e32b1b188881be';
    private $channelAccessToken = 'wcpKz9lUUnYU/6JokWADLr1T3oHviFhDCqHhtP/S6M9Xr/646L+Difno48Ne0EY1jX3rGRbsQFf3IrontTyJZLYFKoDyifIC3sIJDGENbNPi6Py656EEmrNBqei+sjqORw1Q8gZQh4SExbdBeyEu3AdB04t89/1O/w1cDnyilFU=';

    public function index()
    {

        return view('linetest');
    }

    public function post()
    {

        // return response()->json([
        //     'message' => 'Data received successfully!',
        //     'data' => "aaaaabbbbb",
        // ], 200);



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


                if (substr($event['message']['text'], 0, 2) === '@1') {


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
}
