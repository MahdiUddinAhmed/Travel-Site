document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("flightForm");
    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission behavior
        const formData = new FormData(form);
        fetch("API/fetch_flights.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("results").innerHTML = data; // Display the PHP output in the results div
        })
        .catch(error => console.error("Error:", error));
    });
});


