<h2>FormManager Example: <?php echo $exampleName ?></h2>
<h3>Browser Output</h3>
<?php require $exampleFile ?>

<h3>HTML Output</h3>
<script type="syntaxhighlighter" class="brush: php"><![CDATA[
<?=file_get_contents($exampleFileHtml);?>
]]></script>

<h3>Source</h3>
<script type="syntaxhighlighter" class="brush: php"><![CDATA[
<?=file_get_contents($exampleFile);?>
]]></script>
