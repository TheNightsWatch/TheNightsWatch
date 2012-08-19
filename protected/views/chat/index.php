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
		}).error(function() { $('#chatForm input,#chatForm button').attr('disabled',false); });
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
        
        setSlider($('#chat'));
        $(".slider-vertical").slider("value",0);
});

function setSlider($scrollpane){//$scrollpane is the div to be scrolled
	
	//set options for handle image - amend this to true or false as required
	var handleImage = false;
	
	//change the main div to overflow-hidden as we can use the slider now
	$scrollpane.css('overflow','hidden');
	
	//if it's not already there, wrap an extra div around the scrollpane so we can use the mousewheel later
	if ($scrollpane.parent('.scroll-container').length==0) $scrollpane.wrap('<\div class="scroll-container"> /');
	//and again, if it's not there, wrap a div around the contents of the scrollpane to allow the scrolling
	if ($scrollpane.find('.scroll-content').length==0) $scrollpane.children().wrapAll('<\div class="scroll-content"> /');
	
	//compare the height of the scroll content to the scroll pane to see if we need a scrollbar
	var difference = $scrollpane.find('.scroll-content').height()-$scrollpane.height();//eg it's 200px longer 
	$scrollpane.data('difference',difference); 
	
	if(difference<=0 && $scrollpane.find('.slider-wrap').length>0)//scrollbar exists but is no longer required
	{
		$scrollpane.find('.slider-wrap').remove();//remove the scrollbar
		$scrollpane.find('.scroll-content').css({top:0});//and reset the top position
	}
	
	if(difference>0)//if the scrollbar is needed, set it up...
	{
		var proportion = difference / $scrollpane.find('.scroll-content').height();//eg 200px/500px
		
		var handleHeight = Math.round((1-proportion)*$scrollpane.height());//set the proportional height - round it to make sure everything adds up correctly later on
		handleHeight -= handleHeight%2; 
		
		//if the slider has already been set up and this function is called again, we may need to set the position of the slider handle
		var contentposition = $scrollpane.find('.scroll-content').position();	
		var sliderInitial = 100*(1-Math.abs(contentposition.top)/difference);
		
		if($scrollpane.find('.slider-wrap').length==0)//if the slider-wrap doesn't exist, insert it and set the initial value
		{
			$scrollpane.append('<\div class="slider-wrap"><\div class="slider-vertical"><\/div><\/div>');//append the necessary divs so they're only there if needed
		}
		
		$scrollpane.find('.slider-wrap').height($scrollpane.height());//set the height of the slider bar to that of the scroll pane
		sliderInitial = 100;
		
		//set up the slider 
		$scrollpane.find('.slider-vertical').slider({
			orientation: 'vertical',
			min: 0,
			max: 100,
			range:'min',
			value: sliderInitial,
			slide: function(event, ui) {
				var topValue = -((100-ui.value)*difference/100);
				$scrollpane.find('.scroll-content').css({top:topValue});//move the top up (negative value) by the percentage the slider has been moved times the difference in height
				$('ui-slider-range').height(ui.value+'%');//set the height of the range element
			},
			change: function(event, ui) {
				var topValue = -((100-ui.value)*($scrollpane.find('.scroll-content').height()-$scrollpane.height())/100);//recalculate the difference on change
				$scrollpane.find('.scroll-content').css({top:topValue});//move the top up (negative value) by the percentage the slider has been moved times the difference in height
				$('ui-slider-range').height(ui.value+'%');
		  }	  
		});
		
		//set the handle height and bottom margin so the middle of the handle is in line with the slider
		$scrollpane.find(".ui-slider-handle").css({height:handleHeight,'margin-bottom':-0.5*handleHeight});
		var origSliderHeight = $scrollpane.height();//read the original slider height
		var sliderHeight = origSliderHeight - handleHeight ;//the height through which the handle can move needs to be the original height minus the handle height
		var sliderMargin =  (origSliderHeight - sliderHeight)*0.5;//so the slider needs to have both top and bottom margins equal to half the difference
		$scrollpane.find(".ui-slider").css({height:sliderHeight,'margin-top':sliderMargin});//set the slider height and margins
		$scrollpane.find(".ui-slider-range").css({bottom:-sliderMargin});//position the slider-range div at the top of the slider container
		
		//if required create elements to hold the images for the scrollbar handle
		if (handleImage){
			$(".ui-slider-handle").append('<img class="scrollbar-top" src="/images/misc/scrollbar-handle-top.png"/>');
			$(".ui-slider-handle").append('<img class="scrollbar-bottom" src="/images/misc/scrollbar-handle-bottom.png"/>');
			$(".ui-slider-handle").append('<img class="scrollbar-grip" src="/images/misc/scrollbar-handle-grip.png"/>');
		}
	}//end if
		 
	//code for clicks on the scrollbar outside the slider
	$(".ui-slider").click(function(event){//stop any clicks on the slider propagating through to the code below
		event.stopPropagation();
	});
	   
	$(".slider-wrap").click(function(event){//clicks on the wrap outside the slider range
		var offsetTop = $(this).offset().top;//read the offset of the scroll pane
		var clickValue = (event.pageY-offsetTop)*100/$(this).height();//find the click point, subtract the offset, and calculate percentage of the slider clicked
		$(this).find(".slider-vertical").slider("value", 100-clickValue);//set the new value of the slider
	}); 
	
		 
	//additional code for mousewheel
	if($.fn.mousewheel){		
	
		$scrollpane.parent().unmousewheel();//remove any previously attached mousewheel events
		$scrollpane.parent().mousewheel(function(event, delta){
			
			var speed = Math.round(5000/$scrollpane.data('difference'));
			if (speed <1) speed = 1;
			if (speed >100) speed = 100;
	
			var sliderVal = $(this).find(".slider-vertical").slider("value");//read current value of the slider
			
			sliderVal += (delta*speed);//increment the current value
	 
			$(this).find(".slider-vertical").slider("value", sliderVal);//and set the new value of the slider
			
			event.preventDefault();//stop any default behaviour
		});
		
	}
	
}
</script>
<style>
#template {
	display: none;
}

#chat { 
        position: relative;
	width: 710px;
        height: 300px;
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
	width: 100%;
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
.slider-vertical{position:relative;height:100%}
.ui-slider-handle{width:20px;height:10px;margin:0 auto;background-color:black;display:block;position:absolute}
.ui-slider-handle img{border:none}
.scrollbar-top{position:absolute;top:0;}
.scrollbar-bottom{position:absolute;bottom:0;}
.scrollbar-grip{position:absolute;top:50%;margin-top:-6px;}
.ui-slider-range{position:absolute;width:100%;}
</style>
