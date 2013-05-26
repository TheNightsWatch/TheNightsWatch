<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/Date.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/titleBar.js?v=20120817v2');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/messageQueue.js?v=20120817v2');
$lastID = 0;
?>
<div id="chat">
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
</div>
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
		if($('#message').val() == '') return;
		var data = $('#chatForm').serialize();
		$('#chatForm input,#chatForm button').attr('disabled',true);
		$.post('<?php echo $this->createUrl('chat/post'); ?>',data,function() {
			document.messageQueue.load(undefined,function()
			{
				$('#chatForm input,#chatForm button').attr('disabled',false);
				$('#message').val('');
			},function()
			{
			    $('#chatForm input,#chatForm button').attr('disabled',false);
			});
		}).fail(function() { $('#chatForm input,#chatForm button').attr('disabled',false); });
	});
	$('#messages .timestamp').each(function(i,ele) {
		var ele = $(ele);
		var date = new Date(ele.attr('data-epoch')*1000);
		ele.attr('title',date.getLargeChatStamp()).text(date.getSmallChatStamp());
	});
    document.messageQueue.doScroll();
	setTimeout(function() {
	
		if(!window.webkitNotifications || typeof(Storage) == "undefined") return;
		
		if(window.webkitNotifications.checkPermission() == 0) $('#notify_chat').val(localStorage['notify_chat']);

		$('#notify_chat').on('change',function() {
			var enable = function() { localStorage['notify_chat'] = $('#notify_chat').val(); }
			switch(window.webkitNotifications.checkPermission())
			{
			case 0:
				enable();
				break;
			case 2:
				alert('Please enable Notifications in your browser\'s settings');
				break;
			case 1:
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

#chat { 
        position: relative;
	width: 710px;
        height: 300px;
        overflow-y: auto;
}
#chat::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}
#chat::-webkit-scrollbar-thumb {
    min-height: 28px;
    padding-top: 100px;
    background-clip: padding-box;
    background-color: rgba(0,0,0,0.2);
    -webkit-box-shadow: inset 1px 1px 0px rgba(0,0,0,0.1),inset 0px -1px 0px rgba(0,0,0,0.07);
}
#chat::-webkit-scrollbar-button {
    height: 0px;
    width: 0px;
}

#messages,#chatters {
	list-style-type: none;
	margin: 0px;
	padding: 0px;
}

#messages a.username,#chatters a.username {
	color: #d00021;
	text-decoration: none;
}

#messages a.username:hover,#chatters a.username:hover {
	color: #red;
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
	width: 683px;
}

#messages li {
	color: #101010;
	padding-bottom: 3px;
	font-size: 6pt;
}

#messages li * {
	font-size: 10pt;
}

#messages .timestamp {
	color: #444;
}

#messages .username {
	color: #d00021;
}

#messages .message {
	color: #999;
}

#chatForm {
	width: 100%;
}

#chatForm input {
	width: 645px;
	border: 1px solid #110f0f;
	background: #101010;
	border-radius: 2px;
	color: #ddd;
}
#chatForm input[disabled] {
	background: #0c0c0c;
	color: #444;
}

#chatForm button {
	width: 50px;
	border-radius: 2px;
	border: none;
	color: #ddd;
	background: #444;
}

#chatForm button[disabled] {
	background: #101010;
	color: black;
}

#notify_chat {
	background: #101010;
	border: 1px solid #110f0f;
	border-radius: 2px;
	color: #999;
}

label {
    color: #444;
}

#announcement {
	border: 1px solid #100f0f;
	padding: 5px;
	margin: 5px 20px 0px 20px;
        border-radius: 5px;
}
#scroll-pane,.scroll-pane{position:relative}
.scroll-content {position:absolute;top:0;left:0}
.slider-wrap{position:absolute;right:0;top:0;width:20px;}
.slider-vertical{position:relative;height:100%; border: 0 !important; background: none !important}
.ui-slider-handle{width:20px;height:10px;margin:0 auto;background-color:black;display:block;position:absolute}
.ui-slider-handle img{border:none}
.scrollbar-top{position:absolute;top:0;}
.scrollbar-bottom{position:absolute;bottom:0;}
.scrollbar-grip{position:absolute;top:50%;margin-top:-6px;}
.ui-slider-range{position:absolute;width:100%;}
</style>
