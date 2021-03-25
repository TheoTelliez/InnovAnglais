$(document).ready(function () {

    let tableauMotsFR = [];
    let tableauMotsEN = [];
    let nbMots = 0;
    let cptMots = 0;
    let btTest = document.getElementsByClassName("passerletest");
    $("#traduireMot").hide();
    $("#tableauResults").hide();
    let reponses = [];
    let indiceCourant = 0;
    let mesReponses = [];

    for (var i = 0; i < btTest.length; i++) {

        btTest[i].addEventListener("click", function () {

            idTest = $(this).attr('data-id');
            unTest(idTest);


        }, false);
    }

    function unTest(idTest) {
        var request = $.ajax({
            url: "http://serveur1.arras-sio.com/symfony4-4059/InnovAnglais/public/api/tests/" + idTest,
            method: "GET",
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.overrideMimeType("application/json; charset=utf-8");
            }
        });

        request.done(function (msg) {
            lienDuTheme = msg.theme;
            unTheme(lienDuTheme);
        });

        request.fail(function (jqXHR, textStatus) {
            console.log('Erreur');
        });
    }

    function unTheme(lienDuTheme) {
        var request = $.ajax({
            url: "http://serveur1.arras-sio.com" + lienDuTheme,
            method: "GET",
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.overrideMimeType("application/json; charset=utf-8");
            }
        });

        request.done(function (msg) {
            $.each(msg.listes, function (index, liste) {
                uneListe(liste);
            });
        });

        request.fail(function (jqXHR, textStatus) {
            console.log('Erreur');
        });
    }

    function uneListe(lienListe) {
        var request = $.ajax({
            url: "http://serveur1.arras-sio.com" + lienListe,
            method: "GET",
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.overrideMimeType("application/json; charset=utf-8");
            }
        });

        request.done(function (msg) {
            nbMots = msg.mots.length;
            indiceCourant = 0;
            $.each(msg.mots, function (index, leLienMot) {
                lesMots(leLienMot);
            });
        });

        request.fail(function (jqXHR, textStatus) {
            console.log('Erreur');
        });
    }

    function lesMots(lienMot) {
        var request = $.ajax({
            url: "http://serveur1.arras-sio.com" + lienMot,
            method: "GET",
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.overrideMimeType("application/json; charset=utf-8");
            }
        });

        request.done(function (msg) {
            tableauMotsFR.push(msg.libelle)
            tableauMotsEN.push(msg.libelleen)
            cptMots++;

            if (cptMots == nbMots) {
                passerTest();
            }
            ;
        });

        request.fail(function (jqXHR, textStatus) {
            console.log('Erreur');
        });
    }

    function passerTest() {
        $("#tableauTests").hide();
        $("#traduireMot").show();
        console.log(tableauMotsEN)
        console.log(tableauMotsFR)

        faireAffichage();

        let btConfirmer = document.getElementById("confirmer");
        btConfirmer.addEventListener("click", function () {

            leMot = document.getElementById("reponse").value;
            leMot = leMot.toLowerCase();
            leMot = capitalizeFirstLetter(leMot)

            if (leMot == tableauMotsEN[indiceCourant]) {
                reponses.push(1);
                mesReponses.push(leMot);
            } else {
                reponses.push(0);
                mesReponses.push(leMot);
            }

            if (reponses.length == tableauMotsEN.length) {
                console.log(reponses);
                afficherResultats();
            } else {
                indiceCourant++;
                faireAffichage();
            }


        }, false);

    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function faireAffichage() {
        $("#reponse").val("");
        $("#leMotFr").html(tableauMotsFR[indiceCourant]);
    }

    function afficherResultats() {
        $("#traduireMot").hide();
        $("#tableauResults").show();
        tbodyreponses = document.getElementById("tbodyreponses");

        var countRep = 0;
        for(var i = 0; i < reponses.length; ++i){
            if(reponses[i] == 1)
                countRep++;
        }

        for (var i = 0; i < reponses.length; i++) {
            var trRep = document.createElement('tr');

            trRep.innerHTML =
                "<tr>\n" +
                "    <td>" + tableauMotsFR[i] + "</td>\n" +
                "    <td>" + mesReponses[i] + "</td>\n" +
                "    <td>" + tableauMotsEN[i] + "</td>\n" +
                "    <td>" + reponses[i] + "</td>\n" +
                "</tr>"

            tbodyreponses.appendChild(trRep);
        }

        $("#spanScore").html(countRep + "/" + reponses.length);
        $("#BDscore").val(countRep + "/" + reponses.length);
        $("#BDidtest").val(idTest);

    }


})

