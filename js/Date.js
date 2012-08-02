Date.prototype.getPaddedMinutes = function(_this)
{
	if(_this === undefined) _this = this;
	var m = _this.getMinutes();
	if(m < 10) m = '0' + m;
	return m;
};
Date.prototype.getPaddedHours = function(_this)
{
	if(_this === undefined) _this = this;
	var h = _this.getHours();
	if(h < 10) h = '0' + h;
	return h;
};
Date.prototype.getPaddedSeconds = function(_this)
{
	if(_this === undefined) _this = this;
	var s = _this.getSeconds();
	if(s < 10) s = '0' + s;
	return s;
};
Date.prototype.getSmallChatStamp = function(_this)
{
	if(_this === undefined) _this = this;
	return _this.getPaddedHours() + ':' + _this.getPaddedMinutes();
};
Date.prototype.getLargeChatStamp = function(_this)
{
	if(_this === undefined) _this = this;
	return _this.getPaddedHours() + ':' + _this.getPaddedMinutes() + ':' + _this.getPaddedSeconds();
};