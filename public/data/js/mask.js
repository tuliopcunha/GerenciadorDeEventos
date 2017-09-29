
function verify($div,$target){
    var inputs = $('.form-control', $($div));
    var flag = true;  
    for(i = 0; i < inputs.length; i++) {
      if (!inputs[i].checkValidity()) {
        flag = false;
      } 
    }
    if (flag==true) {
      $($target).click()
    } else {
      $('#submit').click()
    }
  }
function mascara(o,f){
  v_obj=o
  v_fun=f
execmascara();
}

function execmascara(){
  v_obj.value=v_fun(v_obj.value)
}

function id( el ){
  return document.getElementById( el );
}

function mtel(v){

  v=v.replace(/\D/g,"");             
  v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); 
  v=v.replace(/(\d)(\d{4})$/,"$1-$2");   
  return v;
}

function mcpf(v){  

  v=v.replace(/\D/g,"")                    
  v=v.replace(/(\d{3})(\d)/,"$1.$2")       
  v=v.replace(/(\d{3})(\d)/,"$1.$2")       
  v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") 
  return v;
}


function mcep(v){  

  v=v.replace(/\D/g,"")                      
  v=v.replace(/^(\d{5})(\d)/,"$1-$2")        
  return v;
}

function mdata(v){  

  v=v.replace(/\D/g,"");                    
  v=v.replace(/(\d{2})(\d)/,"$1/$2");
  v=v.replace(/(\d{2})(\d)/,"$1/$2");
  return v;
}

function mvalor(v){  

  v=v.replace(/\D/g,"");
  v=v.replace(/(\d)(\d{8})$/,"$1.$2");
  v=v.replace(/(\d)(\d{5})$/,"$1.$2");
  v=v.replace(/(\d)(\d{2})$/,"$1,$2");
  return v;
}


window.onload = function(){ 

  id('cep').onkeyup = function(){
    mascara( this, mcep );
  }
  id('cpf').onkeyup = function(){ 
    mascara( this, mcpf );
  }

  id('telefone1').onkeyup = function(){ 
    mascara( this, mtel );
  }
    id('telefone2').onkeyup = function(){ 
    mascara( this, mtel );
  }

  id('cep').onkeyup = function(){
    mascara( this, mcep );
  }

}