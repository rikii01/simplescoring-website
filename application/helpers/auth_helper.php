    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    function require_login()
    {
        $CI =& get_instance();
        if (!$CI->session->userdata('user_id')) {
            redirect('auth/login');
            exit;
        }
    }

    function require_admin()
    {
        $CI =& get_instance();
        require_login();
        if ($CI->session->userdata('role') !== 'admin') {
            show_error('Akses ditolak. Admin only.', 403);
            exit;
        }
    }
