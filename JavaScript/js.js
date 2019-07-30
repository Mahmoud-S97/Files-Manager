





$(function(){

var flag = true;
console.log('Hello');
$('#select-all').click(function(){

	$('input').prop('checked',flag);
	if(flag == true)
		flag = false;
		else
		flag = true;
});
});



