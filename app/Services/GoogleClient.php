<?php namespace App\Services;

use Google_Client;

class GoogleClient
{
    private $google_client;
    public function __construct()
    {
        $this->google_client = new Google_Client();
        $this->google_client->setClientId('117124251898-l2v7neofsc4d8qfl0cbgmk0mipueevcp.apps.googleusercontent.com');
        $this->google_client->setClientSecret('nEs7iS*************Ntc');
        $this->google_client->setRedirectUri(base_url().'/auth/google_login');
        $this->google_client->addScope('email');
        $this->google_client->addScope('profile');
    }
    public function getGoogleClient()
    {
        return $this->google_client;
    }

}