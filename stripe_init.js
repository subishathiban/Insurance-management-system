var txt;
var xmlhttp;
var loader = "<div class='d-flex justify-content-center'><div class='spinner-border' style='height:16px; width:16px; margin-top:4px;'  role='status'><span class='sr-only'></span></div>&nbsp;Processing Payment</div>";

if (window.XMLHttpRequest)
{
xmlhttp=new XMLHttpRequest();
}
else
{
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
{
var stripe_pk = xmlhttp.responseText;
var stripe = Stripe(stripe_pk);
var elements = stripe.elements();

var style = {
base: {
color: '#343a40',
fontSize: '15px',
fontWeight:'bold',
fontFamily: 'segoe ui',
fontSmoothing: 'antialiased',
'::placeholder': {
color: '#343a40',
},
},
invalid: {
color: 'black',
':focus': {
color: 'black',
},
},
};


var card = elements.create('card', {style: style});

card.mount('#card-element');

var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
event.preventDefault();

var current_effect = 'bounce';
run_waitMe(current_effect);
function run_waitMe(effect){
$('#payment-form').waitMe({

effect: '',
text: '',

bg: 'rgba(255,255,255,0)',

color: '',

maxSize: '',

waitTime: -1,
source: '',

textPos: 'vertical',

fontSize: '',
onClose: function() {}

});
}
document.getElementById('sub_btn').innerHTML = loader

stripe.createToken(card).then(function(result) {
if (result.error) {
$('#payment-form').waitMe('hide');
document.getElementById('sub_btn').innerHTML = '<i class="fa fa-fw fa-check opacity-50 me-1"></i> Complete Order';
var errorElement = document.getElementById('card-errors');
errorElement.textContent = result.error.message;
} else {

stripeTokenHandler(result.token);
}
});
});

function stripeTokenHandler(token) {

var form = document.getElementById('payment-form');
var hiddenInput = document.createElement('input');
hiddenInput.setAttribute('type', 'hidden');
hiddenInput.setAttribute('name', 'stripeToken');
hiddenInput.setAttribute('value', token.id);
form.appendChild(hiddenInput);

form.submit();
}
}
}
xmlhttp.open("GET","const/co2.php", true);
xmlhttp.send();
