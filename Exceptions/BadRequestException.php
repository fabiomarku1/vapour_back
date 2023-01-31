<?php

 class BadRequestException extends Exception
{
    function __construct(string $message) 
    {
        parent::__construct($message,code:400);
    }
}



?>