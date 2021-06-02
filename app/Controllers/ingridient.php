<?php namespace App\Controllers;

use App\Models\IngridientModel;

class ingridient extends BaseController
{

    public function index() //Обображение всех записей
    {
        //если пользователь не аутентифицирован - перенаправление на страницу входа
        if (!$this->ionAuth->loggedIn())
        {
            return redirect()->to('/auth/login');
        }
        $model = new IngridientModel();
        $data ['rating'] = $model->getingridient();
        echo view('ingridient/view_all', $this->withIon($data));
    }

    public function view($id = null) //отображение одной записи
    {
        //если пользователь не аутентифицирован - перенаправление на страницу входа
        if (!$this->ionAuth->loggedIn())
        {
            return redirect()->to('/auth/login');
        }
        $model = new IngridientModel();
        $data ['ingridient'] = $model->getingridient($id);
        echo view('ingridient/view', $this->withIon($data));
    }

    public function viewAllWithUsers()
    {
        if ($this->ionAuth->isAdmin())
        {
            $model = new IngridientModel();
            $data['ingridient'] = $model->getIngridientWithUser();
            echo view('ingridient/view_all_with_users', $this->withIon($data));
        }
        else
        {
            session()->setFlashdata('message', lang('Curating.admin_permission_needed'));
            return redirect()->to('/auth/login');
        }
    }

    public function create()
    {
        if (!$this->ionAuth->loggedIn())
        {
            return redirect()->to('/auth/login');
        }
        helper(['form']);
        $data ['validation'] = \Config\Services::validation();
        echo view('ingridient/create', $this->withIon($data));
    }

    public function store()
    {
        helper(['form','url']);

        if ($this->request->getMethod() === 'post' && $this->validate([
                'Наименование' => 'required|min_length[1]|max_length[255]',
                'Единицы измерения'  => 'required',
                'picture'  => 'is_image[picture]|max_size[picture,1024]',
            ]))
        {
            $insert = null;
            //получение загруженного файла из HTTP-запроса
            $file = $this->request->getFile('picture');
            if ($file->getSize() != 0) {
                //подключение хранилища
                $s3 = new S3Client([
                    'version' => 'latest',
                    'region' => 'us-east-1',
                    'endpoint' => getenv('S3_ENDPOINT'),
                    'use_path_style_endpoint' => true,
                    'credentials' => [
                        'key' => getenv('S3_KEY'), //чтение настроек окружения из файла .env
                        'secret' => getenv('S3_SECRET'), //чтение настроек окружения из файла .env
                    ],
                ]);
                //получение расширения имени загруженного файла
                $ext = explode('.', $file->getName());
                $ext = $ext[count($ext) - 1];
                //загрузка файла в хранилище
                $insert = $s3->putObject([
                    'Bucket' => getenv('S3_BUCKET'), //чтение настроек окружения из файла .env
                    //генерация случайного имени файла
                    'Key' => getenv('S3_KEY') . '/file' . rand(100000, 999999) . '.' . $ext,
                    'Body' => fopen($file->getRealPath(), 'r+')
                ]);
            }
            $model = new RatingModel();
            $model = [
                'Наименование' => $this->request->getPost('Наименование'),
                'Единицы измерения' => $this->request->getPost('Единицы измерения'),
            ];
            //если изображение было загружено и была получена ссылка на него то даобавить ссылку в данные модели
            if (!is_null($insert))
                $data['picture_url'] = $insert['ObjectURL'];
            $model->save($data);
            session()->setFlashdata('message', lang('Curating.ingridient_create_success'));
            return redirect()->to('/ingridient');
        }
        else
        {
            return redirect()->to('/ingridient/create')->withInput();
        }
    }
    public function edit($id)
    {
        if (!$this->ionAuth->loggedIn())
        {
            return redirect()->to('/auth/login');
        }
        $model = new IngridientModel();

        helper(['form']);
        $data ['ingridient'] = $model->getingridient($id);
        $data ['validation'] = \Config\Services::validation();
        echo view('ingridient/edit', $this->withIon($data));
    }
    public function update()
    {
        helper(['form','url']);
        echo '/ingridient/edit/'.$this->request->getPost('id');
        if ($this->request->getMethod() === 'post' && $this->validate([
                'id'  => 'required',
                'Наименование' => 'required|min_length[1]|max_length[255]',
                'Единицы измерения'  => 'required',
            ]))
        {
            $model = new IngridientModel();
            $model->save([
                'id' => $this->request->getPost('id'),
                'Наименование' => $this->request->getPost('Наименование'),
                'Единицы измерения' => $this->request->getPost('Единицы измерения'),
            ]);
            //session()->setFlashdata('message', lang('Curating.ingridient_update_success'));

            return redirect()->to('/ingridient');
        }
        else
        {
            return redirect()->to('/ingridient/edit/'.$this->request->getPost('id'))->withInput();
        }
    }
    public function delete($id)
    {
        if (!$this->ionAuth->loggedIn())
        {
            return redirect()->to('/auth/login');
        }
        $model = new IngridientModel();
        $model->delete($id);
        return redirect()->to('/ingridient');
    }
}
