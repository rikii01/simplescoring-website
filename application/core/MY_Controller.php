    <?php defined('BASEPATH') OR exit('No direct script access allowed');

    class MY_Controller extends CI_Controller
    {
    protected function require_login(): void
    {
        if (!$this->session->userdata('user_id')) {
        redirect('login');
        exit;
        }
    }
    }
