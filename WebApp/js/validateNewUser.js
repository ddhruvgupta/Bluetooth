  
console.log('Validating...');

function checkEmail() {
    try {
        fname = document.getElementById('firstName').value;
        lname = document.getElementById('lastName').value;
        addr = document.getElementById('email').value;
        pw = document.getElementById('pass1').value;
        // console.log("Validating addr="+addr+" pw="+pw);

        if(fname == null || fname == ""){
            alert("First Name Required");
            return false;
        }

        if(lname == null || lname == ""){
            alert("Last Name Required");
            return false;
        }


        if(addr == null || addr == ""){
            alert("Username Required");
            return false;
        }

        if ( pw == null || pw == "") {
            alert("Password Required");
            return false;
        }
        if ( addr.indexOf('@') == -1 ) {
            alert("Invalid email address");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}