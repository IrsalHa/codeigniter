<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Artikel;
use \Hermawan\DataTables\DataTable;

class Dashboard extends BaseController
{
    public function index()
    {

        $data = [
            'auth' => $session = session()
        ];
        echo view('dashboard',$data);
    }

    public function create()
    {

        $rules = [
            'judul' => 'required',
            'isi' => 'required',
            'thumbnail' => 'mime_in[thumbnail,image/jpg,image/jpeg,image/gif,image/png]|max_size[thumbnail,4096]',
            'tag' => 'required',
            'kategori' => 'required'
        ];


        if($this->validate($rules))
        {
            $artikel = new Artikel();
            $foto = $this->request->getFile('thumbnail');
            $nama = explode(".",$foto->getClientName());
            $newName = $nama[0].time().".".$nama[1];
            $foto->move('./public/uploads/', $newName);

            $data = [
                'name' =>  $foto->getClientName(),
                'type'  => $foto->getClientMimeType()
            ];

            $artikel->insert([
                'judul_artikel' => $this->request->getPost('judul'),
                'isi_artikel' => $this->request->getPost('isi'),
                'thumbnail_artikel' => $newName,
                'tag_artikel' => $this->request->getPost('tag'),
                'kategori_artikel' => $this->request->getPost('kategori'),
            ]);

        }else{
            $data['validation'] = $this->validator;
            $data['auth'] = $session = session();
            echo view('dashboard', $data);
        }
    }

    public function indexDataTable(){
        $db = db_connect();
        $builder = $db->table('articles')->select('id, thumbnail_artikel, judul_artikel, isi_artikel, tag_artikel, kategori_artikel');

        return DataTable::of($builder)
            ->format('thumbnail_artikel', function($val){
                return '<img width="100px" height="100px" src="'.base_url().'/public/uploads/'.$val.'">';
            })
            ->add('action', function($row){
                return '<a href="/dashboard/delete/'.$row->id.'" type="button" class="btn btn-danger btn-sm mt-2" ><i class="fas fa-edit"></i>Delete</a>
                        <button onclick="edit('.$row->id.')" type="button" class="btn btn-primary btn-sm mt-2" ><i class="fas fa-edit"></i>Edit</button>
';
            }, 'last')
            ->toJson();
    }

    public function delete($id){
        $artikel = new Artikel();
        $query = $artikel->where('id', $id);

        if(!$query){
            redirect()->back();
        }

        $query->delete();

        $data = [
            'auth' => $session = session()
        ];

        return redirect()->back();

    }

    public function getByID($id){
        $artikel = new Artikel();
        $query = $artikel->where('id', $id)->first();

        echo json_encode($query);
    }

    public function edit(){
        $rules = [
            'judul' => 'required',
            'isi' => 'required',
            'thumbnail' => 'mime_in[thumbnail,image/jpg,image/jpeg,image/gif,image/png]|max_size[thumbnail,4096]',
            'tag' => 'required',
            'kategori' => 'required'
        ];
        if($this->validate($rules)){
            $artikel = new Artikel();
            $cek = $artikel->where('id', $this->request->getPost("id"))->first();
            if($cek){
                $foto = $this->request->getFile('thumbnail');

                if($foto->getClientName() == ""){
                    $update = $artikel->update($this->request->getPost('id'),[
                        'judul_artikel' => $this->request->getPost('judul'),
                        'isi_artikel' => $this->request->getPost('isi'),
                        'tag_artikel' => $this->request->getPost('tag'),
                        'kategori_artikel' => $this->request->getPost('kategori'),
                    ]);

                    return json_encode([
                        'success' => true,
                        'update' => $update
                    ]);
                }

                unlink('./public/uploads/'.$cek['thumbnail_artikel']);
                $nama = explode(".",$foto->getClientName());
                $newName = $nama[0].time().".".$nama[1];
                $foto->move('./public/uploads/', $newName);

               $update =  $artikel->update($this->request->getPost('id'),[
                    'judul_artikel' => $this->request->getPost('judul'),
                    'isi_artikel' => $this->request->getPost('isi'),
                    'thumbnail_artikel' => $newName,
                    'tag_artikel' => $this->request->getPost('tag'),
                    'kategori_artikel' => $this->request->getPost('kategori'),
                ]);

                return json_encode([
                    'success' => true,
                    'update' => $update
                ]);
            }

        }

    }
}
