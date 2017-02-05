/**
 * Created by luckie on 25.01.17.
 */
$(document).ready(function () {
    // check for cookies
    var hbbk_login = $('.hbbk-login');
    var class_selector = $('.class-selector');

    if (getCookie('username') != "" && getCookie('password') != ""){
        console.log("Cookies Set");
        if (checkLogin(getCookie('username'), getCookie('password'))){
            console.log("Login Valid");
            //dont display login form
            hbbk_login.hide();
            //display the class selector
            class_selector.show();
        }
        else
            console.warn('Login Invalid')
            hbbk_login.show();
            class_selector.hide();
    }
    else {
        console.log("Cookies not Set");
        hbbk_login.show();

        $('#login-submit').click(
            function () {
                // get login data
                var $username = $('#username').val();
                var $password = $('#pwd').val();
                var saveLoginData = $('#save-login-data').is(':checked');

                if (saveLoginData) {
                    //set cookies
                    setCookie('username', $username, 120);
                    setCookie('password', $password, 120);
                    console.log("Cookies now Set");
                }

                //check login
                if (checkLogin($username, $password)){
                    console.log("Login Valid");
                    //dont display login form
                    hbbk_login.hide();
                    //display the class selector
                    class_selector.show();
                }
                else
                    console.warn('Login Invalid');

            }
        )
    }
}
);

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkLogin(username, password) {
    $.post("../../v1/Authenticate.php",
        {
            username: username,
            password: password
        },
        function(data){
            if (data == "true") return true;
            if (data == "false") return false;
            else return false;
        });
}