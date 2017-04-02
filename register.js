$(document).ready(function(){

	$("#registration-form").on("submit", function(e){

		e.preventDefault();

		var userEmail 		= $("#userEmail").val();
		var userPassword 	= $("#userPassword").val();
		var userName 		= $("#userName").val();
		var userPhone		= $("#userPhone").val();
		var userQQ 			= $("#userQQ").val();
		var userWeChat 		= $("#userWeChat").val();
		var userReferred 	= $("#userReferred").val();

		var userData = "userEmail=" + userEmail + "&userPassword=" + userPassword + "&userName=" + userName + "&userPhone=" 
		+ userPhone + "&userQQ=" + userQQ + "&userWeChat=" + userWeChat + "&userReferred=" + userReferred;

		alert(userData);

		$.ajax({
			method: "post",
			url: "register.php?",
			data: userData,
			success: function(backData){
				$("#registerOutput").html(backData);
			}
		});
	});
});