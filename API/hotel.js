document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("hotelForm");
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(form);
        fetch("API/fetch_hotels.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("results").innerHTML = data;
        })
        .catch(error => console.error("Error:", error));
    });
});