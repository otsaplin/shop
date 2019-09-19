<script src="jquery.js"></script>
<script src="jquery-countdown-timer-control.js"></script>

<style>
.timer{
	display: -webkit-inline-box;
    font-size: -webkit-xxx-large;
}
#controls{
    display: -webkit-inline-box;
}
#controls > div{
	margin:5px;
}
.jst-timeout{
color:red
}
</style>
#### Example

##### Basic
<div class="timer timer0" data-minutes-left="0.05"></div>

Source:
```js
<div class="timer timer0" data-minutes-left="0.05"></div>

<script src="jquery.js"></script>
<script src="jquery-countdown-timer-control.js"></script>
<script>
$(function(){
	var timer0=$('.timer0').startTimer({}).trigger('start');
});
</script>
<style>
.timer{
	display: -webkit-inline-box;
    font-size: -webkit-xxx-large;
}
  // These are the default CSS classes generate by this plugin
  .jst-hours, .jst-minutes, .jst-seconds{
    float: left;
  }
  .jst-clearDiv {
    clear: both;
  }
  .jst-timeout {
    color: red;
  }
</style>
```

##### With control
<div class="timer timer1" data-minutes-left="0.1"></div>
<br>
<div id="controls">
<div class="timerstart">start</div>
<div class="timerpause">pause</div>
<div class="timerreset">reset</div>
</div>
Source:
```js
<div class="timer timer1" data-minutes-left="0.1"></div>

<div id="controls">
<div class="timerstart">start</div>
<div class="timerpause">pause</div>
<div class="timerreset">reset</div>
</div>
<script>
$(function(){
	var timer1=$('.timer1').startTimer({
		onComplete: function(element){console.log('Complete');}
		,onPause: $('.timerpause'),
		onReset: $('.timerreset'),
		onStart: $('.timerstart')
	})	
});
</script>
```

##### Without control
<div class="timer timer2" data-minutes-left="0.2"></div>
```js
<div class="timer timer2" data-minutes-left="0.2"></div>

<script>
$(function(){
		var timer2=$('.timer2').startTimer({
			onComplete: function(element){console.log('Complete');}
			//,onPause: $('.timerpause'), //optional, pause control
			//onReset: $('.timerreset'), //optional, reset control
			//onStart: $('.timerstart') //optional, start control
			//loop: true, //optional, enable loop
			//loopInterval: 2 //optional
		});
		timer2.trigger('start'); //optional, use to start without control button
		//timer2.trigger('pause'); //optional, use to pause without control button
		//timer2.trigger('resetime'); //optional, use to reset without control button
});
</script>

```


<script>
    $(function(){
		//default
		var timer0=$('.timer0').startTimer({}).trigger('start');
	
		//with control
		var timer1=$('.timer1').startTimer({
			onComplete: function(element){console.log('Complete');}
			,onPause: $('.timerpause'),
			onReset: $('.timerreset'),
			onStart: $('.timerstart')
		});
		
		//without control
		var timer2=$('.timer2').startTimer({
			onComplete: function(element){console.log('Complete');}
			//,onPause: $('.timerpause'), //optional, pause control
			//onReset: $('.timerreset'), //optional, reset control
			//onStart: $('.timerstart') //optional, start control
			//loop: true, //optional, enable loop
			//loopInterval: 2 //optional
		});
		timer2.trigger('start'); //optional, use to start without control button
		//timer2.trigger('pause'); //optional, use to pause without control button
		//timer2.trigger('resetime'); //optional, use to reset without control button
	})
</script>
