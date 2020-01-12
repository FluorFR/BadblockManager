@extends('layouts.app')
@section('header')
    <link rel="stylesheet" href="/assets/plugins/magnific-popup/dist/magnific-popup.css"/>
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <h3 style="text-align: center">Émission de sanction</h3>
                <div class="card-box">


                        <!--- Étape 1 : Donner la raison de la sanction -->

                        <h4 class="header-title m-t-0 m-b-30">Raison</h4>

                        <div class="form-group">
                            <select id="reason" name="reason" class="form-control" onchange="deducePossibleSanction()">
                                @foreach($Raison as $row)
                                    <option id="{{ $row }}" value="{{ $row }}">{{ $row }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!--- Étape 2 : En déduire le type de sanction possible -->

                        <div id="sanction_type" style="display: none">

                            <br />

                            <h4 class="header-title m-t-0 m-b-30">Type de sanction</h4>

                            <label id="sanction_div_warn" class="radio-inline btn btn-success waves-effect w-md waves-light m-b-5" style="display: none">
                                <input type="radio" name="sanction" id="sanction_warn" value="Warn" onclick="displayPseudoDiv()"> Warn
                            </label>
                            <label id="sanction_div_mute" class="radio-inline btn btn-primary waves-effect w-md waves-light m-b-5" style="display: none">
                                <input type="radio" name="sanction" id="sanction_mute" value="Mute" onclick="displayPseudoDiv()"> Mute
                            </label>
                            <label id="sanction_div_kick" class="radio-inline btn btn-info waves-effect w-md waves-light m-b-5" style="display: none">
                                <input type="radio" name="sanction" id="sanction_kick" value="Kick" onclick="displayPseudoDiv()"> Kick
                            </label>
                            <label id="sanction_div_ban" class="radio-inline btn btn-warning waves-effect w-md waves-light m-b-5" style="display: none">
                                <input type="radio" name="sanction" id="sanction_ban" value="Ban" onclick="displayPseudoDiv()"> Ban
                            </label>
                            <label id="sanction_div_ban_ban_ip" class="radio-inline btn btn-danger waves-effect w-md waves-light m-b-5" style="display: none">
                                <input type="radio" name="sanction" id="sanction_ban_ban_ip" value="Ban_+_Ban_IP" onclick="displayPseudoDiv()"> Ban + Ban IP
                            </label>

                        </div>


                        <!--- Étape 3 : Afficher le div du pseudo -->


                        <div id="pseudo_form" style="display: none">

                            <br>
                            <br>
                            <h4 class="header-title m-t-0 m-b-30">Pseudo</h4>

                            <input id="pseudo" type="text" name="pseudo" class="form-control" placeholder="Fluor">

                        </div>

                        <!--- Étape 4 : Afficher le temps sous forme de checkbox possibles -->


                        <div id="time_form" style="display: none;">

                            <br />
                            <br />
                            <h4 class="header-title m-t-0 m-b-30">Durée de la sanction (h pour heure, d pour jour, m pour mois, y pour an)</h4>
                            <br>
                            <label id="sanction_time_label_1" for="sanction_time_1" class="radio-inline btn btn-success waves-effect w-md waves-light m-b-5" style="display: none">
                            </label>
                            <label id="sanction_time_label_2" for="sanction_time_2" class="radio-inline btn btn-info waves-effect w-md waves-light m-b-5" style="display: none">
                            </label>
                            <label id="sanction_time_label_3" for="sanction_time_3" class="radio-inline btn btn-warning waves-effect w-md waves-light m-b-5" style="display: none">
                            </label>
                            <label id="sanction_time_label_4" for="sanction_time_4"  class="radio-inline btn btn-danger waves-effect w-md waves-light m-b-5" style="display: none">
                            </label>
                            <div class="form-group" id="sanction_time_label_5" style="display: none">
                                <input type="text" class="form-control" id="sanction_time_5" placeholder="1d" onkeypress="displaySubmitButton()">
                            </div>

                        </div>

                        <div id="submitButton" style="display: none;">
                            <br />
                            <input type="submit" value="Envoyer la sanction" class="btn btn-info" onclick="submitForm();" />
                        </div>


                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_scripts')

    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script>

        //Étape 1 : Donner la raison de la sanction
        //Étape 2 : En déduire le type de sanction possible
        //Étape 3 : Afficher le div du pseudo
        //Étape 4 : Afficher le temps sous forme de checkbox possibles

        function getSanctions(){
            var sanctions = [
                'Anti-Jeux / Spawnkill',
                'Aveu de cheat',
                'Cheat',
                'Cheat  + (Irrespect Staff / Perte de temps / Troll)',
                'Déconnection en vérif',
                'Diffamation',
                'Discrimination (homophobie, racisme, antisémitisme ...)',
                'Farm AFK - Anti AFK (skyblock / faction)',
                'Insulte Serveur / Communauté',
                'Insulte / Provocation / Citation de serveur',
                'Insulte Staff / Menace staff / Irrespect staff / Mensonge staff',
                'Menace (DDOS / Hack)',
                'Pillage skyblock/Duplication',
                'Plot Obscène , religieux ou non réglementé',
                'Pseudo Inapproprié / Choquant / Diffamatoir / Insultant / Obscène',
                'Publicité / Vente',
                'Question (ou insulte) en /modo inutile',
                'Recrutement staff',
                'Refus de vérif',
                'Sanction particulière',
                'Skin Injurieux ou Obscène',
                'Spam / Flood / Couleur'
            ];

            return sanctions;
        }

        function getDurations(){
            var durations = [
                '1h', //0
                '3h', //1
                '6h', //2
                '12h', //3
                '1d', //4
                '3d', //5
                '7d', //6
                '15d', //7
                '30d', //8
                '45d', //9
                '60d', //10
                '120d', //11
                '6m', //12
                '1y' //13
            ];

            return durations;
        }


        function deducePossibleSanction(){

            var reasonValue = $("#reason").val();

            //22 raisons
            var sanctionReason = getSanctions();

            var warn = false;
            var kick = false;
            var mute = false;
            var ban = false;
            var ban_ban_ip = false;

            var sanctionTypeDiv = $("#sanction_type");
            var sanctionDivWarn = $("#sanction_div_warn");
            var sanctionDivMute = $("#sanction_div_mute");
            var sanctionDivKick = $("#sanction_div_kick");
            var sanctionDivBan = $("#sanction_div_ban");
            var sanctionDivBanBanIp = $("#sanction_div_ban_ban_ip");

            sanctionTypeDiv.css('display', 'none');
            sanctionDivWarn.css('display', 'none');
            sanctionDivMute.css('display', 'none');
            sanctionDivKick.css('display', 'none');
            sanctionDivBan.css('display', 'none');
            sanctionDivBanBanIp.css('display', 'none');
            $("#pseudo_form").css("display", "none");
            $("#time_form").css("display", "none");
            $("#sanction_time_label_5").css('display', 'none');
            $("#submitButton").css('display', 'none');


            if(reasonValue == sanctionReason[0]){
                kick = true;
                ban_ban_ip = true;
            }
            else if (reasonValue == sanctionReason[1]){
                ban_ban_ip = true;
            }
            else if (reasonValue == sanctionReason[2]){
                ban_ban_ip = true;
            }
            else if (reasonValue == sanctionReason[3]){
                ban_ban_ip = true;
            }
            else if (reasonValue == sanctionReason[4]){
                ban_ban_ip = true;
            }
            else if (reasonValue == sanctionReason[5]){
                mute = true;
            }
            else if (reasonValue == sanctionReason[6]){
                mute = true;
            }
            else if (reasonValue == sanctionReason[7]){
                kick = true;
                ban_ban_ip = true;
            }
            else if (reasonValue == sanctionReason[8]){
                mute = true;
            }
            else if (reasonValue == sanctionReason[9]){
                warn = true;
                mute = true
            }
            else if (reasonValue == sanctionReason[10]){
                mute = true;
            }
            else if (reasonValue == sanctionReason[11]){
                ban_ban_ip = true;
            }
            else if (reasonValue == sanctionReason[12]){
                ban_ban_ip = true;
            }
            else if (reasonValue == sanctionReason[13]){
                //Clear Plot, rien à mettre ici
            }
            else if (reasonValue == sanctionReason[14]){
                ban = true;
            }
            else if (reasonValue == sanctionReason[15]){
                mute = true;
            }
            else if (reasonValue == sanctionReason[16]){
                kick = true;
                ban = true;
            }
            else if (reasonValue == sanctionReason[17]){
                mute = true;
            }
            else if (reasonValue == sanctionReason[18]){
                ban_ban_ip = true;
            }
            else if (reasonValue == sanctionReason[19]){
                warn = true;
                kick = true;
                mute = true;
                ban = true;
                ban_ban_ip = true;
            }
            else if (reasonValue == sanctionReason[20]){
                ban = true;
            }
            else if (reasonValue == sanctionReason[21]){
                warn = true;
                mute = true;
            }
            else {
                toastr.error("Erreur dans la raison entrée", 'Erreur !');
            }

            if(warn == true || kick == true || mute == true || ban == true || ban_ban_ip == true) {

                sanctionTypeDiv.css('display', 'block');

                if (warn == true) {
                    sanctionDivWarn.css('display', 'block');
                }
                if (mute == true) {
                    sanctionDivMute.css('display', 'block');
                }
                if (kick == true) {
                    sanctionDivKick.css('display', 'block');
                }
                if (ban == true) {
                    sanctionDivBan.css('display', 'block');
                }
                if (ban_ban_ip == true > 0) {
                    sanctionDivBanBanIp.css('display', 'block');
                }
            }

            else {
                toastr.error("Sanction non ou mal configurée, merci de contacter un administrateur", 'Erreur !');
            }

        }

        function displayPseudoDiv(){
            var pseudoForm = $("#pseudo_form");

            if(document.querySelectorAll('[name="sanction"]:checked') != 'undefined'){
                pseudoForm.css('display', 'block');
                deduceAndDisplaySanctionDuration();
            }


        }

        function deduceAndDisplaySanctionDuration(){

            var timeForm = $("#time_form");

            var reasonValue = $("#reason").val();
            var choosenSanction = document.querySelectorAll('[name="sanction"]:checked').item(0).id;

            var sanctionReason = getSanctions();

            var durations = getDurations();

            var muteDurations = [];
            var banDurations = [];
            var ban_ban_ipDurations = [];

            var kick = false;
            var warn = false;
            var specialSanction = false;

            timeForm.find('[name=\"sanction_time\"]:checked').val('undefined');
            timeForm.css('display', 'none');
            $("#sanction_time_label_1").css("display", "none");
            $("#sanction_time_label_2").css("display", "none");
            $("#sanction_time_label_3").css("display", "none");
            $("#sanction_time_label_4").css("display", "none");



            if(reasonValue == sanctionReason[0]){
                kick = true;
                ban_ban_ipDurations.push(durations[5], durations[6]);
            }
            else if (reasonValue == sanctionReason[1]){
                ban_ban_ipDurations.push(durations[8], durations[11], durations[13]);
            }
            else if (reasonValue == sanctionReason[2]){
                ban_ban_ipDurations.push(durations[9], durations[13]);
            }
            else if (reasonValue == sanctionReason[3]){
                ban_ban_ipDurations.push(durations[10], durations[13]);
            }
            else if (reasonValue == sanctionReason[4]){
                ban_ban_ipDurations.push(durations[9], durations[13]);
            }
            else if (reasonValue == sanctionReason[5]){
                muteDurations.push(durations[2], durations[3], durations[4]);
            }
            else if (reasonValue == sanctionReason[6]){
                muteDurations.push(durations[4], durations[5], durations[6]);
            }
            else if (reasonValue == sanctionReason[7]){
                kick = true;
                ban_ban_ipDurations.push(durations[4], durations[5], durations[6]);
            }
            else if (reasonValue == sanctionReason[8]){
                muteDurations.push(durations[7], durations[8], durations[10]);
            }
            else if (reasonValue == sanctionReason[9]){
                warn = true;
                muteDurations.push(durations[0], durations[1], durations[2]);
            }
            else if (reasonValue == sanctionReason[10]){
                muteDurations.push(durations[4], durations[6], durations[8]);
            }
            else if (reasonValue == sanctionReason[11]){
                ban_ban_ipDurations.push(durations[6], durations[7], durations[8]);
            }
            else if (reasonValue == sanctionReason[12]){
                ban_ban_ipDurations.push(durations[8], durations[12], durations[13]);
            }
            else if (reasonValue == sanctionReason[13]){
                //Clear Plot, rien à mettre ici
            }
            else if (reasonValue == sanctionReason[14]){
                banDurations.push(durations[13]);
            }
            else if (reasonValue == sanctionReason[15]){
                muteDurations.push(durations[6], durations[7], durations[8]);
            }
            else if (reasonValue == sanctionReason[16]){
                kick = true;
                banDurations.push(durations[0], durations[4]);
            }
            else if (reasonValue == sanctionReason[17]){
                muteDurations.push(durations[7], durations[8]);
            }
            else if (reasonValue == sanctionReason[18]){
                ban_ban_ipDurations.push(durations[9], durations[11], durations[13]);
            }
            else if (reasonValue == sanctionReason[19]){
                specialSanction = true;
            }
            else if (reasonValue == sanctionReason[20]){
                banDurations.push(durations[8], durations[13]);
            }
            else if (reasonValue == sanctionReason[21]){
                warn = true;
                muteDurations.push(durations[0], durations[1], durations[2]);
            }



            if(warn == true && choosenSanction == 'sanction_warn'){
                displaySubmitButton();
            }

            if(muteDurations.length > 0 && choosenSanction == 'sanction_mute'){
                displaySanctionTime(muteDurations);
            }

            if(kick == true && choosenSanction == 'sanction_kick'){
                displaySubmitButton();
            }

            if(banDurations.length > 0 && choosenSanction == 'sanction_ban'){
                displaySanctionTime(banDurations);
            }

            if(ban_ban_ipDurations.length > 0 && choosenSanction == 'sanction_ban_ban_ip'){
                displaySanctionTime(ban_ban_ipDurations);
            }

            if(specialSanction == true){
                if(choosenSanction == 'sanction_mute' || choosenSanction == 'sanction_ban' || choosenSanction == 'sanction_ban_ban_ip'){
                    displaySanctionTimeChooser();
                }

                else if(choosenSanction == 'sanction_warn' || choosenSanction == 'sanction_kick'){
                    $("#sanction_time_5").val("");
                    displaySubmitButton();
                }
            }

        }

        function displaySanctionTimeChooser(){
            $("#time_form").css('display', 'block');
            $("#sanction_time_label_5").css('display', 'block');
        }

        function displaySanctionTime(array){
            var labelContainer;
            $("#time_form").css('display', 'block');

            for(var i = 1; i <= array.length; i++){
                labelContainer = $("#sanction_time_label_"+i);
                labelContainer.html('<input type="radio" name="sanction_time" id="sanction_time_'+i+'" value="'+array[i-1]+'" onclick="displaySubmitButton()" />  '+ array[i-1]);
                labelContainer.css('display', 'block');
            }
        }

        function displaySubmitButton(){
            if(document.querySelectorAll('[name="sanction_time"]:checked') != 'undefined') {
                $("#submitButton").css('display', 'block');
            }
        }

        function submitForm() {

            var pseudoValue = $("#pseudo").val();
            var reasonValue = $("#reason").val();
            var sanctionTime = $("#time_form").find('[name=\"sanction_time\"]:checked').val();
            var selectedSanction = document.querySelectorAll('[name="sanction"]:checked').item(0).value;
            var specialSanctionTimeFilled = true;

            if (reasonValue == 'Sanction particulière') {
                sanctionTime = $("#sanction_time_5").val();
                console.log(selectedSanction);

                if(selectedSanction != 'Kick' && selectedSanction != 'Warn') {
                    if (sanctionTime == "" || sanctionTime == 'undefined') {
                        specialSanctionTimeFilled = false;
                    }
                }
            }

            if (specialSanctionTimeFilled == true) {
                if (pseudoValue != null && pseudoValue != '' && reasonValue != null && reasonValue != '' && sanctionTime != 'undefined' && sanctionTime != '') {
                    $.ajax({

                        type: "POST",

                        url: "/moderation/sanction-tx",

                        data: {
                            'sanction': document.querySelectorAll('[name="sanction"]:checked').item(0).value,
                            'pseudo': pseudoValue,
                            'reason': reasonValue,
                            'time': sanctionTime
                        },

                        success: function () {
                            toastr.success("Sanction enregistrée", "Succès !");
                        },

                        error: function (jqxhr, status, exception) {
                            toastr.error("Erreur lors de l'envoi, merci de contacter un administrateur. Intitulé de l'erreur : " + exception, 'Erreur');
                        }

                    });
                }

                else if (sanctionTime == 'undefined' || sanctionTime == null || sanctionTime == '') {
                    $.ajax({

                        type: "POST",

                        url: "/moderation/sanction-tx",

                        data: {
                            'sanction': document.querySelectorAll('[name="sanction"]:checked').item(0).value,
                            'pseudo': pseudoValue,
                            'reason': reasonValue
                        },

                        success: function () {
                            toastr.success("Sanction enregistrée", "Succès !");
                        },

                        error: function (jqxhr, status, exception) {
                            toastr.error("Erreur lors de l'envoi, merci de contacter un administrateur. Intitulé de l'erreur : " + exception, 'Erreur');
                        }

                    });
                }

                else {
                    toastr.error("Merci de compléter tout le formulaire", "Erreur !");
                }

            }

            else {
                toastr.error("Merci de compléter tout le formulaire", "Erreur !");
            }


        }

    </script>

@endsection
