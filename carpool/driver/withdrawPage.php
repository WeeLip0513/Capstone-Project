<?php
session_start();
include("../rideHeader.php");

$balance = $_GET['balance'];
// $balance = 123;
$month = $_GET['month'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Withdraw Funds</title>
  <link rel="stylesheet" href="../css/driverPage/withdrawPage.css">
  <script src="../js/driver/withdrawValidation.js" defer></script>
</head>

<body>
  <div id="withdrawContainer" class="withdrawContainer">
    <h2 class="center">Withdraw Request</h2>
    <form id="withdrawForm" action="withdraw.php" method="POST" novalidate>
      <input type="hidden" name="month" value="<?php echo htmlspecialchars($month); ?>">
      <table>
        <tr>
          <td><label for="bank">Select Bank:</label></td>
          <td>
            <select name="bank" id="bank" required>
              <option value="" disabled selected>-- Choose Bank --</option>
              <option value="Maybank">Maybank</option>
              <option value="CIMB Bank">CIMB Bank</option>
              <option value="Public Bank">Public Bank</option>
              <option value="RHB Bank">RHB Bank</option>
              <option value="Hong Leong Bank">Hong Leong Bank</option>
              <option value="AmBank">AmBank</option>
              <option value="Bank Islam">Bank Islam</option>
              <option value="Bank Rakyat">Bank Rakyat</option>
              <option value="UOB Malaysia">UOB Malaysia</option>
            </select>
            <span id="bankError" class="error"></span>
          </td>
        </tr>
        <tr>
          <td><label for="accountName">Account Holder Name:</label></td>
          <td>
            <input type="text" name="accountName" id="accountName" required>
            <span id="nameError" class="error"></span>
          </td>
        </tr>
        <tr>
          <td><label for="accountNumber">Account Number:</label></td>
          <td>
            <input type="text" name="accountNumber" id="accountNumber" pattern="\d{10,16}"
              title="Enter a valid account number (10-16 digits)" required>
            <span id="accountError" class="error"></span>
          </td>
        </tr>
        <tr>
          <td><label for="withdrawAmount">Withdraw Amount(RM):</label></td>
          <td>
            <input class="balance" type="number" name="withdrawAmount" id="withdrawAmount"
              value="<?php echo $balance ?>" readonly required>
            <span id="amountError" class="error"></span>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="center">
            <div class="buttonWrap">
              <button id="backBtn">Back</button>
              <button type="submit" id="submitBtn">Withdraw</button>
            </div>
          </td>
        </tr>
      </table>
    </form>
  </div>
  <div class="message" id="message">

  </div>
</body>

</html>