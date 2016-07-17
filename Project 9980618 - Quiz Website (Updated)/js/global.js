function global(){if(toastr.options={closeButton:!1,debug:!1,newestOnTop:!0,progressBar:!1,positionClass:"toast-top-right",preventDuplicates:!0,onclick:null,showDuration:"300",hideDuration:"1000",timeOut:"0",extendedTimeOut:"0",showEasing:"swing",hideEasing:"linear",showMethod:"fadeIn",hideMethod:"fadeOut"},null===sessionStorage.loggedIn&&"false"===sessionStorage.loggedIn)sessionStorage.loggedIn="false",$("#loginNotLoggedIn").show();else if("true"==sessionStorage.loggedIn){if($("#accountInfoUsername").text(sessionStorage.username),$("#accountInfoFreeConvertablePoints").text(sessionStorage.freeConvertablePointsBalance),$("#accountInfoFreeUnconvertablePoints").text(sessionStorage.freeUnconvertablePointsBalance),$("#accountInfoPaidPoints").text(sessionStorage.paidPointsBalance),$("#loginNotLoggedIn").hide(),$("#signupLoggedIn").hide(),$("#loginLoggedIn").show(),$("#myAccountMenuItem").show(),$("#myAccountMenuItemMe").show(),setInterval(updatePoints,3e4),inactivityTimer=setTimeout(logout,inactivityTimeout),$(window).on({mousemove:function(){clearTimeout(inactivityTimer),inactivityTimer=setTimeout(logout,inactivityTimeout)},keypress:function(){clearTimeout(inactivityTimer),inactivityTimer=setTimeout(logout,inactivityTimeout)},mousedown:function(){clearTimeout(inactivityTimer),inactivityTimer=setTimeout(logout,inactivityTimeout)},click:function(){clearTimeout(inactivityTimer),inactivityTimer=setTimeout(logout,inactivityTimeout)},scroll:function(){clearTimeout(inactivityTimer),inactivityTimer=setTimeout(logout,inactivityTimeout)}}),void 0!=localStorage.quizResults&&"undefined"!=localStorage.quizResults){var e=JSON.parse(localStorage.quizResults);moment().diff(e.currentTime,"seconds")<60&&moment().diff(e.quizEndTime)<0?($.post("./php/quizresults/uploadquizresult.php",{quizID:e.quizID,userID:e.userID,username:e.username,timeTaken:e.timeTaken,questions:e.questions,correctPercent:e.correctPercent},function(e){"success"==e?displayMessage("info","Quiz Results Uploaded","Your quiz results were uploaded."):displayMessage("error","Error","Error uploading your results. Contact the web admin for details on what to do.")}).fail(function(){}),"free"==e.quizType&&$.post("./php/users/depositfreepoints.php",{userID:e.userID,correctPercent:e.correctPercent},function(e){if("success"==e){if(100==correctPercent)var t=5;else if(correctPercent>=90)var t=4;else if(correctPercent>=80)var t=3;else var t=0;displayMessage("info","Quiz Result","You got "+correctAnswers+" out of "+numQuestions+" correct. "+t+" bonus quizetos have been added to your account.")}else displayMessage("error","Error","Error depositing your bonus quizetos in your account. You got "+correctAnswers+" out of "+numQuestions+" correct.")}).fail(function(){})):alert("Sorry but has been more than 1 minute or the quiz has ended since you were disconnected"),localStorage.removeItem("quizResults")}}else $("#loginNotLoggedIn").show(),$("#loginLoggedIn").hide()}function login(){var e=$("#loginUsername").val(),t=$("#loginPassword").val();$.post("./php/users/login.php",{username:e,password:t},function(e){"correct"==e[0]?(sessionStorage.userID=e[1].userID,sessionStorage.username=e[1].username,sessionStorage.paidPointsBalance=e[1].paidPointsBalance,sessionStorage.freeConvertablePointsBalance=e[1].freeConvertablePointsBalance,sessionStorage.freeUnconvertablePointsBalance=e[1].freeUnconvertablePointsBalance,sessionStorage.email=e[1].email,sessionStorage.emailVerified=e[1].emailConfirmed,sessionStorage.notifications=e[1].notificationsArray,sessionStorage.notificationsViewed=e[1].timeNotificationsViewed,sessionStorage.numQuizzesTakenRemaining=e[1].numQuizzesTakenRemaining,sessionStorage.loggedIn="true",location.reload()):"incorrect"==e[0]?displayMessage("warning","","Incorrect password"):"usernamedoesntexist"==e[0]?displayMessage("warning","","An account with that username doesn't exist. Please create an account or user a different username"):displayMessage("error","Error","Error: "+e[1])},"json").fail(function(){})}function logout(){sessionStorage.loggedIn="false",sessionStorage.username="",sessionStorage.paidPointsBalance="",sessionStorage.freePointsBalance="",sessionStorage.email="",sessionStorage.notifications="",sessionStorage.notificationsViewed="",window.location="index.php"}function createNewUser(){var e=areInputsValidSignUp();if(e[0]){var t=$("#userRegisterUsername").val(),s=$("#userRegisterPassword").val(),i=$("#userRegisterEmail").val(),o=$("#userRegisterPhone").intlTelInput("getNumber"),a=createEmailCode();$.post("./php/users/createnewuser.php",{username:t,password:s,email:i,mobile:o,emailCode:a},function(e){"success"==e?window.location="successfulregistration.php":"exists"==e?displayMessage("warning","","Username already exists or email address is attached to another account"):displayMessage("error","Error","Error: "+e)}).fail(function(){})}else displayMessage("warning","",e[1])}function areInputsValidSignUp(){return $("#userRegisterTerms").prop("checked")?0==$("#userRegisterEmail").val().length?[!1,"You need to enter an email address"]:0==$("#userRegisterUsername").val().length?[!1,"You need to enter a username"]:0==$("#userRegisterPhone").val().length?[!1,"You need to enter a phone number"]:-1==$("#userRegisterEmail").val().indexOf("@")||-1==$("#userRegisterEmail").val().lastIndexOf(".")||$("#userRegisterEmail").val().lastIndexOf(".")<$("#userRegisterEmail").val().indexOf("@")?[!1,"Your email address needs to include an @ and a . in it"]:isMobileNumberValid?isEmailAddressValid?isUsernameValid?[!0]:[!1,"The username you entered is already being used"]:[!1,"The email address you entered is already being used"]:[!1,"The mobile number you entered is invalid"]:[!1,"You must agree to the terms of use before proceeding."]}function createEmailCode(){for(var e="",t="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",s=0;10>s;s+=1)e+=t.charAt(Math.floor(Math.random()*t.length));return e}function displayMessage(e,t,s){var i="";i+="<div>"+t+"</div>",i+="<div>"+s+"</div>",i+="<div><button type='button' class='btn clear'>Ok</button></div>",toastr[e](i)}function getUrlVars(){var e={};window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(t,s,i){e[s]=i});return e}function pad(e,t){for(e=""+e;e.length<t;)e="0"+e;return e}function updatePoints(){null!=sessionStorage.username&&$.post("./php/users/getpoints.php",{username:sessionStorage.username},function(e){"success"==e[0]?(sessionStorage.paidPointsBalance=e[1].paidPointsBalance,sessionStorage.freeConvertablePointsBalance=e[1].freeConvertablePointsBalance,sessionStorage.freeUnconvertablePointsBalance=e[1].freeUnconvertablePointsBalance,$("#accountInfoFreeConvertablePoints").text(e[1].freeConvertablePointsBalance),$("#accountInfoFreeUnconvertablePoints").text(e[1].freeUnconvertablePointsBalance),$("#accountInfoPaidPoints").text(e[1].paidPointsBalance)):displayMessage("error","Error","Error: "+e[1])},"json").fail(function(){})}function showBuyPoints(){sessionStorage.buypoints="true",window.location="myaccount.php"}function getCountdownString(e,t){var s=60,i=3600,o=86400,a="";if(e>0){var n=Math.floor(e/o),r=Math.floor((e-n*o)/i),u=Math.floor((e-(r*i+n*o))/s),d=Math.floor(e-(r*i+n*o+u*s));a+="Starts in ",n>0&&(a+=n+(1==n?" day ":" days ")),a+=r+":"+pad(u,2)+":"+pad(d,2)}else if(t>0){var n=Math.floor(t/o),r=Math.floor((t-n*o)/i),u=Math.floor((t-(r*i+n*o))/s),d=Math.floor(t-(r*i+n*o+u*s));a+="Ends in ",n>0&&(a+=n+(1==n?" day ":" days ")),a+=r+":"+pad(u,2)+":"+pad(d,2)}else a="Ended";return a}function isInt(e){return!isNaN(e)&&parseInt(Number(e))==e&&!isNaN(parseInt(e,10))}function get12HourTimeString(e){return e>12?e-12+"pm":(0===e?12:e)+"am"}var place=["st","nd","rd","th"],red="2px #ff4c4c solid",green="2px #3eb73e solid",isMobileNumberValid=!1,isUsernameValid=!1,isEmailAddressValid=!1,inactivityTimer,inactivityTimeout=3e5;window.onload=global;
