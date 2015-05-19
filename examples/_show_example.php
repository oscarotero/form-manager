<?php
    ob_start();
    require $exampleFile;
    $outputHtml = ob_get_clean();
?>
<h2>FormManager Example: <?php echo $exampleName ?></h2>
<h3>Browser Output</h3>
<?php echo $outputHtml; ?>
<h3>HTML Output</h3>
<script type="syntaxhighlighter" class="brush: php"><![CDATA[
<?php echo Mihaeu\HtmlFormatter::format($outputHtml);?>
]]></script>

<h3>Source</h3>
<script type="syntaxhighlighter" class="brush: php"><![CDATA[
<?php echo file_get_contents($exampleFile);?>
]]></script>
