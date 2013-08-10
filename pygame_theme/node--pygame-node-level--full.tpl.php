<p>Test template!</p>
<?php

//print(render($content));

?>
<table>
<tr>
<td>
<div id='results-container'>
<div id='results-div'>
<?php
$arena = ai_game_get_arena();
$step = $arena->render();
print($step);
?>
</div>
</div>
</td>
<td>
<?php print(drupal_render(drupal_get_form('ai_game_node_level_form_run'))); ?>

<?php
/*
<form>
<p>Enter code and hit run</p>
<textarea>
</textarea>
<input type='submit' value='Run'></input>
</form>
*/
?>

</td>
</tr>
</table>