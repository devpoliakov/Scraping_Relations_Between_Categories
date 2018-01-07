<?php
include_once ("configGrabber.php");
#include_once ("functions.php");

//$url = "https://news.google.com.ua";
$url = "http://www.ikea.com/us/en/catalog/allproducts/";

$ch = curl_init();

// 2. указываем параметры, включая url
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

// 3. получаем HTML в качестве результата
$output = curl_exec($ch);

// 4. закрываем соединение
curl_close($ch);


require_once ("parcer/phpQuery/phpQuery.php");



    // Инициализируем библиотеку
    $results = phpQuery::newDocument($output);
    $elements = $results->find('.productCategoryContainer  ');
    
    // А вот в цикле мы можем залезть внутрь любого объекта
    
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
            $url = basename(dirname( $subCategoryURL));

            echo '<li><strong>name:</strong> ' . $subCategoryTitle . ':<br>
            <strong>TechName of parent category:</strong>(' .$url .')<br> 
            
            </li>';
            #<strong>url of category:</strong>' . $subCategoryURL . '
        }
       echo '</ul>';

    //mysql_query ($query_insert);
        
             

}



include_once ("version.php");
?>