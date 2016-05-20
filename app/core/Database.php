<?php
/**
 * Created by PhpStorm.
 * User: hannes.kindstrommer
 * Date: 2016-05-20
 * Time: 13:41
 */
require_once '../app/core/DatabaseConfig.php';

class Database extends DatabaseConfig
{
    /**
     *
     * @param $blog
     * @return false if blog doesn't exist
     * @return blogId if blog exists
     */
    public function blog_exists($blog){
        $stmt = $this->database_connection->prepare("SELECT id FROM blog WHERE name = ?");
        $stmt->bind_param('s', $blog);
        $stmt->execute();

        $res = $stmt->get_result();
        echo "Affected rows" . $res->num_rows;
        if($res->num_rows > 0){
            $stmt->close();
            return $res->fetch_object()->id;
        }else{
            $stmt->close();
            return false;
        }
    }
}