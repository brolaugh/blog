<ul class="pagination">
<?php
var_dump($utility);

if ($utility->currentPage > 1) {
    echo "\t<li><a href=\"/$blog->name/page/1\">««</a></li>";
    echo "\t<li><a href=\"/$blog->name/page/" . ($utility->currentPage - 1) . "\">«</a></li>\n";
} else {
    echo "\t<li class=\"disabled\"><a href=\"javascript:void(0)\">««</a></li>\n";
    echo "\t<li class=\"disabled\"><a href=\"javascript:void(0)\">«</a></li>\n";
}

//The number of pagination links besides the arrow ones
$range = 3;

for($x = ($utility->currentPage - $range);  $x < (($utility->currentPage + $range) + 1); $x++){
    // Checks wether the page number is valid
    if(($x > 0) && ($x <= $utility->totalPages)){
        //Checks we're dealing with the current page, if so it disables the a tag
        if($x == $utility->currentPage){
            echo "\t<li class=\"active\"><a href=\"javascript:void(0)\">$utility->currentPage</a></li>\n";
        }else{
            echo "\t<li><a href=\"/$blog->name/page/$x\">$x</a></li>\n";
        }
    }
}


if ($utility->currentPage < $utility->totalPages) {
    echo "\t<li><a href=\"/$blog->name/page/$utility->totalPages\">»»</a></li>\n";
    echo "\t<li><a href=\"/$blog->name/page/" . ($utility->currentPage + 1) . "\">»</a></li>\n";
} else {
    echo "\t<li class=\"disabled\"><a href=\"javascript:void(0)\">»</a></li>\n";
    echo "\t<li class=\"disabled\"><a href=\"javascript:void(0)\">»»</a></li>\n";
}


?>
</ul>