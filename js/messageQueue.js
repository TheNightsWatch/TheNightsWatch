function messageQueue(lastID, pingURL) {
	this.lastID = lastID;
	this.pingURL = pingURL;
	this.currentTimeout = undefined;
	this.focused = true;

	var _this = this;

	// Is the user focused on our window?
	$(document).ready(function() {
		$(window).on('focus', function() {
			_this.focused = true;
			// hide notifications
		});
		$(window).on('blur', function() {
			_this.focused = false;
		});
	});
}
messageQueue.prototype.initialLoad = function(_this) {
	if (this.currentTimeout)
		clearTimeout(this.currentTimeout);
	var _this = this;
	_this.currentTimeout = setTimeout(function() {
		_this.load(_this);
	}, 2000);
};
messageQueue.prototype.load = function(_this, callback, errorCallback) {
	if (errorCallback === undefined)
		errorCallback = function() { };
	if (_this === undefined)
		var _this = this;
	if (_this.currentTimeout)
		clearTimeout(_this.currentTimeout);
	$.getJSON(_this.pingURL + '?since=' + _this.lastID, function(data) {
		setTimeout(function() {
			var nuserol = $('#chatters').clone();
			nuserol.html('');
			for ( var i in data.users) {
				var li = $(document.createElement("li"));
				var a = $(document.createElement("a"));
				a.attr('href', data.users[i].url).addClass('username').attr(
						'title', data.users[i].title);
				var img = $(document.createElement("img"));
				img.attr('src', data.users[i].img);
				a.append(img);
				a.html(a.html() + ' ' + data.users[i].ign);
				li.append(a);
				nuserol.append(li);
			}
			$('#chatters').html(nuserol.html());
		}, 1);

		if (!data.messages.length)
			return;
		var ele = $('#template').clone();
		ele.removeAttr('id');
		var scroll = _this.getShouldScroll();
		for ( var i in data.messages) {
			if (data.messages[i].id <= _this.lastID)
				continue;

			var mData = data.messages[i];

			_this.lastID = mData.id;

			var li = ele.clone();
			var date = new Date(mData.timestamp * 1000);
			li.find('.timestamp').attr('title', date.getLargeChatStamp()).text(
					date.getSmallChatStamp());
			li.find('.username').text(mData.user.ign).attr('href',
					mData.user.url).attr('title', mData.user.title);
			li.find('.message').html(mData.html);
			$('#messages').append(li);
			if (data.messages[i].user.ign != document.myIGN) {
				document.titleBar.flashMessage(mData.user.ign);

				var doThings = function(mData) {
					setTimeout(function() {
						if (!window.Notification)
							return;
						if (typeof (Storage) == "undefined")
							return;
						if (localStorage['notify_chat'] == "none")
							return;
						if (Notification.permissionLevel() != "granted")
							return;

						var options = {};
						options.body = mData.text;
						options.iconUrl = mData.user.img;
						if (localStorage['notify_chat'] == 'show')
							options.tag = 'notif-' + mData.id;
						if (localStorage['notify_chat'] == 'collapse')
							options.tag = 'notif';

						console.log(options.tag);

						var n = webkitNotifications.createNotification(
								options.iconUrl, mData.user.ign, options.body);
						n.replaceId = options.tag;
						n.show();

						if (localStorage['notify_chat'] == 'collapse_perm')
							return;
						setTimeout(function() {
							n.cancel();
						}, 3000);
					}, 1);
				};
				if(!_this.focused) doThings(mData);
			}
		}

		$('#chatForm .csrf').attr('name', data.csrf.name).attr('value',
				data.csrf.token);
		
		var distance = (100 - $(".slider-vertical").slider("value")) * $('#messages').height();
		setSlider($('#chat'));
		$(".slider-vertical").slider("value", 100.0 - (distance / $('#messages').height()));	

		if (scroll)
			_this.doScroll();
		if (callback !== undefined)
			callback();
	}).error(errorCallback);
	_this.currentTimeout = setTimeout(function() {
		_this.load(_this);
	}, 2000);
};
messageQueue.prototype.getShouldScroll = function() {
	if ($(".slider-vertical").slider("value") == 0)
		return true;
	return false;
};
messageQueue.prototype.doScroll = function() {
	$(".slider-vertical").slider("value",0);
};
