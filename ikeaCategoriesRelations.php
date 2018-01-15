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
    <li><a href="#tabs-1">Organic categories</a></li>
    <li><a href="#tabs-2">Technical tree</a></li>    
  </ul>
  
  <div id="tabs-1">
    <?php
  // tree of the categories
    $realCategories = array();


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
            $subCategoryTitle = preg_replace('/\t+/', '', $subCategoryTitle);
            $subCategoryTitle = preg_replace('/^\h*\v+/m', '', $subCategoryTitle);

            $subCategoryURL = pq($subCategories)->attr('href');
            // explode of url
            $parentName = basename(dirname( $subCategoryURL));
            $currentName = basename( $subCategoryURL);

            /*
            <strong>TechName of parent category:</strong>(' .$parentName .')<br> 
            <strong>TechName of current category:</strong>(' .$currentName .')<br> 
            */

            echo '<li><strong>name:</strong> ' . $subCategoryTitle . ':<br>
            
            <strong>url</strong>: '.$subCategoryURL.'
            </li>';
            // adding category to real tree
            $realCategories[$parentName][$currentName] = array($subCategoryTitle, $subCategoryURL);

        }
       echo '</ul>';
}
?>    
  </div>
  <div id="tabs-2">
    <?php
    

    foreach ($realCategories as $subKey => $subValue) {
      echo "<b>Subcategory:</b>" . $subKey . "<br>";
      echo "<ul>";
      foreach ($subValue as $sub2key => $sub2value) {
        echo "<li><b>name:</b> " . $sub2value[0] . "<br>" .
        "<b>url of subcat:</b> " . $sub2value[1] . "</li>";
      }
      echo "</ul>";
    }
?>
  </div>
</div>

</body>
</html>