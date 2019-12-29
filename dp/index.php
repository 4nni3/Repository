<!DOCTYPE html>
<?php

$package = $_GET['p'];
$info = json_decode(file_get_contents('data/'.$package.'.json'), true);
$version = end($info['changelog'])['version'];

$agent = strtolower(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"");
$ios = 0;
if(preg_match('/ip(hone|od|ad)/', $agent)){
  preg_match('/os (.+) like/', $agent,  $matches);
  $ios = floatval(str_replace('_', '.', $matches[1]));
}

if ($info['support_min']==null||$info['support_max']==null){
  $compatible = -1;
} else {
  $compatible = ($info['support_min']<=$ios&&$ios<=$info['support_max'])?1:0;
}

function toFixed1($num){
  $str = strval($num);
  if(strpos($str, ".")===false){
    $str .= ".0";
  }
  return $str;
}
?>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="robots" content="noindex,nofollow" />
  <title><?php echo $info['name']; ?></title>

  <style>

*{
  margin: 0;
  padding:0;
  box-sizing: border-box;
  vertical-align: middle;
  -webkit-appearance:none;
}
html {
  font-size: 16px;
  font-family: sans-serif;
  color: #333;
}

body {
  width: 100vw;
}

.container {
  margin: 0 auto;
  max-width: 560px;
  width: 100%;
}

.container>div {
  width:100%;
  background: #f5f5f5;
  margin: 10px 0;
  padding: 10px 20px;
  border-style: solid;
  border-width: 0.5px 0;
  border-color: #888888;
}

.warning {
  color: #f1c40f;
  font-weight: bold;
  text-align: center;
}

.compatible {
  text-align: center;
  color: #fff;
  background: #e74c3c !important;
}

.compatible.ok{
  background: #27ae60 !important;
}

.screenshots {
  overflow: scroll;
  overflow-x: auto;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
  overflow-scrolling: touch;
}

.screenshots>img {
  width: 240px;
  display: inline-block;
  margin: 16px;
}

.description {
  white-space:pre-wrap;
}

.info>div {
  margin: 8px 0;
  text-align: right;
  position: relative;
  border-bottom: #888888 solid 0.5px;
}

.lbl {
  position: absolute;
  top: 0;
  left: 0;
  color: #555555;
}

.log {
  margin: 16px 0;
}
.log>p:first-child {
  font-weight: bold;
}
.log>p:last-child {
  margin-left: 16px;
}

  </style>

</head>
<body>
  <div class="container">

    <?php if ($info['info']!=null): ?>
    <div class="warning"><?php echo $info['info']; ?></div>
    <?php endif; ?>

    <?php if ($compatible==1): ?>
    <div class="compatible ok">Compatible with iOS<?php echo toFixed1($ios); ?></div>
    <?php elseif ($compatible==0): ?>
    <div class="compatible">Not compatible with iOS<?php echo toFixed1($ios); ?></div>
    <?php endif; ?>

    <?php if (count($info['screenshots'])): ?>
    <div class="screenshots">
      <?php foreach ($info['screenshots'] as $ss): ?>
      <img src="https://repo.4nni3.com/dp/ss/<?php echo $ss; ?>">
      <?php endforeach;  ?>
    </div>
    <?php endif; ?>

    <div class="description"><?php echo $info['description']; ?></div>

    <div>
      <div class="btn"><a href="https://4nni3.com/report/?p=<?php echo $package; ?>&v=<?php echo $version; ?>" target="_blank"></a>Report!</div>
    </div>

    <div>
      Bug reports to my Twitter or above link. <a href="https://twitter.com/4nni3_?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">Follow @4nni3_</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>

    <div>
      <a href="https://4nni3.com/donation/" target="_blank">Please Donate.</a>
    </div>

    <div id="changelog">
      <?php foreach($info['changelog'] as $log): ?>
      <div class="log">
        <p><?php echo $log['version'].' '.$log['date']; ?></p>
        <p><?php echo $log['description']; ?></p>
      </div>
      <?php endforeach;  ?>
    </div>

    <div class="info">

      <div><p class="ldl">PackageID</p><span><?php echo $package; ?></span></div>


      <div><p class="lbl">Version</p><span><?php echo $version; ?></span></div>


      <div><p class="lbl">Author</p><span><?php echo $info['author']; ?></span></div>

      <div><p class="lbl">Section</p><span><?php echo $info['section']; ?></span></div>


      <?php if($campatible!=-1): ?>
      <div><p class="lbl">Support</p><span id="support"><?php echo 'iOS '.toFixed1($info['support_min']).' - '.toFixed1($info['support_max']); ?></span></div>
      <?php endif; ?>

    </div>

  </div><!-- .container -->


</body>
</html>
