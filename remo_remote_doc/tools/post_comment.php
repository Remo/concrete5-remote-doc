<?php
// TODO this is stupid, we can't rely on this, just to test..
$origin = $_SERVER['HTTP_REFERER'];
$bID = intval($_REQUEST['bID']);
$th = Loader::helper('text');
$comment = $th->sanitize($_REQUEST['comment']);

$db = Loader::db();
$db->Execute('INSERT INTO btRemoRemoteCommentComment (bID, comment) VALUES (?,?)', array($bID, $comment));

header("Location: $origin");
exit;
?>