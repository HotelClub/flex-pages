function addClassInput(inputNameVal){
	var msg = '';
	document.getElementById("placeHolderSuccess").innerHTML = '';
	if(inputNameVal=='your-name'){ msg = '* Please enter your name'; }
	else if(inputNameVal=='your-email'){ msg = '* Please enter your email'; }
	else if(inputNameVal=='your-comments'){ msg = '* Please enter your comments'; }
	document.getElementById(inputNameVal).focus();
	document.getElementById(inputNameVal).className = document.getElementById(inputNameVal).className + "error";
	document.getElementById("placeHolder").innerHTML = msg;
}

function validateEmail(emailVal) {
	var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if (filter.test(emailVal)) {
		return true;			
	}
	else { 
		document.getElementById('your-email').className = document.getElementById('your-email').className + "error";
		document.getElementById("placeHolder").innerHTML = '* Please enter the valid email';
		document.getElementById("your-comments").focus();
		return false; 
	}
}
function removeClassInput(inputNameVal){
	document.getElementById("placeHolder").innerHTML = "";
	jQuery("#"+inputNameVal).removeClass("error");
}

/** form is submitted when you click on image **/
jQuery(document).ready(function() {
	jQuery("#btn-enter-now").click(function () {
		console.log('enter now clicked');
		/*var name = jQuery("#first_name").val();
		var email = jQuery("#email").val();
		var answer = jQuery("#comments").val();*/
		var name = document.getElementById("your-name").value.trim();
		var email = document.getElementById("your-email").value.trim();
		var answer = document.getElementById("your-comments").value.trim();
		
		if(name==""){ addClassInput("your-name"); return false;	}else{ removeClassInput("your-name"); }		
		if(email==""){ addClassInput("your-email");	return false; }else{ removeClassInput("your-email"); }
		if(validateEmail(email)==false){ return false; }
		if(answer==""){ addClassInput("your-comments");  return false; }else{ removeClassInput("your-comments"); }	
		

		jQuery.ajax({
			url: "http://hotelclub.nextgen-api.com/n/api/Form/store",
			type: "POST",
			 crossDomain: true,
			dataType: 'json',
			data: jQuery("#sands-competition").serialize(),
			beforeSend: function (request){
			request.setRequestHeader("Authorization", "9c845aebd0c2d4a5532e7cced7aaa1d5");
			request.setRequestHeader("X-Requested-With", "XMLHttpRequest");    },
			success: function (data, textStatus, jqXHR) {
				//data: return data from server				
				console.log('Success');
				console.log(data.message);
				//document.getElementById('placeHolderSuccess').className = document.getElementById(inputNameVal).className + "error";
				document.getElementById("placeHolderSuccess").innerHTML = 'Data successfully submitted';				
			},
			error: function (jqXHR, textStatus, errorThrown) {
				//if fails
				console.log('fail');

			}
		})
		;
		/*
		 jQuery("#sands-competition").submit(function(e)
		 {
		 console.log ( 'init form' );
		 var postData = jQuery(this).serializeArray();
		 var formURL = 'http://hotelclub.nextgen-api.com/n/api/Form/store';
		 jQuery.ajax(
		 {
		 url : formURL,
		 type: "POST",
		 data : postData,
		 success:function(data, textStatus, jqXHR)
		 {
		 alert('success');
		 //data: return data from server
		 },
		 error: function(jqXHR, textStatus, errorThrown)
		 {
		 alert('fail');
		 //if fails
		 }
		 });
		 console.log('setup ajax');
		 e.preventDefault(); //STOP default action
		 //                e.unbind(); //unbind. to stop multiple form submit.
		 });

		 jQuery("#sands-competition").submit(); //Submit  the FORM
		 */
	});
});
//form loads when pages