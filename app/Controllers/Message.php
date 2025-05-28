<?php

namespace App\Controllers;

use App\Models\MessageModel;
use App\Models\CommuneModel;

class Message extends BaseController
{
    private $messageModel;
    private $communeModel;

    public function __construct()
    {
        $this->messageModel = model('MessageModel');
        $this->communeModel = model('CommuneModel');
    }

    // Afficher tous les messages
    public function index(): string
    {
        $user = auth()->user();
        if (!$user->inGroup('admin')) {
            $userId = $user->IDCOMMUNE;
            // dd($userId);
            $listeMessages = $this->messageModel->getAllMessageByCommune($userId);
            // var_dump($user);
            // var_dump($listeMessages);
            // die();
            return view('messages/gestion_message', [
                'messages' => $listeMessages
            ]);
        }

        $messages = $this->messageModel->findAll();

        // var_dump($messages);
        // die();

        return view('messages/gestion_message', [
            'messages' => $messages
        ]);
    }

    // Afficher le formulaire pour ajouter un message
    public function ajout(): string
    {
        $user = auth()->user();
        if (!$user->inGroup('admin')) {
            $userId = $user->IDCOMMUNE;
            // dd($userId);
            $communeData = $this->communeModel->findCommuneNomAndDepart($userId);
            // dd($communeData);
            $communeNom = $communeData[0]['NOM'];
            // dd($communeNom);
            $deptNum = $communeData[0]['DEPARTEMENT'];
            // dd($deptNum);


            return view('messages/ajout_message', [
                'communeId' => $userId,
                'nomCommune' => $communeNom,
                'deptNum' => $deptNum
            ]);
        } else {

            $communes = $this->communeModel->findAll();
            // dd($communes);

            return view('messages/ajout_message', [
                'listeCommunes' => $communes
            ]);
        }
    }

    // Créer un nouveau message
    public function create()
    {
        $data = [
            'IDCOMMUNE' => $this->request->getPost('IDCOMMUNE'),
            'ETAT'      => $this->request->getPost('ETAT'),
            'TEXTE'     => $this->request->getPost('TEXTE'),
            'COULEUR'   => $this->request->getPost('COULEUR'),
            'TAILLE'    => $this->request->getPost('TAILLE'),
            'date_fin'  => $this->request->getPost('date_fin'), // Enregistrement de la date de fin
        ];

        $this->messageModel->save($data);

        return redirect()->to('/messages');
    }

    // Afficher le formulaire pour modifier un message
    public function modif($id): string
    {
        $message = $this->messageModel->find($id);
        return view('messages/modifier_message', [
            'message' => $message,
            'listeCommune' => $this->communeModel->findAll()
        ]);
    }

    // Mettre à jour un message
    public function update()
    {
        $messageData = $this->request->getPost();
        $this->messageModel->save($messageData);  // Sauvegarde directement les données envoyées
        return redirect('message');
    }

    // Supprimer un message
    public function delete()
    {
        $this->messageModel->delete($this->request->getPost('IDMESSAGE'));  // Suppression du message avec l'ID via POST
        return redirect('message');
    }

    // Afficher les détails d'un message
    public function view($id): string
    {
        $message = $this->messageModel->find($id);
        return view('messages/view_message', [
            'message' => $message
        ]);
    }
}
