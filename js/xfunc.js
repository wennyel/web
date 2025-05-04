function loading(vari)
{
  document.getElementById(vari).innerHTML="<div class='loading'>PLEASE WAIT WHILE THE SYSTEM IS LOADING</div>";
}
function disableSelection(target) {
if (typeof target.onselectstart!="undefined") //IE route
	target.onselectstart=function(){return false}
else if (typeof target.style.MozUserSelect!="undefined") //Firefox route
	target.style.MozUserSelect="none"
else //All other route (ie: Opera)
	target.onmousedown=function(){return false}
target.style.cursor = "default"
}
function categorias(id, tipo) {
	if(tipo=="mais"){
		document.getElementById("prod-"+id).style.display = 'block';
		document.getElementById("mais-"+id).style.display = 'none';
		document.getElementById("menos-"+id).style.display = 'block';
	}else
	if(tipo=="menos"){
		document.getElementById("prod-"+id).style.display = 'none';
		document.getElementById("mais-"+id).style.display = 'block';
		document.getElementById("menos-"+id).style.display = 'none';
	}
}
