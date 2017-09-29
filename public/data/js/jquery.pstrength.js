$(document).ready(function() {
    var password = $('#password');
    passwordStrengthCheck(password);
});


function passwordStrengthCheck(password){
    var WeakPass = /(?=.{8,}).*/; 
    var MediumPass = /^(?=\S*?[a-z])(?=\S*?[0-9])\S{8,}$/; 
    var StrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])\S{8,}$/; 
    var VryStrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*?[-!"#$%&'()*+,./:;<=>?@[\\\]_`{|}~])\S{8,}$/; 
    var title = 'Força da senha';

    $(password).on('keyup', function(e) {
        if(VryStrongPass.test(password.val())){
          title = 'Muito Forte!';
      }   
      else if(StrongPass.test(password.val())){
        title = 'Forte';
    }   
    else if(MediumPass.test(password.val())){
       title = 'Média';
   }
   else if(WeakPass.test(password.val())){
    title = 'Fraca (Use letras)';
}
else{
 title = 'Min. 8 caracteres';
}

$('.password-strength').attr('title', title);
});


}

function addBarra(){

    var $wrapper = document.querySelector('.center'),
    antigo = $wrapper.firstChild.nodeName;
    HTMLNovo = "<span title='Min. 8 caracteres' class='password-strength' id='test'></span>";
    if(antigo!='SPAN'){
        $wrapper.insertAdjacentHTML('afterbegin',HTMLNovo);
    }
}

function checkPassword(input) {

    if(document.getElementById('test').title!=='Média' && document.getElementById('test').title!=='Forte' && document.getElementById('test').title!=='Muito Forte!'){
      document.getElementById('password').setCustomValidity('A senha deve ser no mínimo de força média.');
  } else {
     document.getElementById('password').setCustomValidity('');
 }
 if (input.value != document.getElementById('password').value) {
    input.setCustomValidity('As senhas não são iguais.');
} else {
    input.setCustomValidity('');
}

}


