# jQuery countdown timer control

jQuery countdown timer plugin with optional control button, based on the https://github.com/caike/jQuery-Simple-Timer

Help support lighthanabi on Patreon<br>
<a href="https://www.patreon.com/lighthanabi"><img src="https://c5.patreon.com/external/logo/become_a_patron_button@2x.png" width="150" alt="Become a Patron Button"/></a>

live demo can be find here: <br>
https://lighthanabi.github.io/jQuery-countdown-timer-control/

## Usage
You can use it with/without control button

```HTML
default
<div class="timer timer0" data-minutes-left="0.05"></div>
<br>
with control
<div class="timer timer1" data-minutes-left="0.1"></div>
<br>
<div id="controls">
<div class="timerstart">start</div>
<div class="timerpause">pause</div>
<div class="timerreset">reset</div>
</div>
<br>
without control
<div class="timer timer2" data-minutes-left="0.2"></div>
```
```javascript
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
```

## Install

### Manaul
Download the repository and reference the following from your html:
```javascript
<script src="jquery.js"></script>
<script src="jquery-countdown-timer-control.js"></script>
```

### npm
```
npm install jquery-countdown-timer-control --save
npm install jquery --save //if you do not have
```
Include the following into you html file
```javascript
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/jquery-countdown-timer-control/jquery-countdown-timer-control.js"></script>
```
Or
```javascript
let $ = require("jquery");
require("jquery-countdown-timer-control")($); // passing jQuery as argument

$(function(){
  $('.timer').startTimer({}).trigger('start');
});
```
