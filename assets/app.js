import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
/* assets/app.js */

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
// import '@fortawesome/fontawesome-free/css/all.min.css';


// ==========================================
// 1. IMPORTS ET CONFIGURATION GLOBALE
// ==========================================
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// 2. Importer DataTables
import DataTable from 'datatables.net';
import 'datatables.net-dt'; // <-- Import propre géré par AssetMapper

// (Optionnel si vous utilisez fixedHeader)
// import 'datatables.net-fixedheader-dt';

// ==========================================
// 6. INITIALISATION DATATABLES
// ==========================================
const frTranslation = {
    emptyTable: "Aucune donnée disponible dans le tableau",
    info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
    infoEmpty: "Affichage de 0 à 0 sur 0 entrée",
    infoFiltered: "(filtré de _MAX_ entrées au total)",
    lengthMenu: "Afficher _MENU_ entrées",
    loadingRecords: "Chargement...",
    processing: "Traitement...",
    search: "Rechercher :",
    zeroRecords: "Aucun élément correspondant trouvé",
    paginate: {
        first: "Premier",
        last: "Dernier",
        next: "Suivant",
        previous: "Précédent"
    },
    aria: {
        sortAscending: ": activer pour trier la colonne par ordre croissant",
        sortDescending: ": activer pour trier la colonne par ordre décroissant"
    }
};

$(document).ready(function () {
    const table = $('#tableactif');

    if (table.length) {
        new DataTable('#tableactif', {
            pageLength: 25,
            order: [[0, 'desc']],
            fixedHeader: true,
            language: frTranslation
        });
    }
});

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
