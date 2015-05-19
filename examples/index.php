<?php require __DIR__.'/vendor/autoload.php'; ?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Form Builder Examples</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Add Syntax Highlighter -->
        <link href="http://alexgorbatchev.com/pub/sh/current/styles/shThemeDefault.css" rel="stylesheet" type="text/css" />
        <script src="http://alexgorbatchev.com/pub/sh/current/scripts/shCore.js" type="text/javascript"></script>
        <script src="http://alexgorbatchev.com/pub/sh/current/scripts/shBrushPhp.js" type="text/javascript"></script>
        <script src="http://alexgorbatchev.com/pub/sh/current/scripts/shBrushXml.js" type="text/javascript"></script>
        <script src="http://alexgorbatchev.com/pub/sh/current/scripts/shAutoloader.js" type="text/javascript"></script>
        <!-- End Syntax Highlighter -->

        <!-- Add Bootstrap -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <!-- End Bootstrap -->

        <!-- Fix css conflicts between bootstrap and syntax hightlighter -->
        <style type="text/css">
            body {
                margin-top: 1em;
            }
            code {
                padding: 0;
                font-size: inherit;
                color: inherit;
                background-color: inherit;
                border-radius: 0;
            }
            table .container {
                width: auto;
            }
            table {
                font-size: 14px;
                line-height: 18px;
            }
            .line {
                font-family: Menlo,Monaco,Consolas,"Courier New",monospace;
                padding: 0 5px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <?php require __DIR__.'/_header.php'; ?>

            <?php
            if (!isset($_GET['example'])) {
                echo '<h1 class="page-header">Form Manager examples <small>Pick an example:</small></h1>';
                ?>
                <p>
                    Choose the template you wish to view below. Templates which begin with "bootstrap"
                    require the <a href='https://github.com/oscarotero/form-manager-bootstrap'>
                    FormManager Bootstrap</a> extension.
                </p>
                <?php
                echo '<ul>';
                echo require __DIR__.'/_menu_examples.php';
                echo '</ul>';
            } else {
                // Get the requested example, and make it safe
                $example = preg_replace('/[^A-z0-9\-]/', '', $_GET['example']);
                // Make a pretty display name for the example
                $exampleName = ucwords(str_replace('-', ' ', $example));
                // Get paths  to the files (And hmtl files)
                $exampleFile = __DIR__.'/example/'.$example.'.php';
                $exampleFileHtml = __DIR__.'/example/'.$example.'.html';
                if (!file_exists($exampleFile)) {
                    echo '<p class="bg-danger">Invalid Example</p>';

                    echo '<ul>';
                    echo require __DIR__.'/_menu_examples.php';
                    echo '</ul>';
                } else {
                    require __DIR__.'/_show_example.php';
                }
            }
            ?>
        </div>
        <script>
            SyntaxHighlighter.defaults['toolbar'] = false;
            SyntaxHighlighter.all();
        </script>
    </body>
</html>





<?php
die();
require dirname(__DIR__).'/src/autoloader.php';
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
