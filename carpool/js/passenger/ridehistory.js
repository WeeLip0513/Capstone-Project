function getLocationName(location) {
    const locationMapping = {
        'apu': 'APU (Asia Pacific University)',
        'sri_petaling': 'Sri Petaling',
        'lrt_bukit_jalil': 'LRT Bukit Jalil',
        'pav_bukit_jalil': 'Pavilion Bukit Jalil',
        'completed': 'Completed',
        'canceled': 'Refunded'
    };

    return locationMapping[location] || location.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
}

function fetchRides() {
    const container = document.getElementById('ridesContainer');

    // Add loading spinner
    // container.innerHTML = `
    //     <div class="loading" style="text-align: center; padding: 50px;">
    //         <div class="spinner" style="width: 50px; height: 50px; border: 4px solid #333; border-top: 4px solid #4a90e2; border-radius: 50%; animation: spin 1s linear infinite;">
    //         </div>
    //         <p style="color: #a0a0a0; margin-top: 15px;">Loading your ride history...</p>
    //     </div>
    // `;


    fetch('../php/passenger/ridehistory.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success' && data.rides.length > 0) {
                let tableHtml = `
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Pick Up Location</th>
                                <th>Drop Off Location</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                `;
                data.rides.forEach(ride => {
                    const pickUpLocation = getLocationName(ride.pick_up_point);
                    const dropOffLocation = getLocationName(ride.drop_off_point);
                    const rideStatus = getLocationName(ride.ride_status); // ✅ Fix: use ride.ride_status
                
                    tableHtml += `
                        <tr>
                            <td>${pickUpLocation}</td>
                            <td>${dropOffLocation}</td>
                            <td>${ride.date}</td>
                            <td>${ride.time}</td>
                            <td>RM ${parseFloat(ride.price).toFixed(2)}</td>
                            <td><span class="status-completed">${rideStatus}</span></td>
                        </tr>
                    `;
                });
                tableHtml += '</tbody></table>';
                container.innerHTML = tableHtml;
            } else {
                container.innerHTML = `
                    <div class="empty-state">
                        <h3>No Ride History</h3>
                        <p>You haven't taken any rides yet. Book your first ride now!</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            container.innerHTML = `
                <div class="empty-state" style="background-color: #2c2c2c; color: #ff6b6b;">
                    <h3>Error Loading Rides</h3>
                    <p>Unable to fetch ride history. Please try again later.</p>
                </div>
            `;
            console.error('Ride history fetch error:', error);
        });
}

document.addEventListener('DOMContentLoaded', fetchRides);

// Add spin animation for loading
// const styleSheet = document.createElement('style');
// styleSheet.textContent = `
//     @keyframes spin {
//         0% { transform: rotate(0deg); }
//         100% { transform: rotate(360deg); }
//     }
// `;
// document.head.appendChild(styleSheet);