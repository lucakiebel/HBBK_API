/**
 * Created by luckie on 25.01.17.
 */
function getTimetable(klasse, woche, nutzername, passwort) {
    console.log("Funktion aufgerufen");
    $.post("../../v1/WebInterface.php",
        {
            username: nutzername,
            password: passwort,
            week: woche,
            class: klasse
        },
        function(data){
            console.log(data);
            return data;
        });
}
