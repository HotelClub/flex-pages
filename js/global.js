var defaultValueComments = 'Your Answer';
var defaultValueName = 'Your name';
var defaultValueEmail = 'Your email address';
function addClassInput(inputNameVal){
var defaultValueComments = 'Your Answer';
var defaultValueName = 'Your name';
var defaultValueEmail = 'Your email address';
var msg = '';
document.getElementById("placeHolderSuccess").innerHTML = '';
if(inputNameVal=='your-name'){ msg = 'Your name is required'; }
else if(inputNameVal=='your-email'){ msg = 'Your email address is required'; }
else if(inputNameVal=='your-comments'){ msg = 'Your answer is required'; }
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
document.getElementById("placeHolder").innerHTML = 'Your valid email address is required';
document.getElementById("your-email").focus();
return false;
}
}
function removeClassInput(inputNameVal){
document.getElementById("placeHolder").innerHTML = "";
jQuery("#"+inputNameVal).removeClass("error");
}

jQuery(document).ready(function() {

jQuery('#your-comments')
.focus(function () {

this.value = defaultValueComments == this.value ? '' : this.value;
})
.blur(function(){
this.value = '' == this.value ? defaultValueComments : this.value;
});

jQuery('#your-name')
.focus(function () {

this.value = defaultValueName == this.value ? '' : this.value;
})
.blur(function(){
this.value = '' == this.value ? defaultValueName : this.value;
});
jQuery('#your-email')
.focus(function () {

this.value = defaultValueEmail == this.value ? '' : this.value;
})
.blur(function(){
this.value = '' == this.value ? defaultValueEmail : this.value;
});

jQuery("#btn-enter-now").click(function () {
console.log('validating ...');
var name = document.getElementById("your-name").value.trim();
var email = document.getElementById("your-email").value.trim();
var answer = document.getElementById("your-comments").value.trim();

document.getElementById("placeHolderSuccess").innerHTML = '';
if(name=="" || name == defaultValueName){ addClassInput("your-name"); return false;	}else{ removeClassInput("your-name"); }
if(email=="" || email == defaultValueEmail){ addClassInput("your-email");	return false; }else{ removeClassInput("your-email"); }
if(validateEmail(email)==false || email == defaultValueEmail){ return false; }
if(answer=="" || answer == defaultValueComments){ addClassInput("your-comments");  return false; }else{ removeClassInput("your-comments"); }

console.log('validation pass');
jQuery.ajax({
url: "http://qa1.hclubtest.com/n/api/form/storeCompetition/",
type: "POST",
crossDomain: true,
dataType: 'jsonp',
data: jQuery("#sands-competition").serialize(),
success: function (data, textStatus, jqXHR) {
console.log('Success');
console.log(data.message);
document.getElementById("placeHolderSuccess").innerHTML = 'Success! Your entry has been received,<br> thank you.';
},
error: function (jqXHR, textStatus, errorThrown) {
console.log('fail');
}
})
;
});
});