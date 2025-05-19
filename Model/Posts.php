<?php

class post{
    private int $PostID;
    private string $author;
    private date $time;
    private string $content;
    private int $likes;
    private int $comments;
    private string $MediaData;
    
    public function getPostID() {return $PostID;}
    public function getauthor() {return $author;}
    public function getTime(){return $time;}
    public function getContent() {return $content;}
    public function getLikes() {return $likes;}
    public function getComments() {return $comments;}
    public function getMediaData() {return $MediaData;}
}
?>