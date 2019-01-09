$(document).ready(function() {
var notReload = false;
var maxTime = 7; // Seconds
var expandTime = 3; // expand Seconds
var countTime = 0;
var lastDownItem = null;

// check if device is touch screen
var TOUCHSCREEN = ('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0);

//	-- 		Object Slider value 	--	//

// Adjust slider
$(".obj-slider").each(function() {
	var THIS = $(this);
	var OBJECT = $(this).closest(".object");

	var setValue = parseInt($(".counter", THIS).text());
	$(".counter", THIS).text(setValue + " %");

	$(".slider-range-min", THIS).slider({
		range: "min",
		value: setValue,
		min: 0,
		max: 100,
		slide: function( event, ui ) {
			if( ui.value==0 )
				$(".counter", THIS).text("OFF");
			else
				$(".counter", THIS).text( ui.value + " %" );
		},
		stop: function(event, ui) {
			if( $(OBJECT).hasClass("turn-on") ) {
				var objName = $(OBJECT).find(".obj-header").html();
				UpdateObject(objName.toString(), "amplitude=" + ui.value);
			}
		}
	});
	
});


//	--		Object  	--	//

// Turn on/off
$(".obj-timer").on("click",function(e) {
	var OBJECT = $(this).closest(".object");

	if($(this).hasClass("obj-button-up-down-icon") || $(this).hasClass("ignore-onclick")){
		return;
	}

	if( !$(OBJECT).hasClass("turn-on") )
		TurnOn(OBJECT);
	else
		TurnOff(OBJECT);
});

var bPopup;
$(".obj-button-up-down-icon").bind("click",function(e) {
	e.preventDefault();

	if(notReload){
		console.log("[WARNING] notReload = true");
		return;
	}

	var getInput = $("input.range-value-input-" + $(this).attr("rangeInputId")).val();
	if(getInput == ""){
		alert("Yêu cầu nhập số giây hợp lệ");
		return;
	}

	try{
		if(isNaN(getInput)){
			alert("Yêu cầu nhập số giây hợp lệ");
			return;
		}

		maxTime = parseInt(getInput);
		if(isNaN(maxTime) || maxTime > 15){
			alert("Yêu cầu nhập số giây hợp lệ");
			return;
		}
	} catch{
		alert("Yêu cầu nhập số giây hợp lệ");
		return;
	}

	$(this).addClass("obj-button-up-down-mousedowning");
	lastDownItem = $(this);
	// console.log("$(this).closest:");
	// console.log($(this).closest(".object"))
	TurnOn($(this).closest(".object"));
	$(this).find('.obj-button-up-down').addClass("turn-on");
	console.log("Mouse down. Waiting for " + maxTime + " seconds");
	notReload = true;

	console.log("maxTime:" + maxTime);

	bPopup = $('#element_to_pop_up').bPopup({
		//appendTo: 'form'
		 zIndex: 20000
		, modalClose: false
		, escClose: false 
		, modalClose : false
	});
});

$(".obj-button-up-down-icon").on("off",function(e) {
	console.log("Mouse up");
	var obj = $(this);
	TurnOff(obj.closest(".object"));
	console.log("Waiting for 2 seconds...");
	setTimeout(function(){
		obj.removeClass("obj-button-up-down-mousedowning");
		$('.obj-button-up-down').removeClass("turn-on");
		bPopup.close();
		notReload = false;
		countTime = 0;
		console.log("Mouse up finished");
	}, 2000);
	
});


/*
$(".obj-button-up-down-icon").on("mousedown touchstart",function(e) {
	$(this).addClass("obj-button-up-down-mousedowning");
	TurnOn($(this).closest(".object"));
	$('.obj-button-up-down').addClass("turn-on");
	console.log("Mouse down");
	notReload = true;
});

$(".obj-button-up-down-icon").on("mouseup touchend",function(e) {
	console.log("Mouse up");
	var obj = $(this);
	setTimeout(function(){
		TurnOff(obj.closest(".object"));
		obj.removeClass("obj-button-up-down-mousedowning");
		$('.obj-button-up-down').removeClass("turn-on");
		notReload = false;
	}, 1000);
	
});

$(".obj-button-up-down-icon").on("mouseleave",function(e) {
	if($(this).hasClass("obj-button-up-down-mousedowning")){
		$(this).trigger("mouseup");
	}
});
*/

//	--	Object Switch 	--	//	

// 	Turn on/off by switch

$(".switch-button:not('.type-turn')").on("click", function() {
	$(this).toggleClass("switch-on");
	var OBJECT = $(this).closest(".object");
	if($(this).hasClass("switch-on"))
		TurnOn(OBJECT);
	else
		TurnOff(OBJECT);
});

//$(".obj-button").on("mousemove", function(){
	// alert("DI chuot");
//});

$(".switch-button.type-turn").on("click", function(){
	$(this).toggleClass("switch-on");
});

// button submit
$(".submit-button").on("click", function(){
	var OBJECT = $(this).closest(".object");
	var name = $(OBJECT).find("input[name='name']").val();
	if( !name ) {
		AlertBox("Enter name");
		return 0;
	}
	var status = $(OBJECT).find("input[name='state']").val();
	if( !status ) {
		AlertBox("Enter state");
		return 0;
	}
	var objId = $(this).attr("id-sub");
	var device_hostid = $(this).parents(".parent-item").first().data("device_hostid");

	SendSpecialState( name + ":" + status, objId, device_hostid);
});

if(TOUCHSCREEN) {
	$(".lazy-man").addClass("touch-device");
}
// Function turn on
function TurnOn(OBJECT) {
	if( $(OBJECT).hasClass("turn-on") ){
		console.log("$(OBJECT).hasClass('turn-on') == true; return;");
		return;
	}

	var objId = $(OBJECT).attr("id");
	var device_hostid = $(OBJECT).parents(".parent-item").first().data("device_hostid");

	$(OBJECT).addClass("turn-on").find(".switch-button:not('.type-turn')").addClass("switch-on");
	var objName = $(OBJECT).find(".obj-header").html();

	if($(OBJECT).hasClass("obj-slider")) {
		var amplitude = parseInt($(OBJECT).find(".counter").html());
		UpdateObject(objName.toString(), objId,"state=1,amplitude=" + amplitude, device_hostid);
	}else
		UpdateObject(objName.toString(), objId,"state=1", device_hostid);
	
}

// Function turn off
function TurnOff(OBJECT) {
	$(OBJECT).removeClass("turn-on");
	var objName = $(OBJECT).find(".obj-header").html();
	$(OBJECT).find(".switch-button").removeClass("switch-on");
	var objId = $(OBJECT).attr("id");

	var device_hostid = $(OBJECT).parents(".parent-item").first().data("device_hostid");

	UpdateObject(objName.toString(), objId,"state=0", device_hostid);
}

// update info of object to server
function UpdateObject(objName, objId, strUpdate, device_hostid) {
	console.log("objName: " + objName);
	console.log("strUpdate: " + strUpdate);
	console.log("device_hostid: " + device_hostid);
	
	var nameFile = objId;

	$.post(
		"function/data.php",
		{
			type : "update",
			name : objName,
			update : strUpdate,
			nameFile : nameFile,
			device_hostid: device_hostid
		}
	).fail(function(){
		console.log("UpdateObject fail");
	}).always(function(){
		console.log("UpdateObject successfully");
	});
}

// Function send special state
function SendSpecialState(status, objId, device_hostid) {
	console.log("SendSpecialState status: " + status);

	var nameFile = objId;
	console.log("-----nameFile: " + nameFile);

	$.post(
		"function/data.php",
		{
			type : "status",
			state : status,
			nameFile : nameFile,
			device_hostid : device_hostid
		}	
	).fail(function(){
		console.log("SendSpecialState fail");
	}).always(function(){
		console.log("SendSpecialState always");
	});
}

// button submit
$(".class-ra_cau_dao input").on("click", function(){
	var OBJECT = $(this);
	var value = OBJECT.val();
	var device_hostid = $(this).parents(".parent-item").first().data("device_hostid");

	// var status = $(OBJECT).find("input[name='state']").val();
	$.post(
		"function/data.php",
		{
			type : "dien",
			value : value,
			objid : "ra_cau_dao",
			device_hostid : device_hostid
		}	
	).fail(function(){
		console.log(".class-ra_cau_dao input set to fail");
	}).always(function(){
		console.log(".class-ra_cau_dao input set to ok");
	});
});


$(".class-ra_1 input").on("click", function(){
	var OBJECT = $(this);
	var value = OBJECT.val();
	var device_hostid = $(this).parents(".parent-item").first().data("device_hostid");

	// var status = $(OBJECT).find("input[name='state']").val();
	$.post(
		"function/data.php",
		{
			type : "ra_1_tudong_dieuhoa_quat",
			value : value,
			objid : "ra_1",
			device_hostid : device_hostid
		}	
	).fail(function(){
		console.log(".class-ra_1 input set to fail");
	}).always(function(){
		console.log(".class-ra_1 input set to ok");
	});
});

// function alert
function AlertBox(message) {
	$(".log-box").addClass("log-show");
	$(".log-box .log-text").html(message);
	setTimeout(function(){
		$(".log-box").removeClass('log-show');
	}, 5000);
}

$("#export").click(function(){
	$("#export_table").tableToCSV();
});

setRingSound();

$(".fa-volume").on("click", function(){
	var OBJECT = $(this);
	var id = OBJECT.attr("objid");
	var check_volumn_on = $(this).hasClass("obj-vao-volumn-on");
	var device_hostid = $(this).parents(".parent-item").first().data("device_hostid");
	
	if(OBJECT.hasClass("fa-volume-up")){
		OBJECT.removeClass("fa-volume-up").addClass("fa-volume-off");
		// Stop
		if(check_volumn_on){
			ion.sound.stop(id);
		}
		// Update DB
		pushMute('1', 'obj-vao', id, device_hostid);
	}else{
		OBJECT.removeClass("fa-volume-off").addClass("fa-volume-up");
		// Play
		if(check_volumn_on){
			ion.sound.play(id);
		}
		// Update DB
		pushMute('0', 'obj-vao', id, device_hostid);
	}
});

// reload page
var objMetaRefresh = $(document).find('meta[refreshpage="true"]').first();
if(objMetaRefresh != null && objMetaRefresh != undefined){
	var time_refresh = parseInt(objMetaRefresh.attr('content'));
	
	setInterval(function(){
		if(!notReload){
			$(".obj-button-up-down-icon").unbind("click");
			location.reload();
		}
	}, time_refresh * 1000);
}

// Check maxtime to reset
setInterval(function(){
	// console.log("notReload: " + notReload);
	// console.log("countTime: " + countTime);

	if(notReload){
		countTime ++;
		if(countTime == maxTime){
			// Update to 0
			lastDownItem.trigger("off");
		}
	} else {
		countTime = 0;
	}

}, 1000);

// range --------------------------------------------------------------
// var slider = document.getElementById("deMayNo");
// var output = document.getElementById("obj-de-may-no-input");

// output.innerHTML = slider.value; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
var countRangeChange = 0;
// slider.oninput = function() {
$(".slider-change-range-max-min").change(function() {
	
	var output = document.getElementById($(this).attr("textViewId"));
	notReload = true;
	output.value = this.value;
	var id = $(this).attr("deviceId");
	var device_hostid = $(this).parents(".parent-item").first().data("device_hostid");

	console.log("Device id: " + id)
	countRangeChange++;

	$.post(
		"function/data.php",
		{
			type : "range_change",
			value : this.value,
			id : id,
			device_hostid : device_hostid
		}	
	).fail(function(){
		console.log("Range DE MAY NO failed");
	}).always(function(){
		countRangeChange--;
		if(countRangeChange == 0){
			notReload = false;
		}
		console.log("Range DE MAY NO always");
	});
});
// -------------------------------------------------

});

function pushMute(value, objtype, objid, device_hostid){
	$.post(
		"function/data.php",
		{
			type : "mute",
			value : value,
			objtype : "obj-vao",
			objid : objid,
			device_hostid : device_hostid
		}	
	).fail(function(){
		console.log("Set mute failed");
	}).always(function(){
		console.log("Set mute always");
	});
}


function setRingSound(){
	var sounds = [];
	$(document).find("div.obj-vao").each(function(index){
		// console.log($(this).attr("id"));
		
		var id = $(this).attr("id");
		var mute = $(this).attr("mute");
		var device_hostid = $(this).parents(".parent-item").first().data("device_hostid");

		var check_on = $(this).hasClass("obj-vao-on");
		var cssClass = "fa-volume-off";
		var cssClass_on_off = "obj-vao-volumn-off";

		sounds.push({
			alias: id,
			name: "bell_ring"
		});
		if(mute == '0'){
			cssClass = "fa-volume-up";
		}

		if(check_on){
			cssClass_on_off = "obj-vao-volumn-on";
		}

		$(this).find(".clearfix").first().append('<i class="fa fa-volume ' + cssClass + " " + cssClass_on_off + '" id="volum-' + id + '" objid="' + id + '"></i>');
	});

	ion.sound({
		sounds: sounds,
		volume: 1,
		path: "js/ion.sound-3.0.7/sounds/",
		preload: true,
		loop: true,
		multiplay: true
	});

	// Simple
	$(document).find("div.obj-vao").each(function(index){
		var id = $(this).attr("id");
		var mute = $(this).attr("mute");
		var check_on = $(this).hasClass("obj-vao-on");

		if(mute == '0' && check_on){
			ion.sound.play(id);
		}

	});

}