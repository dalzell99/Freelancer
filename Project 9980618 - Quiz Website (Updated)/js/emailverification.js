window.onload=function(){global(),$("li.active").removeClass("active");var e=getUrlVars().email,t=getUrlVars().code;$.post("./php/users/setemailconfirmed.php",{email:e,emailCode:t},function(e){"success"==e?$("#confirmed").show():"incorrect"==e?$("#notConfirmed").show():displayMessage("error","Error","Error setting your email as verified. Please contact the web admin.")}).fail(function(){})};
