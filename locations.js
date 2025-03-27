document.addEventListener("DOMContentLoaded", function () {
    const countrySelect = document.getElementById("country");
    const citySelect = document.getElementById("city");

    // Fetch countries from the REST API
    async function fetchCountries() {
        try {
            let response = await fetch("https://restcountries.com/v3.1/all");
            let data = await response.json();

            data.sort((a, b) => a.name.common.localeCompare(b.name.common)); // Sort alphabetically

            data.forEach(country => {
                let option = document.createElement("option");
                option.value = country.name.common;
                option.textContent = country.name.common;
                countrySelect.appendChild(option);
            });
        } catch (error) {
            console.error("Error fetching countries:", error);
        }
    }

    // Fetch cities based on selected country
    async function fetchCities(country) {
        citySelect.innerHTML = '<option value="">Loading...</option>'; // Show loading message

        try {
            let response = await fetch(`https://countriesnow.space/api/v0.1/countries/cities`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ country: country })
            });
            let data = await response.json();

            citySelect.innerHTML = '<option value="">Select City</option>'; // Reset options
            if (data.data) {
                data.data.forEach(city => {
                    let option = document.createElement("option");
                    option.value = city;
                    option.textContent = city;
                    citySelect.appendChild(option);
                });
            }
        } catch (error) {
            console.error("Error fetching cities:", error);
        }
    }

    // Event listener: When country changes, fetch cities
    countrySelect.addEventListener("change", function () {
        let selectedCountry = countrySelect.value;
        if (selectedCountry) {
            fetchCities(selectedCountry);
        } else {
            citySelect.innerHTML = '<option value="">Select City</option>';
        }
    });

    // Load countries on page load
    fetchCountries();
});
