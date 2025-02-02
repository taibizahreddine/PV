    <!-- Inclure ce script JavaScript dans la partie <head> de votre HTML -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var nomModuleSelect = document.getElementById("nouveau_Nom_module");
        var coefficientInput = document.getElementById("nouveau_coefficient");
        var codeModuleInput = document.getElementById("nouveau_code_module");
    
        nomModuleSelect.addEventListener("change", function () {
            var selectedModule = nomModuleSelect.value;
            var selectedFiliere = document.querySelector('input[name="nouvelle_fil"]').value;
    
            // Faites une requête Ajax pour récupérer le coefficient et le code du module depuis le serveur
            // Assurez-vous que votre script PHP gère cette requête et renvoie les données correctement
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "votre_script_php.php?module=" + selectedModule + "&filiere=" + selectedFiliere, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    coefficientInput.value = data.coefficient;
                    codeModuleInput.value = data.code_module;
                }
            };
            xhr.send();
        });
    });
    </script>
    ,,,,,,,,,,,,,,
    <!-- Ajoutez ceci à votre formulaire HTML -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sélectionnez le menu déroulant pour le module
        const moduleDropdown = document.querySelector('select[name="nouveau_Nom_module"]');
        
        // Écoutez l'événement de changement sur le menu déroulant
        moduleDropdown.addEventListener('change', function() {
            // Récupérez la valeur du module sélectionné
            const selectedModule = moduleDropdown.value;
            
            // Envoyez une requête AJAX pour obtenir les détails du module
            fetch('get_module_details.php?module=' + selectedModule)
                .then(response => response.json())
                .then(data => {
                    // Mettez à jour les champs de code du module et de coefficient
                    document.querySelector('input[name="nouveau_code_module"]').value = data.code;
                    document.querySelector('input[name="nouveau_coefficient"]').value = data.coefficient;
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des détails du module : ' + error);
                });
        });
    });
    </script>
    