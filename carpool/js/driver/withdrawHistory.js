document.addEventListener("DOMContentLoaded", function () {
  const monthSelect = document.getElementById("hisMonth");
  const withdrawHistory = document.getElementById("withdrawHistory");

  // Create pagination div and set its ID
  const paginationDiv = document.createElement("div");
  paginationDiv.id = "paginationControls"; // Set ID for styling
  withdrawHistory.after(paginationDiv); // Insert pagination below table

  const monthNames = {
    "jan": "January", "feb": "February", "mar": "March", "apr": "April",
    "may": "May", "jun": "June", "jul": "July", "aug": "August",
    "sep": "September", "oct": "October", "nov": "November", "dec": "December"
  };

  let currentPage = 1;
  let rowsPerPage = 7;
  let withdrawData = []; // Store fetched data

  function fetchWithdrawData(month) {
    fetch(`../php/driver/withdrawData.php?month=${month}`)
      .then(response => response.json())
      .then(data => {
        withdrawData = data; // Store full dataset
        currentPage = 1; // Reset to first page
        displayWithdrawData(month);
      })
      .catch(error => {
        console.error("Error fetching withdrawal data:", error);
        withdrawHistory.innerHTML = "<p style='color:red;'>Failed to load withdrawal history.</p>";
        paginationDiv.innerHTML = ""; // Clear pagination if error
      });
  }

  function displayWithdrawData(month) {
    withdrawHistory.innerHTML = ""; // Clear previous content
    paginationDiv.innerHTML = ""; // Clear previous pagination

    // Table structure with headers
    let tableHTML = `<table border="1">
                      <tr>
                        <th>Date</th>
                        <th>Bank</th>
                        <th>Account Number</th>
                        <th>Name</th>
                        <th>Amount (RM)</th>
                      </tr>`;

    // If no records exist, show a "No record found" row
    if (!withdrawData || withdrawData.length === 0) {
      tableHTML += `<tr><td colspan="5" style="text-align: center; color:white ;">No record found for ${monthNames[month]}</td></tr>`;
    } else {
      // Calculate pagination
      let start = (currentPage - 1) * rowsPerPage;
      let end = start + rowsPerPage;
      let paginatedData = withdrawData.slice(start, end);

      paginatedData.forEach(item => {
        tableHTML += `<tr>
                        <td>${item.withdraw_date}</td>
                        <td>${item.bank}</td>
                        <td>${item.account_number}</td>
                        <td>${item.name}</td>
                        <td>${item.amount}</td>
                      </tr>`;
      });
    }

    tableHTML += `</table>`;
    withdrawHistory.innerHTML = tableHTML;

    // Update pagination buttons
    updatePaginationControls(month);
  }

  function updatePaginationControls(month) {
    let totalPages = Math.ceil(withdrawData.length / rowsPerPage);
    paginationDiv.innerHTML = ""; // Clear previous buttons

    if (withdrawData.length > 0 && totalPages > 1) {
      let prevButton = document.createElement("button");
      prevButton.innerText = "Previous";
      prevButton.disabled = currentPage === 1;
      prevButton.addEventListener("click", function () {
        if (currentPage > 1) {
          currentPage--;
          displayWithdrawData(month);
        }
      });

      let nextButton = document.createElement("button");
      nextButton.innerText = "Next";
      nextButton.disabled = currentPage === totalPages;
      nextButton.addEventListener("click", function () {
        if (currentPage < totalPages) {
          currentPage++;
          displayWithdrawData(month);
        }
      });

      let pageInfo = document.createElement("span");
      // pageInfo.innerText = ` Page ${currentPage} of ${totalPages} `;

      paginationDiv.appendChild(prevButton);
      paginationDiv.appendChild(pageInfo);
      paginationDiv.appendChild(nextButton);
    }
  }

  // Set current month as selected and fetch data
  const currentDate = new Date();
  const currentMonthIndex = currentDate.getMonth(); // Get index (0-11)
  const currentMonthKey = Object.keys(monthNames)[currentMonthIndex]; // Get short month name

  console.log(currentMonthKey);

  monthSelect.value = currentMonthKey;
  fetchWithdrawData(currentMonthKey);

  // Event listener to fetch data when month is changed
  monthSelect.addEventListener("change", function () {
    fetchWithdrawData(this.value);
  });
});
