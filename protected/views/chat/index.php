<?php Yii::app()->clientScript->registerCoreScript('jquery'); $lastID = 0; ?>
<ol id="messages">
	<li id="template">[<span class="timestamp"></span>] &lt;<span class="username"></span>&gt; <span class="message"></span></li>
	<?php foreach($messages as $message): $lastID = $message->id; ?>
		<li>[<span class="timestamp"><?php echo $message->timestamp->format("H:i:s"); ?></span>] &lt;<span class="username"><?php echo htmlspecialchars($message->user->ign); ?></span>&gt; <span class="message"><?php echo htmlspecialchars($message->message); ?></span></li>
	<?php endforeach; ?>
</ol>
<form id="chatForm" action="<?php echo $this->createUrl('chat/post'); ?>" method="post">
	<input class="csrf" type="hidden" name="<?php echo Yii::app()->request->csrfTokenName ?>" value="<?php echo Yii::app()->request->csrfToken ?>" />
	<input type="text" autocomplete="off" name="ChatForm[message]" id="message" />
	<button disabled>send</button>
</form>
<script>
function messageQueue()
{
	this.lastID = <?php echo $lastID; ?>;
	this.currentTimeout = undefined;
}
messageQueue.prototype.initialLoad = function()
{
	if(this.currentTimeout) clearTimeout(this.currentTimeout);
	_this = this;
	_this.currentTimeout = setTimeout(function() { _this.load(_this) },2000);
}
messageQueue.prototype.load = function(_this,callback)
{
	if(_this === undefined) _this = this;
	console.log('messageQueue.load');
	if(_this.currentTimeout) clearTimeout(_this.currentTimeout);
	$.getJSON('<?php echo $this->createUrl('chat/new'); ?>?since=' + _this.lastID,function(data)
	{
		setTimeout(function()
		{
			var nuserol = $('#chatters').clone();
			nuserol.html('');
			for(var i in data.users)
			{
				var li = $(document.createElement("li"));
				li.text(data.users[i].ign);
				nuserol.append(li);
			}
			$('#chatters').html(nuserol.html());
		},1);
		
		if(!data.messages.length) return;
		var ele = $('#template').clone();
		ele.removeAttr('id');
		var scroll = getShouldScroll();
		for(var i in data.messages)
		{
			if(data.messages[i].id <= _this.lastID) continue;
			_this.lastID = data.messages[i].id;
			
			var li = ele.clone();
			li.find('.timestamp').text(data.messages[i].timestamp);
			li.find('.username').text(data.messages[i].user.ign);
			li.find('.message').text(data.messages[i].message);
			$('#messages').append(li);
		}

		$('#chatForm .csrf').attr('name',data.csrf.name).attr('value',data.csrf.token);
		if(scroll) doScroll();
		if(callback !== undefined) callback();
	});
	_this.currentTimeout = setTimeout(function() { _this.load(_this) },2000);
}

document.messageQueue = new messageQueue;
$(document).ready(function()
{
	$('#messages').prop({ scrollTop: $('#messages').prop('scrollHeight') });
	document.messageQueue.initialLoad();
	$('#message').on('keyup',function() {
		if($(this).val().length > 0 && $('#chatForm button').attr('disabled')) $('#chatForm button').attr('disabled',false);
		else if($(this).val().length < 1) $('#chatForm button').attr('disabled',true);
	});
	$('#chatForm').on('submit',function(e) {
		e.preventDefault();
		console.log('Doing Ajax Submit');
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
});
function getShouldScroll()
{
	var height = $('#messages').height();
	var scrollHeight = $('#messages').prop('scrollHeight');
	if(scrollHeight-height == $('#messages').prop('scrollTop'))
		return true;
	return false;
}
function doScroll()
{
	$('#messages').prop({scrollTop:$('#messages').prop('scrollHeight')});
}
</script>
<style>
#template { display: none; }
#messages,#chatters { list-style-type: none; margin: 0px; padding: 0px; }
#messages
{
	display: block;
	width: 100%;
	height: 300px;
	overflow-y: scroll;
}
#chatForm
{
	width: 100%;
}
#chatForm input
{
	width: 645px;
}
#chatForm button
{
	width: 50px;
}
</style>