<?php
require_once "db.php";

if(!isset($_POST['action'])) {
  echo "ERROR: No action specified";
  exit(0);
}

if(!isset($_POST['iid'])) {
  echo "ERROR: InstanceID not set";
}

switch($_POST['action']) {
  case 'getRequestId':
    echo '{"res":"OK","nonce":"' . DB::getActionID($_POST['iid']) . '"}';
    break;
  case 'addExam':
    DB::addExam($_POST['iid'], $_POST['nonce'], $_POST['subject'], $_POST['range'], $_POST['date']);
    break;
  case 'deleteExam':
    DB::deleteExam($_POST['iid'], $_POST['nonce'], $_POST['eid']);
    break;
  case 'updateExam':
    DB::updateExam($_POST['iid'], $_POST['nonce'], $_POST['eid'], $_POST['range'], $_POST['date']);
    break;
}
?>