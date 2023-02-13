<?php
class RepositoryManager{
    private $database;
    public $userRepository;
    public $salesRepository;
    public $authenticationRepository;
    public function __construct($dtbs)
    {   
        $this->database=$dtbs;
        $this->userRepository=new UserRepository($dtbs);
        $this->salesRepository=new SalesRepository($dtbs);
        $this->authenticationRepository=new AuthenticationReposiory($dtbs);
    }


}


?>