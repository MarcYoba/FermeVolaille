function magasin() {
  // Récupérer l'input et la liste déroulante
  var input, filter, ul, li, a, i;
  input = document.getElementById("recherche");
  filter = input.value.toUpperCase();
  ul = document.getElementById("magasin_produit");
  li = ul.getElementsByTagName("option");
 
  // Boucler sur toutes les options
  for (i = 0; i < li.length; i++) {
    a = li[i];
    if (a.textContent.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
      li[i].style.display = "none";
    }
  }
  
}

function Achat() {
  // Récupérer l'input et la liste déroulante
  var input, filter, ul, li, a, i;
  input = document.getElementById("recherche");
  filter = input.value.toUpperCase();
  ul = document.getElementById("achat_produit");
  li = ul.getElementsByTagName("option");
 
  // Boucler sur toutes les options
  for (i = 0; i < li.length; i++) {
    a = li[i];
    if (a.textContent.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
      li[i].style.display = "none";
    }
  }
  
}

function Inventaire() {
  // Récupérer l'input et la liste déroulante
  var input, filter, ul, li, a, i;
  input = document.getElementById("inventaire_recherche");
  filter = input.value.toUpperCase();
  ul = document.getElementById("inventaire_produit");
  li = ul.getElementsByTagName("option");
 
  // Boucler sur toutes les options
  for (i = 0; i < li.length; i++) {
    a = li[i];
    if (a.textContent.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
      li[i].style.display = "none";
    }
  }
  
}