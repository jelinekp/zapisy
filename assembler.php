<?php
require_once('util.php');

class Assembler {
  private static $parts = null;
  private static $css = array();
  private static $js = array();

  private static function assemble_css() {
    $str = '';
    foreach(static::$css as $file) {
      $str .= '<link rel="stylesheet" type="text/css" href="' . V::file($file['file']) . '" ' . (isset($file['media']) ? 'media="' . $file['media'] . '" ' : '') . '/>\n';
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

  static function assemble(string $part, $vars = array()) {
    if(static::$parts === null) {
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

    if(!isset(static::$parts[$name])) {
      return null;
    }
    $output = '';
    $part = static::$parts[$name];
    if($part['dynamic'] == false) {
      $output = assemble_generic(file_get_contents('parts/' . $name . '.html'), $vars);
    } else {
      require_once('parts/' . $name . '.php');
      call_user_func('assemble_' . str_replace('-', '_', $name), file_get_contents('parts/' . $name . '.html'), $vars);
    }

    $vars = json_decode('values.json', true);
    $output = preg_replace_callback('%\$VAR_([^$]+)\$%', function($match) {
      if(!isset($vars[$match])) {
        echo '<span style="display: none;">Couldn\'t find variable ' . $match . '</span>';
        return '';
      }
      return $vars[$match];
    }, $output);

    $output = str_replace('$PART_CSS$', static::assemble_css(), $output);
    $output = str_replace('$PART_JS$', static::assemble_js(), $output);

    return $output;
  }
}

function assemble_generic($partData, $vars) {
  foreach($vars as $key => $value) {
    $partData = str_replace($key, $value, $partData);
  }

  preg_match_all('%\$PART_([^$]+)\$%', $partData, $parts);
  foreach($parts as $part) {
    $partData = str_replace('$PART_' . $part . '$', Assembler::assemble($part), $partData);
  }

  return $partData;
}

?>