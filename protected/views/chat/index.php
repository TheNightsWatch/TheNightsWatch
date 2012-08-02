<?php Yii::app()->clientScript->registerCoreScript('jquery'); $lastID = 0; ?>
<ol id="messages">
	<li id="template">[<span class="timestamp"></span>] &lt;<span class="username"></span>&gt; <span class="message"></span></li>
	<?php foreach($messages as $message): $lastID = $message->id; ?>
		<li><span class="timestamp" title="<?php echo $message->timestamp->format("H:i:s"); ?>"><?php echo $message->timestamp->format("H:i"); ?></span> <span class="username"><?php echo htmlspecialchars($message->user->ign); ?></span> <span class="message"><?php echo htmlspecialchars($message->message); ?></span></li>
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
			var timestamp = data.messages[i].timestamp;
			var stime = timestamp.split(":");
			stime.pop();
			var stime = stime.join(":");
			li.find('.timestamp').attr('title',timestamp).text(stime);
			li.find('.timestamp').text(data.messages[i].timestamp);
			li.find('.username').text(data.messages[i].user.ign);
			li.find('.message').text(data.messages[i].message);
			$('#messages').append(li);
			document.titleBar.flashMessage(data.messages[i].user.ign);
		}

		$('#chatForm .csrf').attr('name',data.csrf.name).attr('value',data.csrf.token);
		if(scroll) doScroll();
		if(callback !== undefined) callback();
	});
	_this.currentTimeout = setTimeout(function() { _this.load(_this) },2000);
}
function titleBar() {
	this.counter = 0;
	this.newFlag = false;
	this.flashingFlag = false;
	this.flashingMsgFlag = false;
	this.flashingMsg = "";
	this.showingFlashMsg = false;
	this.lastUpdate = { counter: 0, newFlag: false, title: '' };
	this.focused = true;
	this.onlyFlashWhenNotFocused = true;
	_this = this;
	$(window).on('focus',function() 
	{ 
		_this.focused = true;
		if(_this.onlyFlashWhenNotFocused)
		{
			console.log('Turning off flash message');
			_this.flashMessage(false,_this);
		}
	});
	$(window).on('blur',function()
	{ 
		_this.focused = false; 
	});
}
titleBar.prototype.update = function(counter,newFlag,_this)
{
	if(_this === undefined) _this = this;
	_this.updateTitlebar(counter,newFlag,_this);
}
titleBar.prototype.updateTitlebar = function(counter,newFlag,_this)
{
	if(_this === undefined) _this = this;
	if(counter !== undefined && counter !== null) _this.counter = counter;
	if(newFlag !== undefined && newFlag !== null) _this.newFlag = newFlag;
	if(document.title == _this.lastUpdate.title && _this.counter == _this.lastUpdate.counter && _this.newFlag == _this.lastUpdate.newFlag) return false;
	var newTitle = "";
	if(_this.newFlag)
		newTitle = '(*) ';
	if(_this.counter > 0)
		newTitle = newTitle + "(" + _this.counter + ") ";
	newTitle = newTitle + _this.getOriginal(_this);

	document.title = newTitle;
	_this.showingFlashMsg = false;
	_this.lastUpdate = { counter: _this.counter, newFlag: _this.newFlag, title: _this.title };
}
titleBar.prototype.flashMessage = function(message,_this)
{
	if(_this === undefined) _this = this;
	console.log(_this);
	if(message === undefined || message == null || message == false)
	{
		_this.flashingMsgFlag = false;
		_this.showingFlashMsg = false;
		clearInterval(_this.flashMsgInterval);
		_this.updateTitlebar(undefined,undefined,_this);
	} else {
		if(_this.onlyFlashWhenNotFocused && _this.focused) return false;
		_this.flashMessage(false);
		_this.flashingMsgFlag = true;
		_this.flashMsg = message;
		_this.flashMsgInterval = setInterval(function()
		{
			if(_this.showingFlashMsg)
			{
				_this.update(undefined,undefined,_this);
				_this.showingFlashMsg = false;
			}
			else
			{
				document.title = _this.flashMsg;
				_this.showingFlashMsg = true;
			}
		},1000);
	}
}
titleBar.prototype.flash = function(truefalse,_this)
{
	if(_this === undefined) _this = this;
	if(_this.onlyFlashWhenNotFocused && _this.focused) return false;
	if(truefalse == undefined) { truefalse = !(_this.flashingFlag); }
	if(truefalse)
	{
		_this.flashingFlag = true;
		_this.flashInterval = setInterval(function() {
			_this.updateTitlebar(null,!(_this.newFlag),_this); 
		},1000);
	}
	else
	{
		_this.flashingFlag = false;
		clearInterval(_this.flashInterval);
		_this.updateTitlebar(null,false,_this);
	}
}
titleBar.prototype.getOriginal = function(_this)
{
	var title = document.getElementsByTagName("title")[0];
	if(!title.getAttribute("data-original"))
		title.setAttribute("data-original",title.innerHTML);
	return title.getAttribute("data-original");
}
document.titleBar = new titleBar;
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
#messages li { color: white; padding-bottom: 3px; font-size: 1pt; }
#messages li span { font-size: 10pt; }
#messages .timestamp { color: #999; }
#messages .username { color: #317396; }
#messages .message { color: #444; }
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