function ajax1() {

	var xhr = new XMLHttpRequest();

	var u = document.getElementById("username").value;
	var p = document.getElementById("password").value;
	
	
	var isAlphanumeric = /^[A-Za-z0-9]+$/; 
	
	if ((isAlphanumeric.test(u)==true)&&(u.length>=4)&&(isAlphanumeric.test(p)==true)&&(p.length>=8)) {	
		document.getElementById("message").innerHTML = "<p class='wait'>Logging in, please wait ...</p>";		
		xhr.open("POST", 'check-user.php', true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");	
		var data = "username="+u+"&password="+p;		
		xhr.send(data);	
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				document.getElementById("message").innerHTML = xhr.responseText;
			}
			else if (xhr.readyState == 4 && xhr.status == 202) {
                            console.log("202: ", xhr);
                            var response = JSON.parse(xhr.responseText);
                            localStorage.setItem("userId", response["userId"]);
                            localStorage.setItem("sessionToken", response["sessionToken"]);
                            window.location = "main.php";
                           
			}
		}
	}
}
