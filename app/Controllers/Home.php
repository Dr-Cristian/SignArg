<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('webcam');
    }
    public function saveImage()
    {
        $imageData = $this->request->getPost('photo');
        $imageName = 'image_' . time() . '.png';
        $imagePath = WRITEPATH . 'img/' . $imageName;
        if (file_put_contents($imagePath, base64_decode(str_replace('data:image/png;base64,', '', $imageData)))) {
            return $this->response->setJSON(['message' => 'Image saved successfully']);
            return redirect()->to('');
        } else {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to save image']);
        }
    }
}