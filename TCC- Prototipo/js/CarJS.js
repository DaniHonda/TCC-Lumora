window.document.getElementById("navigation");
function change(event) {
  let elemento = event.target.id;
  if (elemento == "menupizza") {
    event.target.classList.add("atual");
    document.getElementById("menunordestina").classList.remove("atual");
    document.getElementById("menupetiscos").classList.remove("atual");
    document.getElementById("menugostosa").classList.remove("atual"); 

    document.getElementById("pizza").style.display = "inline";
    document.getElementById("nordestina").style.display = "none";
    document.getElementById("petisco").style.display = "none";
    document.getElementById("gostosa").style.display = "none";
  }
  if (elemento == "menunordestina") {
    event.target.classList.add("atual");
    document.getElementById("menupizza").classList.remove("atual");
    document.getElementById("menupetiscos").classList.remove("atual");
    document.getElementById("menugostosa").classList.remove("atual"); 

    document.getElementById("nordestina").style.display = "inline";
    document.getElementById("pizza").style.display = "none";
    document.getElementById("petisco").style.display = "none";
    document.getElementById("gostosa").style.display = "none";
  }
  if (elemento == "menupetiscos") {
    event.target.classList.add("atual");
    document.getElementById("menupizza").classList.remove("atual");
   document.getElementById("menugostosa").classList.remove("atual"); 
   document.getElementById("menunordestina").classList.remove("atual");

    document.getElementById("petisco").style.display = "inline";
    document.getElementById("pizza").style.display = "none";
    document.getElementById("nordestina").style.display = "none";
    document.getElementById("gostosa").style.display = "none";
  }
if (elemento == "menugostosa") {
    event.target.classList.add("atual");
    document.getElementById("menupizza").classList.remove("atual");
   document.getElementById("menupetiscos").classList.remove("atual");
    document.getElementById("menunordestina").classList.remove("atual");

    document.getElementById("gostosa").style.display = "inline";
    document.getElementById("petisco").style.display = "none";
    document.getElementById("pizza").style.display = "none";
    document.getElementById("nordestina").style.display = "none";
    
  }
}
