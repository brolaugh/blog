<?php
/**
 * Created by PhpStorm.
 * User: hannes.kindstrommer
 * Date: 2016-05-23
 * Time: 13:48
 */

?>

<table class="table-striped">
    <tr>
        <th>Blog name</th>
        <th>Link</th>
    </tr>
    <?php
    foreach($data['blogs'] as $blog){
        echo "<tr>";
        echo "<td>$blog->title</td>";
        echo "<td><a href=\"$blog->name\">Link</a></td>";
        echo "</tr>";
    }
    ?>
</table>
