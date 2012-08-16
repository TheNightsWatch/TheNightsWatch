<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/Date.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/titleBar.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/messageQueue.js?v=20120815v2');
$lastID = 0;
?>
<ol id="messages">
	<li id="template">[<span class="timestamp" data-epoch=""></span>] &lt;<a
		href="" class="username"></a>&gt; <span class="message"></span>
	</li>
	<?php foreach($messages as $message): $lastID = $message->id; ?>
	<li>[<span class="timestamp"
		data-epoch="<?php echo $message->timestamp->getTimestamp(); ?>"
		title="<?php echo $message->timestamp->format("H:i:s"); ?>"><?php echo $message->timestamp->format("H:i"); ?>
	</span>] &lt;<a
		href="<?php echo $this->createUrl('user/view',array('unique' => $message->user->ign)); ?>"
		class="username"
		title="<?php echo htmlspecialchars($message->user->title); ?>"><?php echo htmlspecialchars($message->user->ign); ?>
	</a>&gt; <span class="message"><?php echo TextParser::parse(htmlspecialchars($message->message)); ?>
	</span>
	</li>
	<?php endforeach; ?>
</ol>
<form id="chatForm"
	action="<?php echo $this->createUrl('chat/post'); ?>" method="post">
	<input class="csrf" type="hidden"
		name="<?php echo Yii::app()->request->csrfTokenName ?>"
		value="<?php echo Yii::app()->request->csrfToken ?>" /> <input
		type="text" autocomplete="off" name="ChatForm[message]" id="message" />
	<button disabled>send</button>
</form>
<label id="enableNotifs" style="display: none">Desktop Notifications: <select
	id="notify_chat"><option value="none">None</option>
		<option value="show">Show</option>
		<option value="collapse">Collapse (And Hide)</option>
		<option value="collapse_perm">Collapse (And Keep)</option>
</select>
</label>
<script>
document.myIGN = <?php echo json_encode(User::model()->findByPk(Yii::app()->user->getId())->ign); ?>;
document.titleBar = new titleBar();
document.messageQueue = new messageQueue(<?php echo $lastID; ?>,<?php echo json_encode($this->createUrl('chat/new')); ?>);
$(document).ready(function()
{
	$('#messages').prop({ scrollTop: $('#messages').prop('scrollHeight') });
	document.messageQueue.initialLoad(document.messageQueue);
	$('#message').on('keyup',function() {
		if($(this).val().length > 0 && $('#chatForm button').attr('disabled')) $('#chatForm button').attr('disabled',false);
		else if($(this).val().length < 1) $('#chatForm button').attr('disabled',true);
	});
	$('#chatForm').on('submit',function(e) {
		e.preventDefault();
		var data = $('#chatForm').serialize();
		$('#chatForm input,#chatForm button').attr('disabled',true);
		$.post('<?php echo $this->createUrl('chat/post'); ?>',data,function() {
			document.messageQueue.load(undefined,function()
			{
				$('#chatForm input,#chatForm button').attr('disabled',false);
				$('#message').val('');
			});
		});
	});
	$('#messages .timestamp').each(function(i,ele) {
		var ele = $(ele);
		var date = new Date(ele.attr('data-epoch')*1000);
		ele.attr('title',date.getLargeChatStamp()).text(date.getSmallChatStamp());
	});
	setTimeout(function() {
		if(!window.Notification || typeof(Storage) == "undefined") return;
		
		if(Notification.permissionLevel() == "granted") $('#notify_chat').val(localStorage['notify_chat']);

		$('#notify_chat').on('change',function() {
			var enable = function() { localStorage['notify_chat'] = $('#notify_chat').val(); }
			switch(Notification.permissionLevel())
			{
			case "granted":
				enable();
				break;
			case "denied":
				alert('Please enable Notifications in your browser\'s settings');
				break;
			case "default":
			default:
				//Notification.requestPermission(function() { if(Notification.permissionLevel() == "granted") enable(); }); // Crashes in Chrome 21
				window.webkitNotifications.requestPermission(function() { if(Notification.permissionLevel() == "granted") enable(); });
			}
		});

		$('#enableNotifs').show();
	},1);
});
</script>
<style>
#template {
	display: none;
}

#messages,#chatters {
	list-style-type: none;
	margin: 0px;
	padding: 0px;
}

#messages a.username,#chatters a.username {
	color: #317396;
	text-decoration: none;
}

#messages a.username:hover,#chatters a.username:hover {
	color: #06C;
}

#chatters {
	color: #317396;
}

#chatters li {
	line-height: 16px;
	padding-bottom: 2px;
}

#chatters li img {
	width: 16px;
	height: 16px;
	vertical-align: middle;
}

#messages {
	display: block;
	width: 100%;
	height: 300px;
	overflow-y: scroll;
	overflow-x: hidden;
}

#messages li {
	color: white;
	padding-bottom: 3px;
	font-size: 6pt;
}

#messages li * {
	font-size: 10pt;
}

#messages .timestamp {
	color: #999;
}

#messages .username {
	color: #317396;
}

#messages .message {
	color: #444;
}

#chatForm {
	width: 100%;
}

#chatForm input {
	width: 645px;
}

#chatForm button {
	width: 50px;
}

#announcement {
	border: 1px solid #DDD;
	padding: 5px;
	margin: 5px 20px 0px 20px;
}
</style>
