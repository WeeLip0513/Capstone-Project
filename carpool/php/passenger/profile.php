<?php
include("../dbconn.php");

function getProfileDetails($userID,$conn){
$sql = "SELECT 
            p.id AS passengerID, 
            p.firstname, p.lastname, p.phone_no, u.email,
            p.registration_date 
        FROM passenger p 
        JOIN user u ON p.user_id = u.id 
        WHERE p.user_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
}else{
    return null;
}
    
//     $_SESSION['passengerID'] = $passenger['passengerID'];

// \    echo "<div class='profile-card'>
//             <h2 style='font-size:30px;'>My Profile</h2>
//             <div class='profiledetails'>
//                 <div class='profilerow'>
//                     <div class='firstname'>
//                         <h3><strong>First Name:</strong></h3>
//                         <p>{$passenger['firstname']}</p>
//                     </div>
//                     <div class='lastname'>    
//                         <h3><strong>Last Name:</strong></h3>
//                         <p>{$passenger['lastname']}</p>
//                     </div>
//                 </div>
//                 <div class='profilerow'>
//                     <div class='phone'>
//                         <h3><strong>Phone:</strong></h3>
//                         <p>{$passenger['phone_no']}</p>
//                     </div>
//                     <div class='email'>
//                         <h3><strong>Email:</strong></h3> 
//                         <p>{$passenger['email']}</p>
//                     </div>
//                 </div>
//                 <div class='profilerow'>
//                     <div class='password'>
//                         <h3><strong>Reset Password:</strong></h3>
//                         <a href='#'><button class='forgot'>Reset Password</button></a>
//                     </div>
//                     <div class='regdate'>
//                         <h3><strong>Registered Date:</strong></h3> 
//                         <p>{$passenger['registration_date']}</p>   
//                     </div>
//                 </div>
//             </div>
//           </div>";
// } else {
//     echo "<p>No passenger record found!</p>";
// }
}
?>