<?php
	require dirname(__DIR__).'/src/autoloader.php';
    ob_start();
    require $exampleFile;
    $outputHtml = ob_get_clean();
    $outputHtml = explode('---', $outputHtml, 2);
?>
<header class="page-header">
	<h1><?php echo $exampleName ?></h1>
	<p><?php echo $outputHtml[0] ?></p>
</header>

<div class="panel panel-default">
  <div class="panel-heading">Browser Output</div>
  <div class="panel-body">
    <?php echo $outputHtml[1]; ?>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Html Output</div>
  <div class="panel-body">
<script type="syntaxhighlighter" class="brush: xml"><![CDATA[
<?php echo Mihaeu\HtmlFormatter::format($outputHtml[1]);?>
]]></script>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">PHP Source</div>
  <div class="panel-body">
<script type="syntaxhighlighter" class="brush: php"><![CDATA[
<?php
$content = explode('---', file_get_contents($exampleFile), 2);
echo $content[1];
?>
]]></script>
  </div>
</div>
