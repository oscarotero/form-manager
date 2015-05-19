<?php
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/_header.php';
?>
<p>
    Choose the template you wish to view below. Templates which begin with "bootstrap"
    require the <a href='https://github.com/oscarotero/form-manager-bootstrap'>
    FormManager Bootstrap</a> extension.
</p>
<?php
if (!isset($_GET['example'])) {
    echo "<h2>Pick an Example</h2>";
    require __DIR__.'/_list_examples.php';
} else {
    // Get the requested example, and make it safe
    $example = preg_replace('/[^A-z0-9\-]/', '', $_GET['example']);
    // Make a pretty display name for the example
    $exampleName = ucwords(str_replace('-', ' ', $example));
    // Get paths  to the files (And hmtl files)
    $exampleFile = __DIR__.'/example/'.$example.'.php';
    $exampleFileHtml = __DIR__.'/example/'.$example.'.html';
    if (!file_exists($exampleFile)) {
        echo "<h2>Invalid Example</h2>";
        require __DIR__.'/_list_examples.php';
    } else {
        require __DIR__.'/_show_example.php';
    }
}

require __DIR__.'/_footer.php';
