/**
 * Created by HenriJ on 27/12/2017.
 */
// Initialize collapse button
$(".button-collapse").sideNav({
    menuWidth: 310
});
// Initialize collapsible (uncomment the line below if you use the dropdown variation)
// $('.collapsible').collapsible();

$(document).ready(function () {
    $('select').material_select();
    $('.modal').modal();
    $('ul.tabs').tabs();
    $('#search_table').dataTable({"iDisplayLength": 5, "bLengthChange": false});

    $('.input-search').focus(function () {
        $('.input-search').css({'border-bottom': '1px solid #ff9800', 'box-shadow': '0 1px 0 0 #ff9800'});
    });
    $('.input-search').blur(function () {
        $('.input-search').css({'border-bottom': '', 'box-shadow': ''});
    });

    ($('#caisse_closed').attr('value') == 0) ? setInterval('clock()', 1000) : initWhenCaisseIsClosed();

    if (document.getElementById('titre_create') != null)
        document.getElementById('titre_create').reset();

    if ($('#type_titre_id') != null) {
        $('#type_titre_id').trigger('change');
    }

    $('#drop_notif').dropdown({
        constrainWidth: false,
    });

});

function initWhenCaisseIsClosed() {
    $('#heure_delivrance').attr('value', '08:00:00');
    $('#heure_validite').attr('value', '08:00:00');
}


$('#date_delivrance').change(function () {
    setValidityDate();
});

$('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 10, // Creates a dropdown of 10 years to control year,
    today: 'Aujourd\'hui',
    clear: false,
    close: 'Ok',
    format: 'dd/mm/yyyy',
    labelMonthNext: 'Mois suivant',
    labelMonthPrev: 'Mois précédent',
    labelMonthSelect: 'Choisir un mois',
    labelYearSelect: 'Choisir une année',
    firstDay: 'M',
    min: ($('#caisse_closed').attr('value') == 1) ? new Date((new Date()).getFullYear(), (new Date()).getMonth() + 1, parseInt((new Date()).getDate()) + 1) : new Date(),
    closeOnSelect: false,// Close upon selecting a date,
    monthsFull: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
    monthsShort: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc"],
    weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
    weekdaysFull: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"]
});

function setValidityDate() {

    var duree = parseInt($('#duree').val());
    // console.log(duree);

    if (duree > 0 && duree % 24 == 0) {

        var nb_jours = duree / 24;
        // console.log(nb_jours);

        var date_delivrance = $('#date_delivrance').val();
        var d = parseInt(date_delivrance.substring(0, 2));
        var m = parseInt(date_delivrance.substring(3, 5));
        var y = parseInt(date_delivrance.substring(6, 10));
        var next_date = new Date(y, m - 1, d + nb_jours);

        var validity_date =
            ((next_date.getDate() < 10 ? '0' : '') + next_date.getDate()) + '/' +
            ((next_date.getMonth() < 10 ? '0' : '') + parseInt(next_date.getMonth() + 1)) + '/' +
            ((next_date.getFullYear() < 10 ? '0' : '') + next_date.getFullYear());

        $('#date_validite').val(validity_date);
        // $('#duree').blur();

    } else {
        $('#label_duree').attr('data-error', 'Multiple de 24 requis');
        $('#duree').blur();
    }

    Date.prototype.addDays = function (days) {
        var dat = new Date(this.valueOf());
        dat.setDate(dat.getDate() + days);
        return dat;
    }

}

$('#duree').on('input', function () {
    var nb_jours = parseInt($('#duree').val()) / 24;
    var prix_ht = parseInt($('#cout_ht').attr('prix_unit')) * nb_jours;
    $('#cout_ht').val(prix_ht);
    $('#cout_ttc').val(prix_ht * 1.18);
    setValidityDate();
});

$('.timepicker').pickatime({
    default: 'now',
    twelvehour: false, // change to 12 hour AM/PM clock from 24 hour
    canceltext: 'Annuler',
    donetext: 'OK',
    autoclose: false,
    vibrate: true // vibrate the device when dragging clock hand
});


$('#type_titre_id').change(function () {

    console.log($(this).val());
    var id_type_titre = parseInt($(this).val());

    $.ajax({
        method: 'GET',
        url: $(this).attr('action') + '/' + id_type_titre,
        data: {},
        dataType: "json",
        success: function (type) {
            console.log(type.code);

            $('#duree').val(type.duree);
            $('#cout_ht').val(type.prix);
            $('#cout_ht').attr('prix_unit', type.prix);
            $('#cout_ttc').val(parseInt(type.prix) * 1.18);

            if (parseInt(type.duree) != 24) {
                $('#duree').attr('disabled', 'true');
            } else {
                $('#duree').removeAttr('disabled');
            }

            if ($('#type_titre_id').attr('old') != type.code) {
                $('#fonction').val('');
                $('#telephone').val('');
                $('#structure').val('');
                $('#beneficiaire').val('');
                $('#label_fonction').removeClass('active');
                $('#label_fonction').addClass('inactive');
                $('#label_telephone').removeClass('active');
                $('#label_telephone').addClass('inactive');
                $('#label_structure').removeClass('active');
                $('#label_structure').addClass('inactive');
                $('#label_beneficiaire').removeClass('active');
                $('#label_beneficiaire').addClass('inactive');
            }

            if (type.code == 'MT') {
                $('#beneficiaire').attr('disabled', 'true');
                $('#label_beneficiaire').html('Responsable Chauffeur');

                if ($('#div_matricule').hasClass('hide')) {
                    $('#div_matricule').removeClass('hide');
                }

                if ($('#btn_add_vehicule').hasClass('hide')) {
                    $('#btn_add_vehicule').removeClass('hide');
                }

                $('#matricule').removeAttr('disabled');
            }

            if (type.code == 'BT') {
                $('#beneficiaire').removeAttr('disabled');
                $('#label_beneficiaire').html('Bénéficiaire');

                if (!$('#div_matricule').hasClass('hide')) {
                    $('#div_matricule').addClass('hide');
                }

                if (!$('#btn_add_vehicule').hasClass('hide')) {
                    $('#btn_add_vehicule').addClass('hide');
                }

                $('#matricule').attr('disabled', 'true');
            }

            $('#type_titre_id').attr('old', type.code);

            setValidityDate();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
        }
    });

});

$('#beneficiaire').on('input', function () {

    var nom = $(this).val();
    var id = -1;

    var options = $('#list_beneficiaires').children();

    for (var i = 0; i < options.size(); i++) {
        // console.log(options[i].value);
        if (options[i].value == nom) {
            id = options[i].id;
        }
    }

    if (parseInt(id) == -1) {
        console.log(id);
        $('#structure').val('');
        $('#fonction').val('');
        $('#telephone').val('');
        $('#label_structure').removeClass('active');
        $('#label_telephone').removeClass('active');
        $('#label_fonction').removeClass('active');
        $('#beneficiaire').addClass('invalid');
        if (nom != '') {
            // $('#label_beneficiaire').attr('data-error', 'Ce bénéficiaire n\'existe pas. Ajoutez-le !');
        }
        // $('#label_beneficiaire').addClass('active');
        // $('#beneficiaire').blur();
    } else {
        $.ajax({
            method: 'GET',
            url: $(this).attr('action') + '/' + id,
            data: {},
            dataType: "json",
            success: function (infos) {

                console.log(infos);
                $('#structure option[value="' + infos.structure_id + '"]').prop("selected", true);
                $('#fonction').val(infos.fonction);
                $('#telephone').val(infos.telephone);
                $('#structure').val(infos.structure);
                $('#label_fonction').addClass('active');
                $('#label_telephone').addClass('active');
                $('#label_structure').addClass('active');

                $('#beneficiaire').blur();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
            }
        });
    }

});

$('#matricule').on('input', function () {

    var matricule = $(this).val();
    var id = -1;

    var options = $('#list_matricules').children();

    for (var i = 0; i < options.size(); i++) {
        // console.log(options[i].value);
        if (options[i].value == matricule) {
            id = options[i].id;
        }
    }

    if (parseInt(id) == -1) {
        console.log(id);
        $('#structure').val('');
        $('#fonction').val('');
        $('#telephone').val('');
        $('#beneficiaire').val('');
        $('#label_telephone').removeClass('active');
        $('#label_fonction').removeClass('active');
        $('#label_structure').removeClass('active');
        $('#label_beneficiaire').removeClass('active');
        // $('#label_beneficiaire').addClass('active');
        // $('#beneficiaire').blur();
    } else {
        $.ajax({
            method: 'GET',
            url: $(this).attr('action') + '/' + id,
            data: {},
            dataType: "json",
            success: function (infos) {

                console.log(infos.user);
                $('#fonction').val(infos.fonction);
                $('#telephone').val(infos.telephone);
                $('#structure').val(infos.structure);
                $('#beneficiaire').val(infos.user);
                $('#label_fonction').addClass('active');
                $('#label_telephone').addClass('active');
                $('#label_structure').addClass('active');
                $('#label_beneficiaire').addClass('active');

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
            }
        });
    }

});


//Soumission de la création de titre
$('#submit_save_titre').click(function (e) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    e.preventDefault();

    var i_beneficiaire = $('#beneficiaire');
    var i_duree = $('#duree');
    var id = -1;

    if (i_beneficiaire.val() == '') {
        i_beneficiaire.addClass('invalid');
        $('#label_beneficiaire').attr('data-error', 'Champ obligatoire');
        $('#matricule').addClass('invalid');
        $('#label_matricule').attr('data-error', 'Champ obligatoire');
        return;
    } else {
        var nom = i_beneficiaire.val();
        var options = $('#list_beneficiaires').children();
        for (var i = 0; i < options.size(); i++) {
            // console.log(options[i].value);
            if (options[i].value == nom) {
                id = options[i].id;
            }
        }
        if (id == -1) {
            i_beneficiaire.addClass('invalid');
            $('#label_beneficiaire').attr('data-error', 'Ce bénéficiaire n\'existe pas');
            return;
        }
    }
    if (i_duree.val() == '') {
        i_duree.addClass('invalid');
        $('#label_duree').attr('data-error', 'Champ obligatoire');
        return;
    }

    var type_titre_id = $('#type_titre_id option:selected').val();
    var zone_id = $('#zone_id').val();
    var piece_justif = $('#piece').val();
    var usager_id = getUsagerId();
    var date_delivrance = $('#date_delivrance').val();
    var heure_delivrance = $('#heure_delivrance').val();
    var duree = $('#duree').val();

    /*console.log('type_titre_id : ' + type_titre_id);
     console.log('zone_id : ' + zone_id);
     console.log('piece : ' + piece_justif);
     console.log('usager_id : ' + usager_id);
     console.log('date_delivrance : ' + date_delivrance);
     console.log('heure_delivrance : ' + heure_delivrance);
     console.log('duree : ' + duree);*/

    $.ajax({
        url: $('#submit_save_titre').attr('link'),
        type: "POST",
        data: {
            'type_titre_id': type_titre_id,
            'zone_id': zone_id,
            'piece': piece_justif,
            'usager_id': usager_id,
            'date_delivrance': date_delivrance,
            'heure_delivrance': heure_delivrance,
            'duree': duree
        }
        /*$('#form_create').serialize()*/,
        dataType: 'json',
        success: function (data) {
            console.log(data.response);

            if (data.response == 'ok') {
                var titre_id = data.last_insert_id;

                var show_link = $('#submit_save_titre').attr('show_link');
                show_link = show_link.substr(0, show_link.lastIndexOf('/'));
                // console.log(show_link+'/'+titre_id);

                Materialize.toast('Le titre n° ' + $('#numero_titre').html() + ' a été enregistré !', 4000);

                window.location = show_link + '/' + titre_id;
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
            Materialize.toast('Echec de l\'enregistrement ! Rechargez la page et réessayez', 4000);
        }
    });
});

//Retourne l'ID de l'usager sélectionné sur le formulaire de création de titre
function getUsagerId() {

    var nom = $('#beneficiaire').val();
    var id = -1;
    var options = $('#list_beneficiaires').children();

    for (var i = 0; i < options.size(); i++) {
        // console.log(options[i].value);
        if (options[i].value == nom) {
            id = options[i].id;
        }
    }

    return id;
}

//Affiche un apercu d'image sélectionné
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#profil").change(function () {
    readURL(this);
});

function clock() {
    var mytime = new Date();
    var seconds = (mytime.getSeconds() < 10) ? "0" + mytime.getSeconds() : mytime.getSeconds();
    var minutes = (mytime.getMinutes() < 10) ? "0" + mytime.getMinutes() : mytime.getMinutes();
    var hours = (mytime.getHours() < 10) ? "0" + mytime.getHours() : mytime.getHours();
    var currentTime = hours + ":" + minutes + ":" + seconds;
    $("#heure_delivrance").val(currentTime);
    $("#heure_validite").val(currentTime);
}

//Soumission de l'ajout de type de titres
$('#submit_add_type_titre').click(function () {
    var libelle = $('#libelle_type_titre').val();
    var duree = $('#duree_add_tt').val();
    var prix = $('#prix_add_tt').val();
    var code = $('#code_type').val();

    var has_errors = false;
    var exists = false;

    if (libelle == '') {
        $('#libelle_type_titre').addClass('invalid');
        $('#label_libelle_type_titre').attr('data-error', 'Champ obligatoire');
        $('#label_libelle_type_titre').addClass('active');
        has_errors = true
    } else {

        $('#libelle_type_titre').removeClass('invalid');
        $('#label_libelle_type_titre').removeAttr('data-error');

        var options = $('#type_titre_id').children();

        for (var i = 0; i < options.size(); i++) {
            if (options[i].text == libelle) {
                $('#libelle_type_titre').addClass('invalid');
                $('#label_libelle_type_titre').attr('data-error', 'La valeur du champ libelle est déjà utilisée.');
                $('#label_libelle_type_titre').addClass('active');
                exists = true;
            }
        }

    }

    if (duree == '') {
        $('#duree_add_tt').addClass('invalid');
        $('#label_duree_add_tt').attr('data-error', 'Champ obligatoire');
        $('#label_duree_add_tt').addClass('active');

        has_errors = true;
    } else {
        $('#duree_add_tt').removeClass('invalid');
        $('#label_duree_add_tt').removeAttr('data-error');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: $('#code_type').attr('link'),
            type: "POST",
            data: {'duree': duree},
            dataType: 'json',
            success: function (data) {
                console.log(data.exists);

                if (data.exists == 'ok') {
                    $('#duree_add_tt').addClass('invalid');
                    $('#label_duree_add_tt').attr('data-error', 'La valeur du champ durée est déjà utilisée.');

                    has_errors = true;
                } else {
                    $('#duree_add_tt').removeClass('invalid');
                    $('#label_duree_add_tt').removeAttr('data-error');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
            }
        });
    }

    if (prix == '') {
        $('#prix_add_tt').addClass('invalid');
        $('#label_prix_add_tt').attr('data-error', 'Champ obligatoire');
        $('#label_prix_add_tt').addClass('active');

        has_errors = true;
    } else {
        $('#prix_add_tt').removeClass('invalid');
        $('#label_prix_add_tt').removeAttr('data-error');
    }

    if (!exists && !has_errors) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        //Send data by AJAX
        $.ajax({
            url: $(this).attr('link'),
            type: "POST",
            data: {
                'code': code,
                'libelle': libelle,
                'duree': duree,
                'prix': prix
            },
            dataType: 'json',
            success: function (data) {
                console.log(data.response);

                if (data.response == 'ok') {
                    Materialize.toast('Le type de titre ' + libelle + ' a été enregistré !', 4000);

                    window.location.reload();
                } else {
                    Materialize.toast("Echec de l'enregistrement !", 4000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                Materialize.toast('Echec de l\'enregistrement ! Rechargez la page et réessayez', 4000);
            }
        });
    }


});

//Soumission de l'ajout de zone
$('#submit_add_zone').click(function (e) {
    var lib_zone = $('#libelle_zone').val();
    if (lib_zone == '') {
        $('#libelle_zone').addClass('invalid');
        $('#label_lib_zone').attr('data-error', 'Champ obligatoire');
        $('#label_lib_zone').addClass('active');
    } else {
        $('#libelle_zone').removeClass('invalid');
        $('#label_lib_zone').removeAttr('data-error');


        var options = $('#zone_id').children();
        var exists = false;

        for (var i = 0; i < options.size(); i++) {
            if (options[i].text == lib_zone) {
                $('#libelle_zone').addClass('invalid');
                $('#label_lib_zone').attr('data-error', 'La valeur du champ libelle est déjà utilisée.');
                $('#label_lib_zone').addClass('active');
                exists = true;
            }
        }

        if (!exists) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            //Send data by AJAX
            $.ajax({
                url: $(this).attr('link'),
                type: "POST",
                data: {
                    'libelle': lib_zone
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data.response);

                    if (data.response == 'ok') {
                        Materialize.toast('La zone ' + lib_zone + ' a été enregistrée !', 4000);
                        window.location.reload();
                    } else {
                        Materialize.toast("Echec de l'enregistrement !", 4000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
                    Materialize.toast('Echec de l\'enregistrement ! Rechargez la page et réessayez', 4000);
                }
            });
        }
    }
});

//Soumission de l'ajout de structure
$('#submit_add_structure').click(function () {

    var raison_sociale = $('#raison_sociale').val();
    var contact = $('#contact_structure').val();
    var adresse = $('#adresse_structure').val();


    var has_errors = false;
    var exists = false;

    if (raison_sociale == '') {
        $('#raison_sociale').addClass('invalid');
        $('#label_raison_sociale').attr('data-error', 'Champ obligatoire');
        $('#label_raison_sociale').addClass('active');
        has_errors = true
    } else {

        $('#raison_sociale').removeClass('invalid');
        $('#label_raison_sociale').removeAttr('data-error');

        var options = $('#list_structures_id').children();

        for (var i = 0; i < options.size(); i++) {
            if (options[i].text == raison_sociale) {
                $('#raison_sociale').addClass('invalid');
                $('#label_raison_sociale').attr('data-error', 'La valeur du champ raison sociale est déjà utilisée.');
                $('#label_raison_sociale').addClass('active');
                exists = true;
            }
        }

    }

    if (contact == '') {
        $('#contact_structure').addClass('invalid');
        $('#label_contact_structure').attr('data-error', 'Champ obligatoire');
        $('#label_contact_structure').addClass('active');

        has_errors = true;
    } else {
        $('#contact_structure').removeClass('invalid');
        $('#label_contact_structure').removeAttr('data-error');
    }

    if (adresse == '') {
        $('#adresse_structure').addClass('invalid');
        $('#label_adresse_structure').attr('data-error', 'Champ obligatoire');
        $('#label_adresse_structure').addClass('active');

        has_errors = true;
    } else {
        $('#adresse_structure').removeClass('invalid');
        $('#label_adresse_structure').removeAttr('data-error');
    }

    if (!exists && !has_errors) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        //Send data by AJAX
        $.ajax({
            url: $(this).attr('link'),
            type: "POST",
            data: {
                'raison_sociale': raison_sociale,
                'contact': contact,
                'adresse': adresse
            },
            dataType: 'json',
            success: function (data) {
                console.log(data.response);

                if (data.response == 'ok') {
                    Materialize.toast('La structure ' + raison_sociale + ' a été enregistrée !', 4000);

                    window.location.reload();
                } else {
                    Materialize.toast("Echec de l'enregistrement !", 4000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                Materialize.toast('Echec de l\'enregistrement ! Rechargez la page et réessayez', 4000);
            }
        });
    }

});


//Soumission de l'ajout de véhicule
$('#submit_add_vehicule').click(function () {

    var immatriculation = $('#immatriculation').val();
    var marque = $('#marque').val();
    var type_vehicule_id = $('#vehicule_type_id').val();
    var user_id = $('#vehicule_user_id').val();

    var has_errors = false;
    var exists = false;

    if (immatriculation == '') {
        $('#immatriculation').addClass('invalid');
        $('#label_immatriculation').attr('data-error', 'Champ obligatoire');
        $('#label_immatriculation').addClass('active');
        has_errors = true
    } else {

        $('#immatriculation').removeClass('invalid');
        $('#label_immatriculation').removeAttr('data-error');

        var options = $('#list_matricules').children();

        for (var i = 0; i < options.size(); i++) {
            if (options[i].value == immatriculation) {
                $('#immatriculation').addClass('invalid');
                $('#label_immatriculation').attr('data-error', 'La valeur du champ immatriculation est déjà utilisée.');
                $('#label_immatriculation').addClass('active');
                exists = true;
            }
        }

    }

    if (marque == '') {
        $('#marque').addClass('invalid');
        $('#label_marque').attr('data-error', 'Champ obligatoire');
        $('#label_marque').addClass('active');

        has_errors = true;
    } else {
        $('#marque').removeClass('invalid');
        $('#label_marque').removeAttr('data-error');
    }

    if (!exists && !has_errors) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        //Send data by AJAX
        $.ajax({
            url: $(this).attr('link'),
            type: "POST",
            data: {
                'immatriculation': immatriculation,
                'marque': marque,
                'type_vehicule_id': type_vehicule_id,
                'user_id': user_id
            },
            dataType: 'json',
            success: function (data) {
                console.log(data.response);

                if (data.response == 'ok') {
                    Materialize.toast('Le véhicule d\'immatriculation : ' + immatriculation + ' a été enregistré !', 4000);
                    window.location.reload();
                } else {
                    Materialize.toast("Echec de l'enregistrement !", 4000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Materialize.toast('Echec de l\'enregistrement ! Rechargez la page et réessayez', 4000);
                console.log(jqXHR.responseText);
            }
        });
    }

});

//Soumission de l'ajout de bénéficiaire
$('#submit_add_beneficiaire').click(function () {

    var nom = $('#nom_beneficiaire').val();
    var prenoms = $('#prenom_beneficiaire').val();
    var fonction = $('#fonction_beneficiaire').val();
    var structure_id = $('#list_structures_id').val();
    var telephone = $('#telephone_beneficiaire').val();
    var adresse = $('#adresse_beneficiaire').val();

    var ok = validate_input('nom_beneficiaire');
    var ok1 = validate_input('prenom_beneficiaire');
    var ok2 = validate_input('fonction_beneficiaire');
    var ok3 = validate_input('telephone_beneficiaire');
    var ok4 = validate_input('adresse_beneficiaire');

    if (ok3) {
        //Check if telephone exists
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: $('#telephone_beneficiaire').attr('link'),
            type: "POST",
            data: {'telephone': telephone},
            dataType: 'json',
            success: function (data) {
                console.log('input : ' + data.input);
                console.log(data.exists);

                if (data.exists == 'ok') {
                    $('#telephone_beneficiaire').addClass('invalid');
                    $('#label_telephone_beneficiaire').attr('data-error', 'La valeur du champ telephone est déjà utilisée.');

                    ok3 = false;
                } else {
                    $('#telephone_beneficiaire').removeClass('invalid');
                    $('#label_telephone_beneficiaire').removeAttr('data-error');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
            }
        });
    }

    if (ok && ok1 && ok2 && ok3 && ok4) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        //Send data by AJAX
        $.ajax({
            url: $('#submit_add_beneficiaire').attr('link'),
            type: "POST",
            data: {
                'nom': nom,
                'prenom': prenoms,
                'fonction': fonction,
                'structure_id': structure_id,
                'telephone': telephone,
                'adresse': adresse
            },
            dataType: 'json',
            success: function (data) {
                console.log(data.response);

                if (data.response == 'ok') {
                    Materialize.toast('L\'usager : ' + prenoms + ' ' + nom + ' a été correctement enregistré !', 4000);
                    window.location.reload();
                } else {
                    Materialize.toast("Echec de l'enregistrement !", 4000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Materialize.toast('Echec de l\'enregistrement ! Rechargez la page et réessayez', 4000);
                console.log(jqXHR.responseText);
            }
        });
    }

});

function validate_input(field_id) {

    if ($('#' + field_id).val() == '') {
        $('#' + field_id).addClass('invalid');
        $('#label_' + field_id).attr('data-error', 'Champ obligatoire');
        $('#label_' + field_id).addClass('active');

        return false;
    } else {
        $('#' + field_id).removeClass('invalid');
        $('#label_' + field_id).removeAttr('data-error');
    }

    return true;
}

function setSelectByText(eID,text)
{ //Loop through sequentially//
    var ele=document.getElementById(eID);
    for(var ii=0; ii<ele.length; ii++)
        if(ele.options[ii].text==text) { //Found!
            ele.options[ii].selected=true;
            return true;
        }
    return false;
}

$('#c_user_type_id').change(function () {

    if ($('#c_user_type_id option:selected').text() != 'Distributeur') {
        $('#c_user_group_id').attr('readonly', 'readonly');

        var groupes = $('#c_user_group_id').children();

        $("#c_user_group_id option[text='" + "Aucun groupe" +"']").attr("selected","selected");

        for (var i = 0; i < groupes.length; i++) {
            if (groupes[i].text == 'Aucun groupe') {
                console.log(groupes[i].value);

                document.getElementById("c_user_group_id").value = groupes[i].value;
            }
        }
    }

});