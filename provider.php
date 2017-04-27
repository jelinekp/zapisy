<?php
class Provider {
  private static $subjectsCache = null;
  private static $groupsCache = null;

  static function getSubjects() {
    if(static::$subjectsCache != null) return static::$subjectsCache;

    $subjects = json_decode(file_get_contents('subjects.json'), true);
    $groups = static::getGroups();
    $out = array();

    foreach($subjects as $subject) {
      $name = $subject['name'];
      if(isset($subject['gsid'])) {
        $group = $groups[$subject['gsid']];
        $subgroups = array();
        if(isset($subject['cgid'])) {
          $subgroupsgid = explode('|', $subject['cgid']);
          foreach($subgroupsgid as $subgid) {
            $subgroups[] = $groups[$subject['gsid']]['gids'][$subgid];
          }
        } else {
          $subgroups = $groups[$subject['gsid']]['gids'];
        }
        if(count($subgroups) > 1) {
          foreach($subgroups as $subgrp) {
            $out[] = ['name' => $name . ' (' . $subgrp['gid'] . ')'];
          }
        } else {
          $out[] = ['name' => $name];
        }
      } else {
        $out[] = ['name' => $name];
      }
    }

    static::$subjectsCache = $out;
    return $out;
  }

  static function getGroups() {
    if(static::$groupsCache != null) return static::$groupsCache;

    $groups = json_decode(file_get_contents('groups.json'), true);
    $out = array();

    foreach($groups as $gsid) {
      $gsid['gids'] = array();
      foreach($gsid['groups'] as $group) {
        $gsid['gids'][$group['gid']] = $group;
      }
      $out[$gsid['gsid']] = $gsid;
    }

    static::$groupsCache = $out;
    return $out;
  }
}
?>