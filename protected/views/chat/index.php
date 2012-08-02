<?php Yii::app()->clientScript->registerCoreScript('jquery'); $lastID = 0; ?>
<ol id="messages">
	<li id="template">[<span class="timestamp" data-epoch=""></span>] &lt;<a href="" class="username"></a>&gt; <span class="message"></span></li>
	<?php foreach($messages as $message): $lastID = $message->id; ?>
		<li>[<span class="timestamp" data-epoch="<?php echo $message->timestamp->getTimestamp(); ?>" title="<?php echo $message->timestamp->format("H:i:s"); ?>"><?php echo $message->timestamp->format("H:i"); ?></span>] &lt;<a href="<?php echo $this->createUrl('user/view',array('unique' => $message->user->ign)); ?>" class="username"><?php echo htmlspecialchars($message->user->ign); ?></a>&gt; <span class="message"><?php echo htmlspecialchars($message->message); ?></span></li>
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
Date.prototype.getPaddedMinutes = function(_this)
{
	if(_this === undefined) _this = this;
	var m = _this.getMinutes();
	if(m < 10) m = '0' + m;
	return m;
}
Date.prototype.getPaddedHours = function(_this)
{
	if(_this === undefined) _this = this;
	var h = _this.getHours();
	if(h < 10) h = '0' + h;
	return h;
}
Date.prototype.getPaddedSeconds = function(_this)
{
	if(_this === undefined) _this = this;
	var s = _this.getSeconds();
	if(s < 10) s = '0' + s;
	return s;
}
Date.prototype.getSmallChatStamp = function(_this)
{
	if(_this === undefined) _this = this;
	return _this.getPaddedHours() + ':' + _this.getPaddedMinutes();
}
Date.prototype.getLargeChatStamp = function(_this)
{
	if(_this === undefined) _this = this;
	return _this.getPaddedHours() + ':' + _this.getPaddedMinutes() + ':' + _this.getPaddedSeconds();
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
				var a = $(document.createElement("a"));
				a.attr('href',data.users[i].url).addClass('username');
				var img = $(document.createElement("img"));
				img.attr('src',data.users[i].img);
				a.append(img);
				a.html(a.html() + ' ' + data.users[i].ign);
				li.append(a);
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
			var date = new Date(data.messages[i].timestamp*1000);
			li.find('.timestamp').attr('title',date.getLargeChatStamp()).text(date.getSmallChatStamp());
			li.find('.username').text(data.messages[i].user.ign).attr('href',data.messages[i].user.url);
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
	$('#messages .timestamp').each(function(i,ele) {
		var ele = $(ele);
		var date = new Date(ele.attr('data-epoch')*1000);
		ele.attr('title',date.getLargeChatStamp()).text(date.getSmallChatStamp());
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
#messages a.username,#chatters a.username { color: #317396; text-decoration: none; }
#messages a.username:hover,#chatters a.username:hover { color: #06C; }
#chatters { color: #317396; }
#chatters li { line-height: 16px; padding-bottom: 2px; }
#chatters li img { width:16px;height:16px;vertical-align:middle; }
#messages
{
	display: block;
	width: 100%;
	height: 300px;
	overflow-y: scroll;
}
#messages li { color: white; padding-bottom: 3px; font-size: 6pt; }
#messages li * { font-size: 10pt; }
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