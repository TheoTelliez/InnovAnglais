$(document).ready(function() {

    let themeduTest = document.getElementById("passer_un_test_theme");
    let btTheme = document.getElementById("passer_un_test_lancer");
    let divTheme = document.getElementById("divTestG");

    btTheme.addEventListener("click", function () {
        if (themeduTest.value != 0) {
            divTheme.style.display = "none";
            themeduTest.style.display = "none";
            btTheme.style.display = "none";
            console.log(themeduTest.value);
            alert("Le thème choisi est le thème " + themeduTest.value)
            alert("Erreur dans le code, impossible de finir un test totalement car nous avons un soucis d'API.")
            unTest()
        }
    }, false);


    function unTest(){
        var request= $.ajax({
            // url: "http://serveur1.arras-sio.com/symfony4-4059/InnovAnglais/public/api/themes/" + themeduTest.value,
            url: "http://serveur1.arras-sio.com/symfony4-4059/InnovAnglais/public/api/themes?page=2",
            method:"GET",
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "application/json; charset=utf-8" );
            }});
        request.done(function( msg ) {

            $.each(msg, function(index,e){
                alert (e.id);
            });
        });
        // Fonction qui se lance lorsque l’accès au web service provoque une erreur
        request.fail(function( jqXHR, textStatus ) {
            alert ('Erreur');
        });
    }

})

