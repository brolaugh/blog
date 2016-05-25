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
            $stmt->free_result();
            $stmt->close();
            return $res->fetch_object()->id;
        }else{
            $stmt->free_result();
            $stmt->close();
            return false;
        }
    }
    /**
     * @param $blog
     * @param array $options
     * @return array
     */
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
        if(!isset($options['limit'])){
            $options['limit'] = 5;
        }
        if(!isset($options['offset'])){
            $options['offset'] = 0;
        }
        if(!isset($options['sort_order'])){
            $options['sort_order'] = "DESC";
        }
        if(!isset($options['sort_column'])){
            $options['sort_column'] = "create_time";
        }
        if(!isset($options['status'])){
            $options['status'] = [4];
        }


    $questionMarks = "";
    $param = "i";
    $paramValues = array($blog, $options['sort_column']);
    foreach($options['status'] as $status){
        if(strlen($questionMarks) == 0){
            $param.= 'i';
            $paramValues[] = $status;
            $questionMarks.= "?";
        }

        else{
            $param.= 'i';
            $paramValues[] = $status;
            $questionMarks.= ",?";
        }
    }
    $param.="sii";
    //Param should be "i" + "i" count($options['status])+ "sii"
    array_unshift($paramValues, $param);
    $paramValues = array_merge($paramValues, [$options['limit'], $options['offset']]);
    $paramValues = array_values($paramValues);

    $stmt = $this->database_connection->prepare("SELECT id FROM post WHERE blog = ? AND status IN(". $questionMarks .") ORDER BY (UNIX_TIMESTAMP(?)) DESC LIMIT ? OFFSET ?");
    call_user_func_array([$stmt, "bind_param"], makeValuesReferenced($paramValues));
    //$options['sort_order']
    $stmt->free_result();
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->free_result();
    $stmt->close();
    $retval = [];
    while($row = $res->fetch_object()){
        $retval[] = $row->id;
    }
    return $retval;


}
    
    public function getAllBlogs(){
        $stmt = $this->database_connection->prepare("SELECT id FROM blog");
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->free_result();
        $stmt->close();
        $retval = [];
        while($row = $res->fetch_object()){
            $retval[] = $row->id;
        }
        return $retval;
    }

}
function makeValuesReferenced($arr){
    $refs = array();
    foreach($arr as $key => $value)
        $refs[$key] = &$arr[$key];
    return $refs;

}