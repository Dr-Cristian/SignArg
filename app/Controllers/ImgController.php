<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ImgModel;
class ImgController extends BaseController{
    public function saveImage(){
        $ImgModel = new ImgModel();
        $input = $this->validate([ 
            'photo' => [ 
                'uploaded[photo]', 
                'mime_in[photo,image/jpg,image/jpeg,image/gif,image/png]', 
                'max_size[imagen,4096]', 
            ], 
        ]);
        if ($input) { 
            // Imagen cargada con éxito 
            $file = $this->request->getFile('photo');
            $fileName = $file->getRandomName();
            $path = $this->request->getFile('photo')->store('img/cam/', $fileName);
            // $file->move('img/cam/', $fileName); 
            $data['nombre'] = $fileName; 
            $data['imagen'] = $file; 
    
            $ImgModel->saveImg($data); 
            return redirect()->to(''); 
        } else {
            // Hubo un error al cargar la imagen 
            return redirect()->to('')->with('error', 'No se pudo cargar la imagen.'); 
        } 
    }
}