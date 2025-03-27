//calculate user function
document.addEventListener("DOMContentLoaded", function () {
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth() + 1;
    const previousYear = currentMonth === 1 ? currentYear - 1 : currentYear;
    const previousMonth = currentMonth === 1 ? 12 : currentMonth - 1;

    async function fetchUserData(year, month) {
        try {
            const response = await fetch(`../php/admin/generateUserReport.php?year=${year}&month=${month}`);
            const data = await response.json();
            console.log(`Data for ${year}-${month}:`, data); // Debugging
            return data || { passengers: [], drivers: [] };
        } catch (error) {
            console.error("Error fetching user data:", error);
            return { passengers: [], drivers: [] };
        }
    }

    function getTotalCount(dataArray) {
        return Array.isArray(dataArray) ? dataArray.reduce((a, b) => a + b, 0) : 0;
    }

    function updateUI(data, previousData) {
        const newUsers = getTotalCount(data.passengers) + getTotalCount(data.drivers);
        const newDrivers = getTotalCount(data.drivers);
        const newPassengers = getTotalCount(data.passengers);

        document.getElementById("new-users").innerHTML = newUsers;
        document.getElementById("new-drivers").innerHTML = newDrivers;
        document.getElementById("new-passengers").innerHTML = newPassengers;

        document.getElementById("percentage-users").innerHTML = getComparisonHtml(newUsers, previousData.newUsers);
        document.getElementById("percentage-drivers").innerHTML = getComparisonHtml(newDrivers, previousData.newDrivers);
        document.getElementById("percentage-passengers").innerHTML = getComparisonHtml(newPassengers, previousData.newPassengers);
    }

function getComparisonHtml(current, previous) {
    if (previous === 0) return "<br><span style='color: gray; font-size: 14px;'>No Data</span>";
    const difference = current - previous;
    let percentage = ((difference / previous) * 100).toFixed(2);

    const sign = difference >= 0 ? "+" : "";
    const arrow = difference >= 0 ? "▲" : "▼";
    const color = difference >= 0 ? "rgb(6, 251, 63)" : "red";
    
    return `<strong><span style='color: ${color}; font-size: 14px;'>${sign}${percentage}% &nbsp&nbsp${arrow}</span></strong>`;
}


    async function loadData() {
        const currentData = await fetchUserData(currentYear, currentMonth);
        const previousData = await fetchUserData(previousYear, previousMonth);

        const previousUsers = getTotalCount(previousData.passengers) + getTotalCount(previousData.drivers);
        const previousDrivers = getTotalCount(previousData.drivers);
        const previousPassengers = getTotalCount(previousData.passengers);

        updateUI(currentData, {
            newUsers: previousUsers,
            newDrivers: previousDrivers,
            newPassengers: previousPassengers
        });
    }

    loadData();
});

//calculate rides function
document.addEventListener("DOMContentLoaded", function () {
    async function fetchTotalRides() {
        try {
            const response = await fetch("../php/admin/getTotalRides.php");
            const data = await response.json();
            console.log("Ride Data:", data); // Debugging

            const totalRides = data.currentRides;
            const previousRides = data.previousRides;

            document.getElementById("total-rides").innerHTML = totalRides;
            document.getElementById("percentage-rides").innerHTML = getComparisonHtml(totalRides, previousRides);
        } catch (error) {
            console.error("Error fetching total rides:", error);
        }
    }

    function getComparisonHtml(current, previous) {
        if (previous === 0) return "<br><span style='color: gray; font-size: 14px;'>No Data</span>";
        
        const difference = current - previous;
        let percentage = ((difference / previous) * 100).toFixed(2);

        const sign = difference >= 0 ? "+" : "";
        const arrow = difference >= 0 ? "▲" : "▼";
        const color = difference >= 0 ? "rgb(6, 251, 63)" : "red";
        
        return `<strong><span style='color: ${color}; font-size: 14px;'>${sign}${percentage}% &nbsp&nbsp${arrow}</span></strong>`;
    }

    fetchTotalRides();
});

document.addEventListener("DOMContentLoaded", async function () {
    async function fetchMonthlyEarnings() {
        try {
            const response = await fetch("../php/admin/getMonthlyEarnings.php");
            const data = await response.json();
            console.log("Earnings Data:", data); // Debugging
            return data || { driverRevenue: 0, appRevenue: 0 };
        } catch (error) {
            console.error("Error fetching earnings data:", error);
            return { driverRevenue: 0, appRevenue: 0 };
        }
    }

    function generateChart(driverRevenue, appRevenue) {
        // Convert to numbers to avoid NaN
        const totalRevenue = Number(driverRevenue) + Number(appRevenue);
        const driverPercentage = totalRevenue ? ((Number(driverRevenue) / totalRevenue) * 100).toFixed(1) : 0;
        const appPercentage = totalRevenue ? ((Number(appRevenue) / totalRevenue) * 100).toFixed(1) : 0;

        // Update earnings-label with labels
        document.getElementById("earnings-label").innerHTML = `
            <p><i class="far fa-circle" style="font-size:20px;color:#2e80f2;"></i> Driver Revenue</p>
            <p><i class="far fa-circle" style="font-size:20px;color:rgb(236, 66, 4);"></i> App Revenue</p>
        `;

        // Update earnings-percentage with percentage values
        document.getElementById("earnings-percentage").innerHTML = `
            <p>${driverPercentage}%</p>
            <p>${appPercentage}%</p>
        `;

        const ctx = document.getElementById("earnings-chart").getContext("2d");

        new Chart(ctx, {
            type: "doughnut",
            data: {
                datasets: [
                    {
                        data: [driverRevenue, appRevenue],
                        backgroundColor: ["#2e80f2", "rgb(236, 66, 4)"], // Colors
                        hoverOffset: 5,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            color: "#fff",
                        },
                    },
                },
                cutout: "87%", // Hollow center
            },
            plugins: [
                {
                    id: "centerText",
                    beforeDraw: function (chart) {
                        const { width, height } = chart;
                        const ctx = chart.ctx;
                        ctx.restore();
                        ctx.font = "bold 18px sans-serif";
                        ctx.fillStyle = "#fff";
                        ctx.textAlign = "center";
                        ctx.textBaseline = "middle";
                        ctx.fillText("Earnings", width / 2, height / 2);
                        ctx.save();
                    },
                },
            ],
        });
    }

    async function loadEarningsChart() {
        const { driverRevenue, appRevenue } = await fetchMonthlyEarnings();
        generateChart(driverRevenue, appRevenue);
    }

    loadEarningsChart();
});

