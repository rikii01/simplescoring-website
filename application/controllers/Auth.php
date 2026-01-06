    <?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Auth extends CI_Controller
    {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login()
    {
        if ($this->session->userdata('user_id')) {
        redirect('dashboard');
        return;
        }

        if ($this->input->method() === 'post') {
        $this->_do_login();
        return;
        }

        $this->load->view('auth/login');
    }

    private function _do_login(): void
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if (!$this->form_validation->run()) {
        $this->load->view('auth/login');
        return;
        }

        $email = $this->input->post('email', TRUE);
        $password = (string)$this->input->post('password', TRUE);

        $user = $this->User_model->get_by_email($email);

        if (!$user || $password !== $user->password) {
        $data['error'] = 'Email atau password salah.';
        $this->load->view('auth/login', $data);
        return;
        }

        $this->session->sess_regenerate(TRUE);
        $this->session->set_userdata([
        'user_id' => (int)$user->id,
        'user_name' => $user->name,
        'user_email' => $user->email,
        'role'      => $user->role, 
        'is_logged_in' => TRUE
        ]);

        $this->User_model->update_last_login((int)$user->id);

        redirect('dashboard');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
    }
