<?php

echo $numPages = intval(($blog->numPosts / 5) + ((($blog->numPosts % 5) > 0) ? 1 : 0));
?>
<ul class="pagination">
    <li class="disabled"><a href="javascript:void(0)">«</a></li>
    <li class="active"><a href="javascript:void(0)">1</a></li>
    <li><a href="javascript:void(0)">2</a></li>
    <li><a href="javascript:void(0)">3</a></li>
    <li><a href="javascript:void(0)">»</a></li>
</ul>