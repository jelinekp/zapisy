<?php
require_once('util.php');

class Assembler {
  private static $parts = null;
  private static $css = array();
  private static $js = array();
  
  static $vals = null;

  private static function assemble_css() {
    $str = '';
    foreach(static::$css as $file) {
      $str .= '<link rel="stylesheet" type="text/css" href="' . V::file($file['file']) . '" ' . (isset($file['media']) ? 'media="' . $file['media'] . '" ' : '') . '/>';
    }
    return $str;
  }

  private static function assemble_js() {
    $str = '';
    foreach(static::$js as $file) {
      $str .= '<script src="' . V::file($file) . '"></script>';
    }
    return $str;
  }

  private static function makeParts() {
    $partlist = array();
    foreach(json_decode(file_get_contents('parts/parts.json'), true) as $part) {
      if(isset($part['js'])) {
        static::$js[] = $part['js'];
      }
      if(isset($part['css'])) {
        foreach($part['css'] as $style) {
          static::$css[] = $style;
        }
      }
      $partlist[$part['name']] = $part;
    }
    static::$parts = $partlist;
  }

  static function assemble(string $part, $vars = array()) {
    if(static::$parts === null) {
      static::makeParts();
    }

    if(static::$vals == null) {
      static::$vals = json_decode(file_get_contents('values.json'), true);
    }

    if(!isset(static::$parts[$part])) {
      return null;
    }
    $output = '';
    $name = $part;
    $part = static::$parts[$part];
    if($part['dynamic'] == false) {
      $output = assemble_generic(file_get_contents('parts/' . $name . '.html'), $vars);
    } else {
      require_once('parts/' . $name . '.php');
      $output = call_user_func('assemble_' . str_replace('-', '_', $name), file_get_contents('parts/' . $name . '.html'), $vars);
    }

    $output = preg_replace_callback('%\$VAR_([^$]+)\$%', function($matches) {
      $match = $matches[1];
      if(!isset(static::$vals[$match])) {
        return '';
      }
      return static::$vals[$match];
    }, $output);

    $output = str_replace('$PART_CSS$', static::assemble_css(), $output);
    $output = str_replace('$PART_JS$', static::assemble_js(), $output);

    return $output;
  }
}

function assemble_generic($partData, $vars) {
  $partData = preg_replace_callback('%\$VAR_([^$]+)\$%', function($matches) use($vars) {
      $match = $matches[1];
      if(!isset(Assembler::$vals[$match]) && !isset($vars[$match])) {
        return '';
      }
      return isset($vars[$match]) ? $vars[$match] : Assembler::$vals[$match];
    }, $partData);

  preg_match_all('%\$PART_([^$]+)\$%', $partData, $parts);
  foreach($parts[1] as $part) {
    if($part == 'CSS' || $part == 'JS') continue;
    $partData = str_replace('$PART_' . $part . '$', Assembler::assemble($part), $partData);
  }

  return $partData;
}

?>