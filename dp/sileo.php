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

$info = json_decode(file_get_contents('data/'.$package.'.json'), true);

$tab1 = [
  "class"=>"DepictionStackView",
  "tabname"=>"Details",
  "views"=>[]
];

if($info['info']!=null){
  $tab1['views'][] = [
    "class"=>"DepictionMarkdownView",
    "markdown"=>'<center><b><span style="color:#a00;">'.$info['info'].'</span></b></center>',
    "useSpacing"=>true,
    "useRawFormat"=>true
  ];
}

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
  $tab1['views'][] = [
    "class"=>"DepictionSeparatorView"
  ];
}

$tab1['views'][] = [
  "class"=>"DepictionMarkdownView",
  "markdown"=>$info['description'],
  "useSpacing"=>true,
  "useRawFormat"=>true
];

$tab1['views'][] = [
  "class"=>"DepictionAdmobView",
  "adUnitID"=>"ca-app-pub-7732927685565784/9541680779"
];

$tab1['views'][] = [
  "class"=>"DepictionSeparatorView"
];

$tab1['views'][] = [
  "class"=>"DepictionTableButtonView",
  "title"=>"4nni3.com",
  "action"=>"https://4nni3.com/"
];

$tab1['views'][] = [
  "class"=>"DepictionTableButtonView",
  "title"=>"Twitter @4nni3_",
  "action"=>"https://twitter.com/4nni3_"
];

$tab1['views'][] = [
  "class"=>"DepictionTableButtonView",
  "title"=>"Donate",
  "action"=>"https://4nni3.com/donation/"
];

$tab1['views'][] = [
  "class"=>"DepictionSeparatorView"
];

$tab1['views'][] = [
  "class"=>"DepictionHeaderView",
  "title"=>"Information"
];

$tab1['views'][] = [
  "class"=>"DepictionTableTextView",
  "title"=>"PackageID",
  "text"=>$package
];

$tab1['views'][] = [
  "class"=>"DepictionTableTextView",
  "title"=>"Version",
  "text"=>end($info['changelog'])['version']
];

$tab1['views'][] = [
  "class"=>"DepictionTableTextView",
  "title"=>"Developer",
  "text"=>$info['author']
];

$tab1['views'][] = [
  "class"=>"DepictionTableTextView",
  "title"=>"Section",
  "text"=>$info['section']
];

$tab1['views'][] = [
  "class"=>"DepictionTableTextView",
  "title"=>"Compatibility",
  "text"=>'iOS'.toFixed1($info['support_min']).' ~ '.toFixed1($info['support_max'])
];

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
    "useSpacing"=>true,
    "useRawFormat"=>true
  ],[
    "class"=>"DepictionSeparatorView"
  ]);
}


$tab1['views'][] = [
  "class"=>"DepictionSeparatorView"
];

$tab1['views'][] = [
  "class"=>"DepictionHeaderView",
  "title"=>"Work?"
];

$tab1['views'][] = [
  "class"=>"DepictionButtonView",
  "text"=>"Works",
  "action"=>"https://nni43-repo.herokuapp.com/dp/c.php?p=".$package."&v=".$version."&c=1"
];

$tab1['views'][] = [
  "class"=>"DepictionButtonView",
  "text"=>"Broken",
  "action"=>"https://nni43-repo.herokuapp.com/dp/c.php?p=".$package."&v=".$version."&c=0"
];

$header = isset($info["header_img"])?$info["header_img"]:"https://i.imgur.com/WjBxxH3.png";

header("Access-Control-Allow-Origin: *");
echo json_encode([
  "minVersion"=>"0.1",
  "headerImage"=>$header,
  "tintColor"=>"#000088",
  "class"=>"DepictionTabView",
  "tabs"=>[$tab1, $tab2]
]);
