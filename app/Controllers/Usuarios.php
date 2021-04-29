<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuario;

class Usuarios extends Controller{

    public function index(){

        $usuario = new Usuario();
        $data['usuarios'] = $usuario->orderBy('id', 'ASC')->findAll();

        $data['header'] = view('templates/header');
        $data['footer'] = view('templates/footer');

        return view('usuarios/listar', $data);

    }

    public function crear(){

        $data['header'] = view('templates/header');
        $data['footer'] = view('templates/footer');

        return view('usuarios/crear', $data);

    }



    public function guardar(){

        $usuario = new Usuario();

        $validate = $this->validate([
            'nombre' => 'required|min_length[3]',
            'imagen' => [
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png]',
                'max_size[imagen,1024]',
            ]
        ]);

        if(!$validate){
            $session = session();
            $session->setFlashdata('mensaje', 'Revise la informacion');

            return redirect()->back()->withInput();
        }

        if($img = $this->request->getFile('imagen')){
            $renameImg = $img->getRandomName();
            $img->move('../public/uploads/', $renameImg); 
            $data = [
                'nombre' => $this->request->getVar('nombre'),
                'imagen' => $renameImg
            ];

            $usuario->insert($data);
        }

        return $this->response->redirect(site_url('/listar'));

    }



    public function borrar($id = null){

        $usuario = new Usuario();
        $data = $usuario->where('id', $id)->first();

        $routeImg = ('../public/uploads/'.$data['imagen']);
        unlink($routeImg);

        $usuario->where('id', $id)->delete($id);

        return $this->response->redirect(site_url('/listar'));

    }

    public function editar($id = null){

        $data['header'] = view('templates/header');
        $data['footer'] = view('templates/footer');

        $usuario = new Usuario();
        $data['usuario'] = $usuario->where('id', $id)->first();

        return view('usuarios/editar', $data);

    }

    public function actualizar($id = null){

        $usuario = new Usuario();
        $data = [
            'nombre' => $this->request->getVar('nombre'),
        ];

        $id = $this->request->getVar('id');

        $validate = $this->validate([
            'nombre' => 'required|min_length[3]',
        ]);

        if(!$validate){
            $session = session();
            $session->setFlashdata('mensaje', 'Revise la informacion');

            return redirect()->back()->withInput();
        }

        $usuario->update($id, $data);

        $validate = $this->validate([
            'imagen' => [
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png]',
                'max_size[imagen,1024]',
            ]
        ]);

        if($validate){

            if($img = $this->request->getFile('imagen')){

                $dataUsuario = $usuario->where('id', $id)->first();

                $routeImg = ('../public/uploads/'.$dataUsuario['imagen']);
                unlink($routeImg);

                $renameImg = $img->getRandomName();
                $img->move('../public/uploads/', $renameImg); 
                $data = [
                    'imagen' => $renameImg
                ];
                $usuario->update($id, $data);
            }
        }

        return $this->response->redirect(site_url('/listar'));
    }

}