	function doInsert(ctl)
		{
			vInit = ctl.value;
			ctl.value = ctl.value.replace(/[^a-f0-9:]/ig, "");
    //ctl.value = ctl.value.replace(/:\s*$/, "");
    vCurrent = ctl.value;
    if(vInit != vCurrent)
    	return false;   

    var v = ctl.value;
    var l = v.length;
    var lMax = 17;

    if(l >= lMax)
    {
    	return false;
    }

    if(l >= 2 && l < lMax)
    {
    	var v1 = v;     
    	/* Removing all ':' to calculate get actaul text */
        while(!(v1.indexOf(":") < 0)) { // Better use RegEx
        	v1 = v1.replace(":", "");           console.log('v1:'+v1);
        }

        /* Insert ':' after ever 2 chars */     
        var arrv1 = v1.match(/.{1,2}/g); // ["ab", "dc","a"]        
        ctl.value = arrv1.join(":");
    }
}