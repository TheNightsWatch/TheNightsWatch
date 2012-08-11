function messageQueue(lastID,pingURL)
{
	this.lastID = lastID;
	this.pingURL = pingURL;
	this.currentTimeout = undefined;
}
messageQueue.prototype.initialLoad = function(_this)
{
	if(this.currentTimeout) clearTimeout(this.currentTimeout);
	_this = this;
	_this.currentTimeout = setTimeout(function() { _this.load(_this); },2000);
};
messageQueue.prototype.load = function(_this,callback)
{
	if(_this === undefined) _this = this;
	if(_this.currentTimeout) clearTimeout(_this.currentTimeout);
	$.getJSON(_this.pingURL + '?since=' + _this.lastID,function(data)
	{
		setTimeout(function()
		{
			var nuserol = $('#chatters').clone();
			nuserol.html('');
			for(var i in data.users)
			{
				var li = $(document.createElement("li"));
				var a = $(document.createElement("a"));
				a.attr('href',data.users[i].url).addClass('username').attr('title',data.users[i].title);
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
		var scroll = _this.getShouldScroll();
		for(var i in data.messages)
		{
			if(data.messages[i].id <= _this.lastID) continue;
			_this.lastID = data.messages[i].id;
			
			var li = ele.clone();
			var date = new Date(data.messages[i].timestamp*1000);
			li.find('.timestamp').attr('title',date.getLargeChatStamp()).text(date.getSmallChatStamp());
			li.find('.username').text(data.messages[i].user.ign).attr('href',data.messages[i].user.url).attr('title',data.messages[i].user.title);
			li.find('.message').html(data.messages[i].html);
			$('#messages').append(li);
			if(data.messages[i].user.ign != document.myIGN)
			{
				document.titleBar.flashMessage(data.messages[i].user.ign);
				setTimeout(function() { if(window.webkitNotifications)
				{
					if(window.webkitNotifications.checkPermission() != 0) return;

					var notif = window.webkitNotifications.createNotification(data.messages[i].user.img,data.messages[i].user.ign,data.messages[i].text);
					notif.ondisplay = function() { setTimeout(function() { notif.cancel(); },3000); };
					notif.show();
				}; },1);
			};
		}

		$('#chatForm .csrf').attr('name',data.csrf.name).attr('value',data.csrf.token);
		if(scroll) _this.doScroll();
		if(callback !== undefined) callback();
	});
	_this.currentTimeout = setTimeout(function() { _this.load(_this); },2000);
};
messageQueue.prototype.getShouldScroll = function()
{
	var height = $('#messages').height();
	var scrollHeight = $('#messages').prop('scrollHeight');
	if(scrollHeight-height == $('#messages').prop('scrollTop'))
		return true;
	return false;
};
messageQueue.prototype.doScroll = function()
{
	$('#messages').prop({scrollTop:$('#messages').prop('scrollHeight')});
};