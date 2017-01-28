<?php
$classes = ["ADA" => "001", "AOP1A" => "002", "AOP1B" => "003", "AOP2A" => "004", "AOP2B" => "005", "AOP3A" => "006", "AOP3B" => "007", "AOP3-P" => "008", "BER" => "009", "BFE1A" => "010", "BFM1A" => "011", "BFS1A" => "012", "BFS1B" => "013", "BFS1C" => "014", "BFS2A" => "015", "BFS2B" => "016", "BFS2C" => "017", "CISCO" => "018", "CKB1-3A" => "019", "CKO4A" => "020", "CLB1-3A" => "021", "CLO4A" => "022", "CTA1A" => "023", "CTA2A" => "024", "CTA3A" => "025", "DIFF" => "026", "DIR" => "027", "EAT1A" => "028", "EAT2A" => "029", "EAT3A" => "030", "EAT4A" => "031", "E-FOR" => "032", "EGB1-3A" => "033", "EGB1-3B" => "034", "EGO4A" => "035", "EGO4B" => "036", "EMB1-3A" => "037", "EMO4A" => "038", "FOB1A" => "039", "FOS1A" => "040", "FOS1B" => "041", "FSC1A" => "042", "FSC2A" => "043", "FSC3A" => "044", "FSC4A" => "045", "FSE1A" => "046", "FSE2A" => "047", "FSE3A" => "048", "FSE4A" => "049", "FSM1A" => "050", "FSM2A" => "051", "FSM3A" => "052", "FSM4A" => "053", "GIA1A" => "054", "GIA2A" => "055", "GIA3A" => "056", "GIA4A" => "057", "GYM1A" => "058", "GYM1B" => "059", "GYM1C" => "060", "GYM2A" => "061", "GYM2B" => "062", "GYM2C" => "063", "GYM3A" => "064", "GYM3B" => "065", "GYM3C" => "066", "HKB1-3A" => "067", "HKB1-3B" => "068", "HKO4A" => "069", "HKO4B" => "070", "IDM1A" => "071", "IDM1B" => "072", "IDM2A" => "073", "IDM2B" => "074", "IDM3A" => "075", "IDM3B" => "076", "IDM4A" => "077", "IDM4B" => "078", "IEL1A" => "079", "IEL1B" => "080", "IEL2A" => "081", "IEL2B" => "082", "IEL3A" => "083", "IEL3B" => "084", "IEL4A" => "085", "IEL4B" => "086", "IFK1A" => "087", "IFK1B" => "088", "IFK1C" => "089", "IFK1D" => "090", "IKK" => "091", "ITA1A" => "092", "ITA2A" => "093", "ITA3A" => "094", "ITE1A" => "095", "ITE2A" => "096", "ITE3A" => "097", "ITF1A" => "098", "ITF1B" => "099", "ITF1C" => "100", "ITF2A" => "101", "ITF2B" => "102", "ITF2C" => "103", "ITF3A" => "104", "ITF3B" => "105", "ITF3C" => "106", "LAB1-3A" => "107", "LAO4A" => "108", "LRAT" => "109", "MBB1-3A" => "110", "MBO4A" => "111", "MED" => "112", "NAS" => "113", "NETZ-Team" => "114", "PFB1-2A" => "115", "STG" => "116", "SYS1A" => "117", "SYS2A" => "118", "SYS3A" => "119", "SYS4A" => "120", "THAG" => "121", "TPD1A" => "122", "TPD2A" => "123", "TPD3A" => "124", "TPD4A" => "125", "TSP1A" => "126", "TSP2A" => "127", "TSP3A" => "128", "TSP4A" => "129", "VEW" => "130", "VKK1A" => "131", "VKK1B" => "132", "VKK1C" => "133", "VKK2A" => "134", "VKK2B" => "135", "VKK2C" => "136", "VKK3A" => "137", "VKK3B" => "138", "VKK3C" => "139", "VKK3D" => "140"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HBBK Stundenplan</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="app.js"></script>
</head>
<body>
<div class="hbbk-login">
    <h4>Bitte melde dich mit deinen Ilias Anmeldedaten aus der Schule an:</h4>
    <form>
        <label id="nutzer">Nutzername: <input type="text" name="username" id="username" required autofocus autocomplete="on"></label>
        <label id="passwort">Passswort: <input type="password" name="password" id="password" required autocomplete="on"></label>
        <h4>Bitte wähle deine Klasse aus:</h4>
        <label id="klasse">
            <select name="class" id="class" required autocomplete="on">
                <?php

                foreach ($classes as $class => $value){
                    echo '<option value="'.$class.'">'.$class.'</option>
                    ';
                }


                ?>
            </select>
        </label>
    </form>
</div>
<div class="hbbk-tt" style="display: none;">

</div>
<div class="week-chooser" style="display: block;">
    <form>
        <h4>Bitte wähle die Woche aus:</h4>
        <label id="woche">
            <select name="week" id="week" required>
                <option value="prev">Letzte</option>
                <option value="this">Diese</option>
                <option value="next">Nächste</option>
            </select>
        </label>
    </form>
    <button id="send">Send</button>
</div>
<script>$.ready(function () {
    var $username=$('#username').value;
    var $password=$('#password').value;
    var $week=$('#week').value;
    var $class=$('#class').value;
    $('#send').click(function(){
        var hbbk = $('.hbbk-tt');
        hbbk.html(getTimetable($class, $week, $username, $password));
        hbbk.css("display: block");
    });});</script>
<script src="app.js"></script>
</body>
</html>