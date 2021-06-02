<?php namespace App\Controllers;

class Auth extends \IonAuth\Controllers\Auth
{
    protected $ionAuth;
    protected $viewsFolder = 'Views/auth';
    protected $google_client;

    public function __construct()
    {
        parent::__construct();
        $this->ionAuth = new IonAuthGoogle();
        $this->google_client = new GoogleClient();
    }

    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        for ($i = 0; $i < 8; $i++) {
            array_push($pass,$alphabet[rand(0, strlen($alphabet)-1)]);
        }
        return $pass;
    }

    public function google_login()
    {
        $code = $this->request->getVar('code');
        if(!empty($code)) {
            //Получение токена доступа от клиента Google API
            $token = $this->google_client->getGoogleClient()->fetchAccessTokenWithAuthCode($code);

            if (!isset($token["error"])) {
                $this->google_client->getGoogleClient()->setAccessToken($token['access_token']);
                $google_service = new Google_Service_Oauth2($this->google_client->getGoogleClient());
                $data = $google_service->userinfo->get();
                //Вызов функции аутентификации с полученным от Google API Google ID
                if ($this->ionAuth->loginGoogle($data['id'])) {
                    //if the login is successful
                    //redirect them back to the home page
                    $this->session->setFlashdata('message', $this->ionAuth->messages());
                    return redirect()->to('/')->withCookies();
                }
                else {
                    //если аутентификация не пройдена с полученным id, значит в таблице такого google_id еще нет и надо создать учетную запись
                    //для этого вызывается функция регистрации
                    $this->ionAuth->register($data['email'], $this->randomPassword(), $data['email'], ['google_id' => $data['id'],
                        'first_name' => $data['givenName'],
                        'last_name' => $data['familyName'],
                        'picture_url' => $data['picture'],
                        'locale' => $data['locale'],
                        'company' => $data['hd']
                    ], [1]);
                    //после создания учетной записи снова пытаемся выполнить логин
                    if ($this->ionAuth->loginGoogle($data['id'])) {
                        //if the login is successful
                        //redirect them back to the home page
                        $this->session->setFlashdata('message', $this->ionAuth->messages());
                        return redirect()->to('/')->withCookies();
                    }
                    else $this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));

                }
            }
        }
        return redirect()->back()->withInput();
    }

    protected function renderPage(string $view, $data = null, bool $returnHtml = true): string
    {
        $data['ionAuth'] = new IonAuth(); //Добавление в массив $data объекта IonAuth()
        $data['authUrl'] = $this->google_client->getGoogleClient()->createAuthUrl();

        $viewdata = $data ?: $this->data;
        $viewHtml = view($view, $viewdata);

        if ($returnHtml)
        {
            return $viewHtml;
        }
        else
        {
            echo $viewHtml;
        }
    }
    public function register_user()
    {
        $this->data['title'] = $this->lang->line('create_user_heading');
/*
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }
*/
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
        if ($identity_column !== 'email')
        {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() === TRUE)
        {
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = [
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
            ];
        }
        if ($this->form_validation->run() === TRUE && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = [
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            ];
            $this->data['last_name'] = [
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            ];
            $this->data['identity'] = [
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            ];
            $this->data['email'] = [
                'name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'value' => $this->form_validation->set_value('email'),
            ];
            $this->data['company'] = [
                'name' => 'company',
                'id' => 'company',
                'type' => 'text',
                'value' => $this->form_validation->set_value('company'),
            ];
            $this->data['phone'] = [
                'name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'value' => $this->form_validation->set_value('phone'),
            ];
            $this->data['password'] = [
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password'),
            ];
            $this->data['password_confirm'] = [
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            ];
            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'create_user', $this->data);

        }
    }
    /*protected $viewsFolder = 'auth';*/
}