<?php

namespace models;


class Tags extends \Database
{
    public function connectTagAndPost($postID, $tagID){
        var_dumpi("postID = " . $postID);
        var_dumpi("tagID = " .$tagID);
        $stmt = $this->database_connection->prepare("INSERT INTO post_tag(post, tag) values(?,?)");
        $stmt->bind_param('ii', $postID, $tagID);
        if(!$stmt->execute()){
            die("connectTagAndPost\n" . $stmt->error);
        }
    }
    public function getTagIdByName($tagName){
        $stmt = $this->database_connection->prepare("SELECT id FROM tag WHERE name = ?");
        $stmt->bind_param('s', $tagName);
        if(!$stmt->execute()){
            die("getTagIdByName\n" . $stmt->error_list);
        }
        $res = $stmt->get_result();
        if(0 == $res->num_rows){
            return $this->createTagAndReturnId($tagName);
        }else{
            return $res->fetch_object()->id;
        }

    }
    private function createTagAndReturnId($tagName){
        $stmt = $this->database_connection->prepare("INSERT INTO tag(name) values(?)");
        $stmt->bind_param('s', $tagName);
        if(!$stmt->execute()){
            die("createTagAndReturnId\n" . $stmt->error_list);
        }
        $retval = $stmt->insert_id;
        $stmt->close();
        return $retval;
    }
}