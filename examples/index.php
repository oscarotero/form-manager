<?php
    require __DIR__.'/_header.php';
    require __DIR__.'/vendor/autoload.php';
    // Get the requested example, and make it safe
    $example = preg_replace('/[^A-z0-9\-]/', '', $_GET['example']);
    $exampleFile = __DIR__.'/example/'.$example.'.php';
?>

<h1>Result</h1>
<?php require $exampleFile ?>

<h1>Source</h1>
<script type="syntaxhighlighter" class="brush: php"><![CDATA[
    <?=file_get_contents($exampleFile);?>
]]></script>

<?php require __DIR__.'/_footer.php'; ?>

<?php
require __DIR__.'/_footer.php';
