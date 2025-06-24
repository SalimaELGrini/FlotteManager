function calculerValeurs() {
    var fuel_added = parseFloat(document.getElementById('fuel_added').value) || 0;
    var prix_litre = parseFloat(document.getElementById('fuel_price_per_liter').value) || 0;
    var distance = parseFloat(document.getElementById('distance_parcourue').value) || 0;

    var total = fuel_added * prix_litre;
    document.getElementById('total_cost').value = total.toFixed(2);

    if(fuel_added > 0) {
        var efficacite = distance / fuel_added;
        document.getElementById('fuel_efficiency').value = efficacite.toFixed(2);
    } else {
        document.getElementById('fuel_efficiency').value = 0;
    }
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('fuel_added').addEventListener('input', calculerValeurs);
    document.getElementById('fuel_price_per_liter').addEventListener('input', calculerValeurs);
    document.getElementById('distance_parcourue').addEventListener('input', calculerValeurs);
});
