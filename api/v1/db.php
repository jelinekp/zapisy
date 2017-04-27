<?php
require_once "../../config.php";
class DB {
  private static $instance = null;

  static function prepare() {
    if(static::$instance == null) {
      static::$instance = new PDO (
        "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
        Config::$db_user, Config::$db_pass
      );

      static::$instance->exec("CREATE TABLE IF NOT EXISTS api1_nonce (iid TEXT(512) NOT NULL PRIMARY KEY, nonce INT);");
    }
  }

  static function getActionID(string $user) {
    static::prepare();
    $query = static::$instance->prepare("SELECT nonce FROM api1_nonce WHERE iid = ?");
    $query->execute([$user]);
    $res = $query->fetchAll();
    if(count($res) < 1) {
      $query = static::$instance->prepare("INSERT INTO api1_nonce (iid, nonce) VALUES (?, ?)");
      $query->execute([$user, 1]);
      return 1;
    } else {
      $action = $res[0]['nonce'];
      $query = static::$instance->prepare('UPDATE api1_nonce SET nonce = ? WHERE iid = ?');
      $query->execute([$action + 1, $user]);
      return $action + 1;
    }
  }

  static function verifyActionID(string $user, string $nonce) {
    static::prepare();
    $query = static::$instance->prepare("SELECT nonce FROM api1_nonce WHERE iid = ? AND nonce = ?");
    $query->execute([$user, $nonce]);
    if($res < 1) return false;
    return true;
  }

  static function addExam(string $user, string $nonce, string $subject, string $range, string $date) {
    static::prepare();
    if(!static::verifyActionID($user, $nonce)) {
      echo '{"status":"error","message":"Wrong nonce","code":1}';
      return false;
    }

    $query = static::$instance->prepare('INSERT INTO exams (`subject`, `range`, `exam_date`, `notes`, `author`) VALUES (?, ?, ?, "", 1)');
    $query->execute([$subject, $range, $date]);

    echo '{"status":"OK","nonce":' . static::getActionID($user) . '}';
    return true;
  }

  static function removeExam(string $user, string $nonce, string $eid) {
    static::prepare();
    if(!static::verifyActionID($user, $nonce)) {
      echo '{"status":"error","message":"Wrong nonce","code":1}';
      return false;
    }

    $query = static::$instance->prepare('INSERT INTO exams (`subject`, `range`, `exam_date`, `notes`, `author`) VALUES (?, ?, ?, "", 1)');
    $query->execute([$subject, $range, $date]);

    echo '{"status":"OK","nonce":' . static::getActionID($user) . '}';
    return true;
  }

  static function updateExam(string $user, string $nonce, string $eid, string $range, string $date) {
    static::prepare();
    if(!static::verifyActionID($user, $nonce)) {
      echo '{"status":"error","message":"Wrong nonce","code":1}';
      return false;
    }

    $query = static::$instance->prepare('UPDATE exams SET range = ?, exam_date = ? WHERE exam_ID = ?');
    $query->execute([$range, $date, $eid]);

    echo '{"status":"OK","nonce":' . static::getActionID($user) . '}';
    return true;
  }
}
?>