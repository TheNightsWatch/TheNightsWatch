<?php
$lastHead = null;
foreach($elections as $election): 
if($election->endTime != $lastHead): ?><h2>For the elections ending <?= $election->endTime->format("F d, Y"); ?>:</h2><dl><?php endif; ?>
<dt><?= htmlspecialchars($election->title); ?></dt>
<?php foreach($election->candidates as $candidate): ?>
<dd><?= htmlspecialchars($candidate->user->ign); ?> (<?= ElectionVote::model()->countByAttributes(array('electionID' => $election->id, 'candidateID' => $candidate->user->id)); ?>)</dd>
<?php endforeach; ?>
<!-- <dd><?= htmlspecialchars($election->winner->ign); ?></dd> -->
<?php 
if($election->endTime != $lastHead): ?></dl><?php $lastHead = $election->endTime; endif;
endforeach;
?>