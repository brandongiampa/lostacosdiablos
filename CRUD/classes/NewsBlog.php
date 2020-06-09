<?php

class NewsBlog{
  private $id;
  private $title;
  private $img_path;
  private $html;
  private $text;
  private $language = "English";
  private $date;

  public function __construct($id, $title){
    if(!isset($title)||$title===null||$title===""){
      throw new NewsBlogException("Title must be set to at least one character.");
    }
    $this->id = $id;
    $this->title=$title;
    $this->slug = $this->createSlug($title);
    $this->setDate('now');
  }
  public function setTitle($title){
    if($title===null || $title===""){
      throw new NewsBlogException("Title must be set and have one or more characters.");
    }
    else {
      $this->title = ucwords(trim($title));
    }
  }
  public function setID($id){
    $this->id = $id;
  }
  public function setImgPath($img_path){
    $imgExtension = strrchr($img_path, ".");
    $acceptableExtensions = array(".jpg", ".jpeg", ".gif", ".png");

    if($img_path === null || $img_path === ""){
      throw new NewsBlogException("Image path cannot be blank.");
    }
    else if(!in_array($imgExtension, $acceptableExtensions)){
      throw new NewsBlogException("Image file must be .jpg, .jpeg, .gif or .png.");
    }
    else{
      $this->img_path = $img_path;
    }
  }
  public function setHTML($html){
    $this->html = $html;
  }
  public function setText($html){
    $this->text = strip_tags($html);
  }
  public function setDate($date){
    $date = date_create($date, timezone_open('America/Los_Angeles'));
    if ($date === true || $date === false){
      throw new NewsBlogException("Date input must be a recognizable date with dashes, slashes or periods.");
    }
    $this->date = date_format($date,'Y-m-d H:i:s');
  }
  public function setLanguage($language){
    if($language !== "English" && $language !== "Spanish"){
      throw new NewsBlogException("Language must be set to either English or Spanish.");
    }
    else{
      $this->language = $language;
    }
  }
  public function createSlug($title){
    $slug = trim($title);
    $slug = preg_replace('[\W+]', "-", $title);
    $slug = trim($slug, '-');
    $slug = strtolower($slug);
    return $slug;
  }
  public function getTitle(){
    return $this->title;
  }
  public function getSlug(){
    return $this->createSlug($this->title);
  }
  public function getImgPath(){
    return $this->img_path;
  }
  public function getHTML(){
    return $this->html;
  }
  public function getText(){
    return $this->text;
  }
  public function getLanguage(){
    return $this->language;
  }
  public function getDate(){
    return $this->date;
  }
  public function getID(){
    return $this->id;
  }
}

class NewsBlogException extends Exception{
  protected $message;

  public function __construct($message, $code=0, Exception $previous=null){
    $this->message = $message;
    parent::__construct($message, $code, $previous);
  }
  public function __toString() {
      return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
  }
}
?>
