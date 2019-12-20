<!DOCTYPE html>
<?php

$package = $_GET['p'];
$info = json_decode(file_get_contents('data/'.$package.'.json'), true);
$agent = strtolower(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"");
$ios = 0;
if(preg_match('/ip(hone|od|ad)/', $agent)){
  preg_match('/os (.+) like/', $agent,  $matches);
  $ios = floatval(str_replace('_', '.', $matches[1]));
}
if($info['support_min']==null||$info['support_max']==null){
  $compatible = -1;
}else{
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://repo.4nni3.com/dp/style.css" />
  <link rel="stylesheet" type="text/css" href="https://repo.4nni3.com/dp/form.css" />
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
      <div class="form">
        <textarea id="comment" placeholder="Message"></textarea>
        <div class="submit">
          <div id="works">Works</div>
          <div id="broken">Broken</div>
        </div>
      </div>
    </div>

    <div>
      Bug reports to my Twitter or above form. <a href="https://twitter.com/4nni3_?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">Follow @4nni3_</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
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

<!--
      <div><p class="k">PackageID</p><span id="packageid"><?php echo $package; ?></span></div>
-->

      <div><p class="k">Version</p><span id="version"><?php echo end($info['changelog'])['version']; ?></span></div>

<!--
      <div><p class="k">Author</p><span id="author"><?php echo $info['author']; ?></span></div>

      <div><p class="k">Section</p><span id="section"><?php echo $info['section']; ?></span></div>
-->

      <?php if($campatible!=-1): ?>
      <div><p class="k">Support</p><span id="support"><?php echo 'iOS '.toFixed1($info['support_min']).' ~ '.toFixed1($info['support_max']); ?></span></div>
      <?php endif; ?>
    </div>

  </div><!-- .container -->

  <script>

function submitForm(co){
    var comment = $('#comment').val();

    $.post(
        "https://docs.google.com/forms/u/1/d/e/1FAIpQLSchaB-HrJ0HYRuKROVKjkQjVAlNO6bSo8AmHikZz-2_MKXkvw/formResponse",
        {
          "entry.390043528": "<?php echo $package; ?>",
          "entry.1049998279": "<?php echo end($info['changelog'])['version']; ?>",
          "entry.178135634": "<?php echo $ios; ?>",
          "entry.1748641038": co,
          "entry.391198144": comment,
          dataType: "xml"
        }
    );

    $('#comment').val('');
    $('.submit').empty();
    $('.submit').text('Thank you');
}

$('#works').click(function(){ submitForm("動いた"); });

$('#broken').click(function(){ submitForm("動かない"); });

  </script>
</body>
</html>
