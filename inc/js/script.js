document.addEventListener("DOMContentLoaded", () => {
  console.log("Page chargée");
});

document.addEventListener("click", (e) => {
  if (e.target.getAttribute("id")) {
    tab = e.target.getAttribute("id").split("-");
    stock = parseFloat(document.getElementById(`stock-${tab[1]}`).textContent);
    quantite = parseFloat(document.getElementById(tab[1]).value);
    if (tab[0] == "moins") {
      if (quantite != 0) {
        quantite--;
        document.getElementById(tab[1]).value = quantite;
      }
    } else if (tab[0] == "plus") {
      if (quantite != stock) {
        quantite++;
        document.getElementById(tab[1]).value = quantite;
      }
    }
    console.log("stock", stock);
    console.log("quantite", quantite);
  }
});
