<?php

class DB {
  protected $_db;

  public function __construct() {
    $server = "171.244.142.78";
    $username = "app";
    $password = "app@123";
    $db_name = "thiep_chuc_thi_tot";
    try {
      $this->_db = new PDO("mysql:host=$server;dbname=$db_name", $username, $password);
      $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) { }
  }
  
  public function getUser($uid) {
    $sql = "select * from users where uid = $uid";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll()[0];
  }

  public function assignGift($uid) {
    $gift = $this->randGift();

    $gift_id = $gift['id'];
    $gift_name = $gift['name'];
    $gift_quantity = $gift['quantity'] - 1;

    // $sql = "update users set gift = '$gift_name' where uid = $uid";
    // $stmt = $this->_db->prepare($sql);
    // $stmt->execute();

    // $sql = "update gifts set quantity = $gift_quantity where id = $gift_id";
    // $stmt = $this->_db->prepare($sql);
    // $stmt->execute();

    return $gift;
  }
  
  protected function randGift() {
    $id = rand(1, 9);
    $gift = $this->getGift($id);
  
    if (is_null($gift))
      return $this->getGift(rand(7, 9));
    
    return $gift;
  }
  
  protected function getGift($id) {
    $sql = "select * from gifts where id = $id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();
    $item = $stmt->fetchAll()[0];
    if ($item['quantity'] == 0)
      return null;
    return $item;
  }
}