<?php

function setFlashDataSuccess($msg)
{
    return session()->setFlashdata("success", $msg);
}

function setFlashDataError($msg)
{
    return session()->setFlashdata("error", $msg);
}
