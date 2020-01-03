<?php

$package = $_GET['p'];
$version = $_GET['v'];

function toFixed1($num){
  $str = strval($num);
  if(strpos($str, ".")===false&&$str!=""){
    $str .= ".0";
  }
  return $str;
}

// 説明のjsonを取得
$info = json_decode(file_get_contents('data/'.$package.'.json'), true);


// ---- タブ1 ----
$tab1 = [
  "class"=>"DepictionStackView",
  "tabname"=>"Details",
  "views"=>[]
];


// 警告
if($info['info']!=null){
  $tab1['views'][] = [
    "class"=>"DepictionMarkdownView",
    "markdown"=>'<center><b><span style="color:#a00;">'.$info['info'].'</span></b></center>',
    "useSpacing"=>true,
    "useRawFormat"=>true
  ];
}


// スクショ
if(count($info['screenshots'])){
  $sss = [
    "class"=>"DepictionScreenshotsView",
    "itemCornerRadius"=>6,
    "itemSize"=>'{160, 284}',
    "screenshots"=>[]
  ];
  foreach($info['screenshots'] as $ss){
    $sss['screenshots'][] = [
      "url"=>"https://repo.4nni3.com/dp/ss/".$ss,
      "accessibilityText"=>"Screenshot"
    ];
  }
  $tab1['views'][] = $sss;
}
$tab1['views'][] = [
  "class"=>"DepictionSeparatorView"
];


// 説明文
$tab1['views'][] = [
  "class"=>"DepictionHeaderView",
  "title"=>"Description"
];
$tab1['views'][] = [
  "class"=>"DepictionMarkdownView",
  "markdown"=>$info['description'],
  "useSpacing"=>true,
  "useRawFormat"=>true
];
$tab1['views'][] = [
  "class"=>"DepictionSeparatorView"
];


// 広告
/*
$tab1['views'][] = [
  "class"=>"DepictionAdmobView",
  "adUnitID"=>"ca-app-pub-7732927685565784/9541680779"
];

$tab1['views'][] = [
  "class"=>"DepictionSeparatorView"
];
*/

// リポート
$tab1['views'][] = [
  "class"=>"DepictionHeaderView",
  "title"=>"Works?"
];

$tab1['views'][] = [
  "class"=>"DepictionButtonView",
  "text"=>"Report",
  "action"=>"https://4nni3.com/report/?p=" . $package . "&v=" . $version,
  "tintColor"=>"#FBC02D"
];

$tab1['views'][] = [
  "class"=>"DepictionTableButtonView",
  "title"=>"Twitter: @4nni3_",
  "action"=>"https://twitter.com/4nni3_"
];

$tab1['views'][] = [
  "class"=>"DepictionSeparatorView"
];

// 寄付のお願い
$tab1['views'][] = [
  "class"=>"DepictionSubheaderView",
  "title"=>"if you like, please donate.",
  "useBoldText"=>false,
  "useBottomMargin"=>false
];

$tab1['views'][] = [
  "class"=>"DepictionButtonView",
  "text"=>"Donate",
  "action"=>"https://4nni3.com/donation/",
  "tintColor"=>"#009688"
];

$tab1['views'][] = [
  "class"=>"DepictionSeparatorView"
];

// パッケージ情報
$tab1['views'][] = [
  "class"=>"DepictionHeaderView",
  "title"=>"Information"
];

$tab1['views'][] = [
  "class"=>"DepictionTableTextView",
  "title"=>"ID",
  "text"=>$package
];

$tab1['views'][] = [
  "class"=>"DepictionTableTextView",
  "title"=>"Version",
  "text"=>end($info['changelog'])['version']
];

$tab1['views'][] = [
  "class"=>"DepictionTableTextView",
  "title"=>"Dev",
  "text"=>$info['author']
];

if (isset($info['support_min'])) {
  $tab1['views'][] = [
    "class"=>"DepictionTableTextView",
    "title"=>"Support",
    "text"=>'iOS '
      .toFixed1($info['support_min'])
      .' - '
      .toFixed1($info['support_max'])
  ];
}

// ---- タブ2 (更新履歴) ----
$tab2 = [
  "class"=>"DepictionStackView",
  "tabname"=>"Changelog",
  "views"=>[]
];

foreach($info['changelog'] as $log){
  array_unshift($tab2['views'], [
    "class"=>"DepictionSubheaderView",
    "title"=>$log['version'].'  ('.$log['date'].')',
    "useBoldText"=>true,
    "useBottomMargin"=>false
  ],[
    "class"=>"DepictionMarkdownView",
    "markdown"=>$log['description'],
    "useSpacing"=>false,
    "useRawFormat"=>true
  ],[
    "class"=>"DepictionSeparatorView"
  ]);
}


// ヘッダ画像の設定
$header = isset($info["header_img"]) ? $info["header_img"] : "https://i.imgur.com/WjBxxH3.png";

// JSON表示!
header("Access-Control-Allow-Origin: *");
echo json_encode([
  "minVersion"=>"0.1",
  "headerImage"=>$header,
  "tintColor"=>"#5EB954",
  "class"=>"DepictionTabView",
  "tabs"=>[$tab1, $tab2]
]);
