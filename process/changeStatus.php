<?php
require '../core/init.php';
require '../core/classes/SecureMessagingAndCommunication.php';

if (!$userObj->isLoggedIn()) {
    $userObj->redirect('login.php');
}
$output = "";
$user2 = $userObj->getuser();
foreach ($user2 as $doctors){

    $output .='<a href="chatprofile.php?uname='.$doctors->username.'" style="text-decoration: none">
                     <li style="cursor:pointer;">
                          <div class="card border-0" id="myTable" style="margin: 5px;border-radius: 20px;">
                              <div class="card-body chat-card">
                                  <h6 class="text-nowrap text-truncate card-title"><img src="'.$doctors->profile_photo.'" width="48" height="47" style="width: 46px;height: 46px;border-radius: 25px;">&nbsp; &nbsp;  '.$doctors->firstname." ".$doctors->lastname.'</h6>
                                  <div class="status-dot" style="display: flex">
                                      <i class="fa-solid fa-circle"></i>
                                  </div>
                              </div>
                          </div>
                     </li>
                 </a>';
}