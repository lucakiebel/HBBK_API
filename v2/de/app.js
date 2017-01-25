/**
 * Created by luckie on 25.01.17.
 */
function getTimetable(klasse, woche, nutzername, passwort) {
    $.post("https://hbbk.radon.cloud/v1/WebInterface.php",
        {
            username: nutzername,
            password: passwort,
            week: woche,
            class: klasse
        },
        function(data){
            alert(data);
            return data;
        });
}