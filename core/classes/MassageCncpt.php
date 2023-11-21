<?php

namespace MyApp;

class MassageCncpt
{
    public function setWarningMassage($msg)
    {
        echo '<div class="alert alert-warning" role="alert" style="text-align: center;margin-left: 35vw;margin-right: 35vw;margin-top: 2vw;background: rgba(255, 218, 71, 0.4);border: none">';
        echo $msg.'</div>';
    }
    public function setErrorMassage($msg)
    {
        echo '<div class="alert alert-danger" role="alert" style="text-align: center;margin-left: 35vw;margin-right: 35vw;margin-top: 2vw;background: rgba(255, 99, 71, 0.5);border: none">';
        echo $msg.'</div>';;
    }
    public function setSuccessMassage($msg)
    {
        echo '<div class="alert alert-success" role="alert" style="text-align: center;margin-left: 35vw;margin-right: 35vw;margin-top: 2vw;background: rgba(102, 255, 39, 0.3);border: none">';
        echo $msg. '</div>';;
    }

}