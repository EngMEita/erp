$(function() {
	$("#lpvb").click(function(){
		$('input[id^="cpvb_"]').each(function(index) {
			var v  = $(this).val();
            var tid = $(this).attr('id');
			var nid = tid.replace("cpvb","rpvb");
			$("#"+nid).val(v);
        });
		alert("تم التحميل بنجاح يرجى الحفظ");
	});
});

$(function() {
    $('#side-menu').metisMenu();
});

function confDelete(url){
	var c = confirm('هل أنت متأكد من إجراء العملية؟!');
	if(c){
		urlOpenner(url);
	}
}

function openURL(id, base){
	var ele = document.getElementById(id);
	var url = ele.options[ele.selectedIndex].value;
	urlOpenner(base + '' + url);
}

function urlOpenner(url){
	window.location = url;
}

$(document).ready( function () {
	$('#DTable').DataTable({
		"language": {
			"url": "http://cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Arabic.json"
		},
		stateSave: false
	});
	
	$('select.change').on('change', function(){
		window.location = $(this).val();
	});
} );

$(document).ready(function() {
	var arr = $('.rte').rte({
		css: ['default.css'],
		controls_rte: rte_toolbar,
		controls_html: html_toolbar
	});
});


//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });
});

/////////////////////////////////////////////////////

var counter;
function nowTime(){
	var today = new Date();
	var h = today.getHours();
	/*if(h > 12){
		h -= 12;
		var t = "م";
	}else{
		var t = "ص";	
	}*/
	var m = today.getMinutes();
	//var s = today.getSeconds();
	var hh = checkTime(h);
	var mm = checkTime(m);
	//var ss = checkTime(s);
	var time =  hh + ":" + mm;
	//alert(time);
	document.getElementById("time_now").innerHTML = '&nbsp;'+time+'&nbsp;';
}

function startTime() {
	 counter = setInterval(nowTime, 500);
}

function checkTime(i) {
	if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
	return i;
}

startTime();

function changeDept(rid, sid, id){
	var c = confirm("هل أنت متأكد من أنك تريد نقل الموظف من قسمه الحالي؟!");
	if(c){
		var did = document.getElementById(id).options[document.getElementById(id).selectedIndex].value;
		window.location = 'index.php?c=acp-deptstaff&act=changedept&rid=' + rid + '&staff_id=' + sid + '&change_id=' + did;
	}
}