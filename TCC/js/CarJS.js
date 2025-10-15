window.document.getElementById("navigation");
function change(event) {
  let elemento = event.target.id;

  // Esconde todas as seções do cardápio
  document.getElementById("pratoprincipal").style.display = "none";
  document.getElementById("acompanhamento").style.display = "none";
  document.getElementById("salada").style.display = "none";
  document.getElementById("sobremesa").style.display = "none";

  // Remove a classe 'atual' de todos os links do menu
  document.getElementById("menupratoprincipal").classList.remove("atual");
  document.getElementById("menuacompanhamento").classList.remove("atual");
  document.getElementById("menusalada").classList.remove("atual");
  document.getElementById("menusobremesa").classList.remove("atual");

  if (elemento == "menupratoprincipal") {
    event.target.classList.add("atual");
    document.getElementById("pratoprincipal").style.display = "inline";
  }
  if (elemento == "menuacompanhamento") {
    event.target.classList.add("atual");
    document.getElementById("acompanhamento").style.display = "inline";
  }
  if (elemento == "menusalada") {
    event.target.classList.add("atual");
    document.getElementById("salada").style.display = "inline";
  }
  if (elemento == "menusobremesa") {
    event.target.classList.add("atual");
    document.getElementById("sobremesa").style.display = "inline";
  }
}