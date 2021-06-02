<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class Pages extends BaseController
{
    public function index()
    {
        return view('welcome_message', $this->withIon());
    }
    public function view($page = 'main')
    {
        if ( ! is_file(APPPATH.'/Views/pages/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
        echo view('pages/'.$page, $this->withIon());
    }
    public function getIngridientWithUser($id = null)
    {
        $builder = $this->select('*')->join('users','ingridient.user_id = users.id');
        if (!is_null($id))
        {
            return $builder->where(['ingridient.id' => $id])->first();
        }
        return $builder;
    }
    public function viewAllWithUsers()
    {
        if ($this->ionAuth->isAdmin())
        {
            //Подготовка значения количества элементов выводимых на одной странице
            if (!is_null($this->request->getPost('per_page'))) //если кол-во на странице есть в запросе
            {
                //сохранение кол-ва страниц в переменной сессии
                session()->setFlashdata('per_page', $this->request->getPost('per_page'));
                $per_page = $this->request->getPost('per_page');
            }
            else {
                $per_page = session()->getFlashdata('per_page');
                session()->setFlashdata('per_page', $per_page); //пересохранение в сессии
                if (is_null($per_page)) $per_page = '5'; //кол-во на странице по умолчанию
            }
            $data['per_page'] = $per_page;
            //Обработка запроса на поиск
            if (!is_null($this->request->getPost('search')))
            {
                session()->setFlashdata('search', $this->request->getPost('search'));
                $search = $this->request->getPost('search');
            }
            else {
                $search = session()->getFlashdata('search');
                session()->setFlashdata('search', $search);
                if (is_null($search)) $search = '';
            }
            $data['search'] = $search;
            helper(['form','url']);
            $model = new IngridientModel();
            $data['ingridient'] = $model->getIngridientWithUser()->paginate(2, 'group1');
            $data['pager'] = $model->pager;
            echo view('ingridient/view_all_with_users', $this->withIon($data));
        }
        else
        {
            session()->setFlashdata('message', lang('Curating.admin_permission_needed'));
            return redirect()->to('/auth/login');
        }
    }
}