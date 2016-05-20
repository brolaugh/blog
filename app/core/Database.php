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
        if($res->num_rows > 0){
            $stmt->close();
            return $res->fetch_object()->id;
        }else{
            $stmt->close();
            return false;
        }
    }
    protected function getBlogByID($blogID){
        $stmt = $this->database_connection->prepare("SELECT * FROM blog WHERE id = ?");
        $stmt->bind_param("i", $blogID);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        return $res->fetch_object();
    }
    protected function getPostByID($postID){
        $stmt = $this->database_connection->prepare("SELECT * FROM post WHERE id = ?");
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        return $res->fetch_object();
    }
    protected function getTagsFromPostID($postID){
        $stmt = $this->database_connection->prepare("SELECT tag.name FROM post_tag LEFT JOIN tag ON post_tag.tag=tag.id WHERE post_tag.post = ?");
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        $retval = [];
        while($retval[] = $res->fetch_object()->name);
        return $retval;
    }
    public function getPostsByBlog(
        $blog,
        $options = [
            "limit" => 5,
            "offset" => 0,
            "sort_order" => "DESC",
            "sort_column" => "create_time",
            "status" => [4]
        ]
    ){
        $questionMarks = "";
        foreach($options['status'] as $status){
            if(strlen($questionMarks) == 0)
                $questionMarks.= $status;
            else
                $questionMarks.= ",".$status;
        }
        $stmt = $this->database_connection->prepare("SELECT id FROM post WHERE blog = ? AND status IN(". $questionMarks .") ORDER BY ? ASC LIMIT ? OFFSET ? ");
        $stmt->bind_param("iiii", $blog, $options['sort_column'],  $options['limit'], $options['offset']);
        //$options['sort_order'],
        $stmt->execute();
        $res = $stmt->get_result();

        if($stmt->num_rows > 0){
            $stmt->close();
            $retval = [];
            while($retval[] = $res->fetch_object()->id);
            return $retval;
        }else{
            $stmt->close();
            return [];
        }


    }
    protected function getVariblesByAuthorID($authorID){
        $stmt = $this->database_connection->prepare("SELECT * FROM author_variables WHERE author = ?");
        $stmt->bind_param("i", $authorID);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        $retval = [];
        while($retval[] = $res->fetch_object());
        return $retval;
    }
}