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

      static::$instance->exec("CREATE TABLE IF NOT EXISTS api1_nonce (iid VARCHAR(512) CHARACTER SET ascii NOT NULL PRIMARY KEY, nonce INT);");

      echo static::$instance->errorInfo()[2];
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
    $res = $query->fetchAll();
    if(count($res) < 1) return false;
    return true;
  }

  static function addExam(string $user, string $nonce, string $subject, string $range, string $date) {
    static::prepare();
    if(!static::verifyActionID($user, $nonce)) {
      echo '{"status":"error","message":"Wrong nonce","code":1}';
      return false;
    }

    $grp = "none";
    if(strpos($subject, '(') > 0) {
      $grp = substr($subject, strpos($subject, '(') + 1, strpos($subject, ')') - strpos($subject, '(') - 1);
      $subject = substr($subject, 0, strpos($subject, '(') - 1);
    }

    $date = DateTime::createFromFormat('!d.m.Y', $date)->getTimestamp();

    $query = static::$instance->prepare('INSERT INTO exams (`subject`, `range`, `exam_date`, `notes`, `author`, `grp`) VALUES (?, ?, ?, "", 1, ?)');
    $query->execute([$subject, $range, date("Y-m-d", $date), $grp]);

    echo '{"status":"OK","nonce":' . static::getActionID($user) . '}';
    return true;
  }

  static function deleteExam(string $user, string $nonce, string $eid) {
    static::prepare();
    if(!static::verifyActionID($user, $nonce)) {
      echo '{"status":"error","message":"Wrong nonce","code":1}';
      return false;
    }

    $query = static::$instance->prepare('DELETE FROM exams WHERE `_ID`=?');
    $query->execute([$eid]);

    echo '{"status":"OK","nonce":' . static::getActionID($user) . '}';
    return true;
  }

  static function updateExam(string $user, string $nonce, string $eid, string $range, string $date) {
    static::prepare();
    if(!static::verifyActionID($user, $nonce)) {
      echo '{"status":"error","message":"Wrong nonce","code":1}';
      return false;
    }

    $date = DateTime::createFromFormat('!d.m.Y', $date)->getTimestamp();

    $query = static::$instance->prepare('UPDATE exams SET `range`=?, `exam_date`=? WHERE `_ID`=?');
    $query->execute([$range, date("Y-m-d", $date), $eid]);

    echo '{"status":"OK","nonce":' . static::getActionID($user) . '}';
    return true;
  }
}
?>