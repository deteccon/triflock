<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

use ImageKit\ImageKit;

class UserController
{
    private $userModel;
    private $imagekit;

    public function __construct($pdo)
    {
        $this->userModel = new User($pdo);

        $this->imagekit = new ImageKit(
            IMAGEKIT_PUBLIC_KEY,
            IMAGEKIT_PRIVATE_KEY,
            IMAGEKIT_URL_ENDPOINT
        );
    }

    public function uploadProfilePic($userId, $file)
    {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return ['success' => false, 'message' => 'No file uploaded'];
        }

        $allowed = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!in_array($file['type'], $allowed)) {
            return ['success' => false, 'message' => 'Invalid file type'];
        }

        $fileContent = file_get_contents($file['tmp_name']);
        $fileName = "profP_" . $userId . "_" . time();

        try {
            $upload = $this->imagekit->upload([
                "file" => base64_encode($fileContent),
                "fileName" => $fileName,
                "folder" => "users/profP"
            ]);

            if (!isset($upload->result->url)) {
                return ['success' => false, 'message' => 'Upload failed'];
            }

            $imageUrl = $upload->result->url;

            $this->userModel->updateProfilePic($userId, $imageUrl);

            return [
                "success" => true,
                "message" => 'Profile picture updated',
                "url" => $imageUrl,
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
