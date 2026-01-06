        <?php defined('BASEPATH') OR exit('No direct script access allowed');

        class User_model extends CI_Model
        {
        public function get_by_email(string $email)
        {
            return $this->db->get_where('users', ['email' => $email], 1)->row();
        }

        public function update_last_login(int $user_id): void
        {
            $this->db->where('id', $user_id)->update('users', [
            'last_login' => date('Y-m-d H:i:s')
            ]);
        }
        }
