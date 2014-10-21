$(document).ready(function() {
    $('#example').dataTable({
        "oLanguage": {"sUrl": "../fr/fr.txt"},
        searching: false,
        ordering: false,
        "columnDefs": [{
                "type": "salary-grade",
                "targets": -1

            }]
    });
    $('#table-note').dataTable({
        "oLanguage": {"sUrl": "../fr/fr.txt"},
        searching: false,
        "bLengthChange": false,
        ordering: false,
        "columnDefs": [{
                "type": "salary-grade",
                "targets": -1

            }]
    });
    $("#btn_start_test").click(function() {
        var ur = '/user/start/id/'+$("#btn_start_test").val();
        $.ajax({
            type: "GET",
            url: ur,
            success: function(html) {
                $("#load").show(300);
                afficher(html);
            },
            error: function(XMLHttpRequest, textStatus, errorThrow) {
                afficher(textStatus);
            }

        });

    });
});
/**
 * Recuperer les notes du test d'une formations
 * @param {int} for_id
 * @param {int} emp_id
 * @returns {Boolean}
 */
function getNotes(for_id, emp_id)
{
    var tbody = "";
    $('#al').modal('show');
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "/user/note",
        data: {'for_id': for_id, 'emp_id': emp_id},
        beforeSend: function()
        {
            $('#load').html('<img src=/images/loaders/loader1.gif />');
        },
        success: function(data) {

            $.each(data, function(val, text)
            {
                tbody += "<tr> <td>" + text.date + "</td><td>" + text.note + "</td></tr>";
            });
            $('#table-note tbody').html(tbody);
        }
    });
    return false;
}
/**
 * Accepter une formation
 * @param {int} formation_id
 * @returns 
 */
function accepterFormation(formation_id,test_id)
{
    if (confirm('Voulez-vous confirmer cette action')) {
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: "/user/accepterFormation",
            data: {'for_id': formation_id},
            beforeSend: function()
            {
                $("#for_" + formation_id).html('<img src=/images/loaders/loader.gif />');
            },
            success: function(data) {

                $("#for_" + formation_id).html("en cours");
                $("#" + test_id).html("<a href='user/tests/id/"+test_id+"'>passer le test</a>");
            }
        });
    }
}
/**
 * 
 * @param {object} data
 * @returns 
 */
function afficher(data)
{
    var img = "<center><img src='/images/loading.gif'/></center";
    $("#contrat").fadeOut(400, function()
    {

        $("#contrat").empty();
        $("#contrat").append(img);
        $("#contrat").fadeIn(400);

        $("#contrat").fadeOut(400, 'linear', function()
        {

            $("#contrat").empty();
            $("#contrat").append(data);
            $("#contrat").fadeIn(400, 'swing');
        })
    });
       if ($("#chrono").is(':checked')) {
            $("#chron1").Chron().start();
            $(".chrono").show();
        }
}
function requestResponse(val)
{
    var reponse=val.value;
    var question=$(val).attr('name');
       $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/user/reponse',
            data: {'reponse': reponse,'question':question},
            success: function(data) {
                jQuery.each(data, function(val, text) 
						{ alert(text);
                                                })
            }
        });
}
                