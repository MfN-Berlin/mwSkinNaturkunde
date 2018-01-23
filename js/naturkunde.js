/* Das folgende JavaScript wird für alle Benutzer geladen. */
/* Remove edit button if edit-with-form button is present */
if ( document.getElementById( "ca-form_edit" ) ) {
    document.getElementById( "ca-ve-edit" ).style.display = "none";
    document.getElementById( "ca-edit" ).style.display = "none";
}

/*Edit title from FORM pages*/
if( window.location.href.indexOf("formedit") != -1 || window.location.href.indexOf("Mit_Formular_bearbeiten" != -1 ) ) {
    var otext = document.getElementById("firstHeading").innerHTML
    if(otext.indexOf(":") != -1) {
        ntext = otext.split(":")
        ntext.shift()
        ntext = ntext.join(":")
//        document.getElementById("firstHeading").innerHTML=ntext;
    }
}
