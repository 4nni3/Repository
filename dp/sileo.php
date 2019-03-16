<?php

$package = $_GET['p'];
$info = json_decode(file_get_contents('d/'.$package.'.json'), true);

$tab1 = [
  "class"=>"DepictionStackView",
  "tabname"=>"Details",
  "views"=>[]
];

if(count($info['screenshots'])){
  $sss = [
    "class"=>"DepictionScreenshotsView",
    "itemCornerRadius"=>6,
    "itemSize"=>'{160, 284}',
    "screenshots"=>[]
  ];
  foreach($info['screenshots'] as $ss){
    $sss['screenshots'][] = [
      "url"=>"https://nni43-repo.herokuapp.com/dp/ss/".$ss,
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
  "text"=>$info['version']
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
  "text"=>'iOS'.$info['support_min'].' ~ '.$info['support_max']
];

$tab2 = [
  "class"=>"DepictionStackView",
  "tabname"=>"Changelog",
  "views"=>[]
];

foreach($info['changelog'] as $log){
  $tab2['views'][] = [
    "class"=>"DepictionSubheaderView",
    "title"=>$log['version'].'  ('.$log['date'].')',
    "useBoldText"=>true,
    "useBottomMargin"=>false
  ];
  $tab2['views'][] = [
    "class"=>"DepictionMarkdownView",
    "markdown"=>$log['description'],
    "useSpacing"=>true,
    "useRawFormat"=>true
  ];
  $tab2['views'][] = [
    "class"=>"DepictionSeparatorView"
  ];
}

$tab3 = [
  "class"=>"DepictionStackView",
  "tabname"=>"Contact",
  "views"=>[]
];

$tab3['views'][] = [
  "class"=>"DepictionMarkdownView",
  "markdown"=>"Comming soon...",
  "useSpacing"=>true
];

$header = isset($info["header_img"])?$info["header_img"]:"https://i.imgur.com/WjBxxH3.png";

header("Access-Control-Allow-Origin: *");
echo json_encode([
  "minVersion"=>"0.1",
  "headerImage"=>$header,
  "tintColor"=>"#000088",
  "class"=>"DepictionTabView",
  "tabs"=>[$tab1, $tab2, $tab3]
]);
