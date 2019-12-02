function load() {
	
		

}

	function login(){
		var request = "login"
		var email = document.getElementById("email").value;
		var pwd = document.getElementById("pwd").value;
		var xhttp = new XMLHttpRequest();
		var url = "bugme.php";
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState === xhttp.DONE) {
 				if (xhttp.status === 200) {
 					var response = xhttp.responseText;
 					document.getElementById("main").innerHTML=response;

 				} else {
 					alert('There was a problem with the request. \n'+xhttp.status);
 				}
			} 
  		}
  		xhttp.open("GET", url+"?request="+request+"&password="+pwd+"&email="+email ,true);
  		xhttp.send();
	}
	function logout(){
		var request = "logout"
		var xhttp = new XMLHttpRequest();
		var url = "bugme.php";
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState === xhttp.DONE) {
 				if (xhttp.status === 200) {
 					var lresponse = xhttp.responseText;
 					document.getElementById("main").innerHTML=lresponse;
 				} else {
 					alert('There was a problem with the request. \n'+xhttp.status);
 				}
			} 
  		}
  		xhttp.open("GET", url+"?request="+request,true);
  		xhttp.send();
	}
	function addUserform(){
		var request = "adduserform"
		var xhttp = new XMLHttpRequest();
		var url = "bugme.php";
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState === xhttp.DONE) {
 				if (xhttp.status === 200) {
 					var response = xhttp.responseText;
 					document.getElementById("main-c").innerHTML=response;
 				} else {
 					alert('There was a problem with the request. \n'+xhttp.status);
 				}
			} 
  		}
  		xhttp.open("GET", url+"?request="+request,true);
  		xhttp.send();
	}

	function addUser(){
		var firstname =document.getElementById("firstname").value;
		var lastname =document.getElementById("lastname").value;
		var email =document.getElementById("email").value;
		var pwd =document.getElementById("pwd").value;
		var pwdrepeat =document.getElementById("pwd-repeat").value;
		var request = "adduser"
		var xhttp = new XMLHttpRequest();
		var url = "bugme.php";
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState === xhttp.DONE) {
 				if (xhttp.status === 200) {
 					var response = xhttp.responseText;
 					document.getElementById("main").innerHTML=response;
 				} else {
 					alert('There was a problem with the request. \n'+xhttp.status);
 				}
			} 
  		}
  		xhttp.open("GET", url+"?request="+request+"&firstname="+firstname+"&lastname="+lastname+"&email="+email+"&pwd="+pwd+"&pwd-repeat="+pwdrepeat,true);
  		xhttp.send();
	}

	function sIssueform(){
		var request = "sIssueform"
		var xhttp = new XMLHttpRequest();
		var url = "bugme.php";
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState === xhttp.DONE) {
 				if (xhttp.status === 200) {
 					var response = xhttp.responseText;
 					document.getElementById("main-c").innerHTML=response;
 				} else {
 					alert('There was a problem with the request. \n'+xhttp.status);
 				}
			} 
  		}
  		xhttp.open("GET", url+"?request="+request,true);
  		xhttp.send();
	}

	function submitIssue(){
		var title =document.getElementById("title").value;
		var desc =document.getElementById("desc").value;
		var assigned =document.getElementById("assigned").value;
		var type =document.getElementById("type").value;
		var priority =document.getElementById("priority").value;
		var request = "submitIssue"
		var xhttp = new XMLHttpRequest();
		var url = "bugme.php";
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState === xhttp.DONE) {
 				if (xhttp.status === 200) {
 					var response = xhttp.responseText;
 					document.getElementById("main").innerHTML=response;
 				} else {
 					alert('There was a problem with the request. \n'+xhttp.status);
 				}
			} 
  		}
  		xhttp.open("GET", url+"?request="+request+"&title="+title+"&desc="+desc+"&assigned="+assigned+"&type="+type+"&priority="+priority,true);
  		xhttp.send();

	}
	function home(filter){
		var request = "home"
		var xhttp = new XMLHttpRequest();
		var url = "bugme.php";
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState === xhttp.DONE) {
 				if (xhttp.status === 200) {
 					var response = xhttp.responseText;
 					document.getElementById("main").innerHTML=response;
 				} else {
 					alert('There was a problem with the request. \n'+xhttp.status);
 				}
			} 
  		}
  		xhttp.open("GET", url+"?request="+request+"&filter="+filter,true);
  		xhttp.send();
	}

	function viewIssue(id){
		var request = "viewIssue"
		var xhttp = new XMLHttpRequest();
		var url = "bugme.php";
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState === xhttp.DONE) {
 				if (xhttp.status === 200) {
 					var response = xhttp.responseText;
 					document.getElementById("main-c").innerHTML=response;
 				} else {
 					alert('There was a problem with the request. \n'+xhttp.status);
 				}
			} 
  		}
  		xhttp.open("GET", url+"?request="+request+"&id="+id,true);
  		xhttp.send();
	}

	function update_stat(id,updat){
		var request = "update"
		var xhttp = new XMLHttpRequest();
		var url = "bugme.php";
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState === xhttp.DONE) {
 				if (xhttp.status === 200) {
 					var response = xhttp.responseText;
 					document.getElementById("main").innerHTML=response;
 				} else {
 					alert('There was a problem with the request. \n'+xhttp.status);
 				}
			} 
  		}
  		xhttp.open("GET", url+"?request="+request+"&id="+id+"&updat="+updat,true);
  		xhttp.send();

	}


window.onload = function(){
	load()
}