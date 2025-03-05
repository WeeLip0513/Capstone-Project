import fetch from 'node-fetch';

const API_URL = "http://localhost/Capstone_Project/carpool/php/driver/checkMultipleRideConflicts.php"; // Adjust to match your setup

const requestData = {
    date: "2025-03-03",          // Test ride date
    time: "09:00",               // Test ride time
    pick_up_point: "Station A",  // Test pickup point
    drop_off_point: "Station B"  // Test drop-off point
};

async function testRideConflictAPI() {
    try {
        const response = await fetch(API_URL, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(requestData)
        });

        const textResponse = await response.text();
        console.log("🔹 Raw Response from PHP:\n", textResponse);

        const jsonResponse = JSON.parse(textResponse);
        console.log("✅ Parsed JSON Response:\n", JSON.stringify(jsonResponse, null, 2));

    } catch (error) {
        console.error("❌ Error:", error);
    }
}

testRideConflictAPI();
