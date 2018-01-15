<?php

// get $url variable
include_once ("geturl.php");

$ch = curl_init();

// parameters for url
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

// get html as result
$output = curl_exec($ch);

// close connection
curl_close($ch);


require_once ("parcer/phpQuery/phpQuery.php");

// initialisation of the library
    $results = phpQuery::newDocument($output);
    $elements = $results->find('.productCategoryContainer  ');

?><html>
<head>
     <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Categories of the resource</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>
</head>
<body>
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Nunc tincidunt</a></li>
    <li><a href="#tabs-2">Organic categories</a></li>
    
  </ul>
  <div id="tabs-1">
    <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
  </div>
  <div id="tabs-2">
    <?php
  $i = 0;

    foreach ($elements as $element){
        print "<hr>";
        
        // update title
        $title = pq($element)->find('.header')->text();
        //delete empty spaces and tabs 
        $title = preg_replace('/\t+/', '', $title);
        $title = preg_replace('/^\h*\v+/m', '', $title);
        
    echo ' <strong>' . $title . ':</strong> <br>';  
        // subcategories
        $categorySubSections = pq($element)->find('.textContainer a');

        // get all objects of the category
        echo '<ul>';
        foreach ($categorySubSections as $subCategories){
            $subCategoryTitle = pq($subCategories)->text();
            $subCategoryURL = pq($subCategories)->attr('href');
            // explode of url
            $ulr = basename(dirname( $subCategoryURL));

            echo '<li><strong>name:</strong> ' . $subCategoryURL . ':<br>
            <strong>TechName of parent category:</strong>(' .$url .')<br> 
            <strong>url</strong>: '.$url.'
            </li>';

        }
       echo '</ul>';
}
?>    
  </div>
</div>

</body>
</html>