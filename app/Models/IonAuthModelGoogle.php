<?php

namespace App\Models;

use IonAuth\Models\IonAuthModel;

class IonAuthModelGoogle extends IonAuthModel
{
    protected $googleIdColumn = 'google_id';
    public function loginGoogle(string $google_id, bool $remember=true): bool
    {
        $this->triggerEvents('pre_login');

        if (empty($google_id))
        {
            $this->setError('IonAuth.login_unsuccessful');
            return false;
        }

        $this->triggerEvents('extra_where');
        $query = $this->db->table($this->tables['users'])
            ->select($this->googleIdColumn . ', email, id, password, active, last_login')
            ->where($this->googleIdColumn, $google_id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->get();
        $user = $query->getRow();
        //Если пользователь с необходиммым google_id найден
        if (isset($user))
        {
            if ($user->active == 0)
            {
                $this->triggerEvents('post_login_unsuccessful');
                $this->setError('IonAuth.login_unsuccessful_not_active');
                return false;
            }
            $this->setSession($user);
            $this->updateLastLogin($user->id);
            // Regenerate the session (for security purpose: to avoid session fixation)
            $this->session->regenerate(false);

            $this->triggerEvents(['post_login', 'post_login_successful']);
            $this->setMessage('IonAuth.login_successful');

            return true;
        }
        $this->triggerEvents('post_login_unsuccessful');
        $this->setError('IonAuth.login_unsuccessful');
        return false;
    }

}