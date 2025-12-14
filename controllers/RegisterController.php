<?php
class RegisterController extends BaseController {
    public function register() {
        return $this->view('client.register', [
        ]);
    }
    public function login() {
        return include './views/client/login.php';
    }
}
