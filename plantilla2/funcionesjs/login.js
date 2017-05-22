$(document).on("ready",main);

function main(){
	 $("#msg-error3").hide();
	$("#milogin").submit(function(event){
		event.preventDefault();
		$.ajax({
			url:$(this).attr("action"),
			type:$(this).attr("method"),
			data:$(this).serialize(),
			success:function(resp){
				if(resp==="error"){
					$("#username").val("");
					$("#password").val("");
					$("#username").focus();
					$("#msg-error3").show();
				}
				else{
					window.location.href = "http://localhost/hospital/welcome";
				}
			}
		});
	});



}