<?php
require_once "config.php";

function get_diff($time) {
  $date = new DateTime($time);
  if($date->format("j.n.Y") == date("j.n.Y")) return "dneska";
  $days = ($date->diff(new DateTime())->format("%r%a") * (-1));
  if($days >= 0) $days++;
  if($days == 1) {
    return "zítra";
  } else if ($days == 2) {
    return "pozítří";
  } else if ($days > 4) {
    return "za $days dnů";
  } else if ($days > 2) {
    return "za $days dny";
  } else if ($days == 0) {
    return "dneska";
  } else if ($days == -1) {
    return "včera";
  } else if ($days == -2) {
    return "předevčírem";
  } else if ($days < -4) {
    return abs($days) . " dnů zpátky";
  } else {
    return abs($days) . " dny zpátky";
  }
}

function get_user() {
  if(isset($_COOKIE['code'])) {
    $sql = new PDO (
      "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
      Config::$db_user, Config::$db_pass
    );
    $query = $sql->prepare('SELECT name,author_ID,class FROM authors WHERE pass=?');
    $query->execute([$_COOKIE['code']]);
    $res = $query->fetchAll();
    if(count($res) == 1) {
      return array(
        'name'  => $res[0]['name'],
        'id'    => $res[0]['author_ID'],
        'class' => $res[0]['class']
      );
    }
  }
  return null;
}

class V {
  private static $vfile_cache = null;

  static function file(string $name) {
    if(static::$vfile_cache == null) {
      static::$vfile_cache = array();
      $json = json_decode(file_get_contents(dirname(__FILE__) . "/version.json"), true);
      foreach($json as $file) {
        static::$vfile_cache[$file["file"]] = $file["version"];
      }
    }

    return "$name?v=" . static::$vfile_cache[$name];
  }
}
?>
