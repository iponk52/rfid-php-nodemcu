$(document).ready(function() {
    selesai();
});
 
function selesai() {
	setTimeout(function() {
		update();
		selesai();
	}, 200);
}
 
function update() {
	$.getJSON("data.php", function(data) {
		$("table").empty();
		var no = 1;
		$.each(data.result, function() {
			$("table").append("<tr><td>"+(no++)+"</td><td>"+this['data_uid']+"</td><td>"+this['nama']+"</td><td>"+this['email']+"</td><td>"+this['saldo']+"</td><td>"+this['daftar']+"</td><td>"+this['uid']+"</td></tr>");
		});
	});
}
<a href='edit.php?id=$user_data[id]'>Edit</a> | <a href='delete.php?id=$user_data[id]'>Delete</a>