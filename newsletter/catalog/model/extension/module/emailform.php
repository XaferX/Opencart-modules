<?php
class ModelExtensionModuleEmailform extends Model {
  public function insert($email){

    $dbResult = $this->db->query("INSERT INTO  ".DB_PREFIX."emailform set  email='".$email."' ");
    return $this->db->getLastId();



  }

  public function check($email){
    $dbResult = $this->db->query("SELECT email FROM ".DB_PREFIX."emailform WHERE email='".$email."' ");

    return ($dbResult->num_rows >0) ? true : false;


  }




}
