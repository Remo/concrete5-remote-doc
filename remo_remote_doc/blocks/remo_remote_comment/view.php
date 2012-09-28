<?php
defined('C5_EXECUTE') or die('Access Denied.');
?>


<?php
foreach ($comments as $comment) {
    echo "<div style=\"border: 1px solid gray;margin-bottom: 5px;\">{$comment['comment']}</div>";
} 
?>
<form method="post" action="<?php echo $actionUrl?>">
<input type="hidden" name="bID" value="<?php echo $bID?>"/>
<br/>
<textarea name="comment"></textarea>
<br/>
<input type="submit" value="<?php echo t('Post Comment')?>"/>
</form>

