<div class="historyTable" id="historyContainer">
        <h1>Add Rides From Previous Activities</h1>
        <table class="rideHistory">
          <thead>
            <tr>
              <td colspan=""></td>
            </tr>
            <tr>
              <!-- <th></th> -->
              <th>Select</th>
              <th>Day</th>
              <th>Time</th>
              <th>Pick-Up</th>
              <th>Drop-Off</th>
              <th>Slots</th>
              <!-- <th></th> -->
            </tr>
          </thead>
          <tbody>
            <!-- Centered Divider after Header -->
            <tr class="divider-row">
              <td colspan="6">
                <div class="centered-line"></div>
              </td>
            </tr>
            <?php
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td><input type='checkbox' class='rideCheckbox' value='{$row['id']}' data-ride='" . json_encode($row) . "'></td>
                        <td>{$row['day']}</td>
                        <td>{$row['formatted_time']}</td>
                        <td>{$row['pick_up_point']}</td>
                        <td>{$row['drop_off_point']}</td>
                        <td class = 'historySlots'>{$row['slots_available']}</td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='8'>No rides found from the previous week</td></tr>";
            }
            ?>
            <!-- Centered Divider before Button -->
            <tr class="divider-row">
              <td colspan="6">
                <div class="centered-line"></div>
              </td>
            </tr>
            <tr>
              <td colspan="6" style="text-align: center;">
                <button class="addSelectBtn" onclick="addSelectedRides()">Create Selected Rides</button>
              </td>
            </tr>
            <tr>
              <td colspan="10"></td>
            </tr>
          </tbody>
        </table>

      </div>

how to make the table to show only 7 line at a time and the leftover line will be show in the other page of the table