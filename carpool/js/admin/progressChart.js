document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById("progressChart").getContext("2d");
    let progress = 0; 
    
    const chart = new Chart(ctx, {
        type: "doughnut",
        data: {
            datasets: [{
                data: [progress, 100 - progress],
                backgroundColor: ["#2b8dff", "#333"],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutout: "80%",
            animation: false,
            plugins: { legend: { display: false } }
        }
    });

    function animateProgress() {
        let interval = setInterval(() => {
            if (progress >= 75) {
                clearInterval(interval);
            } else {
                progress += 1;
                chart.data.datasets[0].data = [progress, 100 - progress];
                chart.update();
            }
        }, 20);
    }

    animateProgress();
});

document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById("progressChart2").getContext("2d");
    let progress = 0; 
    
    const chart = new Chart(ctx, {
        type: "doughnut",
        data: {
            datasets: [{
                data: [progress, 100 - progress],
                backgroundColor: ["#ff8c00", "#333"],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutout: "80%",
            animation: false,
            plugins: { legend: { display: false } }
        }
    });

    function animateProgress() {
        let interval = setInterval(() => {
            if (progress >= 75) {
                clearInterval(interval);
            } else {
                progress += 1;
                chart.data.datasets[0].data = [progress, 100 - progress];
                chart.update();
            }
        }, 20);
    }

    animateProgress();
});

document.addEventListener("DOMContentLoaded", function () {
    fetchTopRoutes();
});

function fetchTopRoutes() {
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth() + 1;

    fetch(`../php/admin/generatePopularRoutes.php?year=${currentYear}&month=${currentMonth}`)
        .then(response => response.json())
        .then(data => {
            if (!data || data.length === 0) {
                document.getElementById("top-1-name").innerText = "No data available";
                document.getElementById("top-2-name").innerText = "No data available";
                document.getElementById("top-1-number").innerText = "-";
                document.getElementById("top-2-number").innerText = "-";
                return;
            }

            // Sort data in descending order based on count
            data.sort((a, b) => b.count - a.count);

            // Get top 2 routes
            const top1 = data[0] || { route: "N/A", count: 0 };
            const top2 = data[1] || { route: "N/A", count: 0 };

            // Update the UI
            document.getElementById("top-1-name").innerText = top1.route;
            document.getElementById("top-1-number").innerText = `${top1.count} Rides`;
            document.getElementById("top-2-name").innerText = top2.route;
            document.getElementById("top-2-number").innerText = `${top2.count} Rides`;
        })
        .catch(error => console.error("Error fetching top routes:", error));
}
