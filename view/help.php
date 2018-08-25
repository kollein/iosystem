<?php
$question_id = $_GET['question'] + 0;
$TABLE = HELP_QUESTION;
$query = "SELECT *FROM $TABLE WHERE id = $question_id";
$mainRi->selectQuery($query);
$rowHELP_QUESTION = $mainRi->_rendata[0];
?>
<section class="container">
	<div class="help-container">
		<div class="help-wrapper">
			<?=$rowHELP_QUESTION['DESCRIPTION'];?>
		</div>
	</div>
</section>