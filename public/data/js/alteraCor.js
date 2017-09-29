function alteraCor(){
	var x = $("#side0").css("background-color");
	if (x=="rgb(255, 255, 255)"){
		$("#perfilbutton").css({'background-color':x,'border-color':x,'color':'black'});
		$("#logoutbutton").css({'background-color':x,'border-color':x,'color':'black'});
	} else {
		$("#perfilbutton").css({'background-color':x,'border-color':x,'color':'white'});
	$("#logoutbutton").css({'background-color':x,'border-color':x,'color':'white'});
	}
	

}