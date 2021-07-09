<?php

/*
 * ==========================================================
 * WORDPRESS APP
 * ==========================================================
 *
 * WordPress app main file
 *
 */

if (!defined('SB_WP')) define('SB_WP', true);

/*
 * -----------------------------------------------------------
 * GET USER DATA
 * -----------------------------------------------------------
 *
 * Return the WordPress user data
 *
 */

function sb_wp_get_user($login_data) {
    $user_id = json_decode(sb_encryption('decrypt', $login_data), true);
    if (isset($user_id['id'])) {
        $user_id = $user_id['id'];
    } else {
        return false;
    }
    $user_data = sb_db_get('SELECT * FROM ' . SB_WP_PREFIX . 'users WHERE ID ="' . $user_id . '" LIMIT 1');
    if (sb_is_error($user_data) || !isset($user_data['ID'])) {
        return false;
    } else {
        $user_meta = sb_db_get('SELECT meta_key, meta_value FROM ' . SB_WP_PREFIX . 'usermeta WHERE user_id = "' . $user_id . '" AND (meta_key = "first_name" OR meta_key = "last_name")', false);
        if (!sb_is_error($user_data) && is_array($user_meta)) {
            for ($i = 0; $i < count($user_meta); $i++) {
                $user_data[$user_meta[$i]['meta_key']] = $user_meta[$i]['meta_value'];
            }
        }
        if ($user_data['first_name'] == '') {
            $user_data['first_name'] = ucfirst($user_data['user_login']);
        }
        return $user_data;
    }
}

/*
 * -----------------------------------------------------------
 * GET ACTIVE USER
 * -----------------------------------------------------------
 *
 * Get the active WordPress user
 *
 */

function sb_wp_get_active_user($login_data) {
    $user = json_decode(sb_encryption('decrypt', $login_data), true);
    $query = '';
    if (isset($user['email'])) {
        $query = 'SELECT id, token FROM sb_users WHERE email ="' . $user['email'] . '" LIMIT 1';
        $user = sb_db_get($query);
        if ($user === '') {
            sb_add_user(null, null, $login_data);
            $user = sb_db_get($query);
        }
        if (sb_is_error($user) || !isset($user['token']) || !isset($user['id'])) {
            return false;
        } else {
           return sb_login('', '', $user['id'], $user['token']);
        }
    } else {
        return false;
    }
}

/*
 * -----------------------------------------------------------
 * SYNCH USERS
 * -----------------------------------------------------------
 *
 * Import the WordPress users into Support Board
 *
 */

function sb_wp_synch() {
    $emails = sb_db_get('SELECT email FROM sb_users WHERE email <> ""', false);
    $emails_array = [];
    $users = sb_db_get( 'SELECT a.*, b.meta_value first_name, c.meta_value last_name FROM ' . SB_WP_PREFIX . 'users a LEFT JOIN ' . SB_WP_PREFIX . 'usermeta b ON a.ID = b.user_id AND b.meta_key = "first_name" LEFT JOIN ' . SB_WP_PREFIX . 'usermeta c ON a.ID = c.user_id AND c.meta_key = "last_name"', false);
    $now = gmdate('Y-m-d H:i:s');
    for ($i = 0; $i < count($emails); $i++) {
        array_push($emails_array, $emails[$i]['email']);
    }
    for ($i = 0; $i < count($users); $i++) {
        if (!in_array($users[$i]['user_email'], $emails_array)) {
            if ($users[$i]['first_name'] == '') {
                $users[$i]['first_name'] = ucfirst($users[$i]['user_login']);
            }
            $token = bin2hex(openssl_random_pseudo_bytes(20));
            sb_db_query('INSERT IGNORE INTO sb_users(first_name, last_name, password, email, profile_image, user_type, creation_time, token, last_activity) VALUES ("' . sb_db_escape($users[$i]['first_name']) . '", "' . sb_db_escape($users[$i]['last_name']) . '", "' . sb_db_escape($users[$i]['user_pass']) . '", "' . $users[$i]['user_email'] . '", "' . SB_URL . '/media/user.svg", "user", "' . $now . '", "' . $token . '", "' . $now . '")');
        }
    }
    return true;
}

/*
 * -----------------------------------------------------------
 * CONFIG
 * -----------------------------------------------------------
 *
 * Return the WordPress information to insert into the config.php file
 *
 */

function sb_wp_config() {
    global $wpdb;
    $upload_directory = wp_upload_dir();
    if (!file_exists($upload_directory['basedir'] . '/sb')) {
        mkdir($upload_directory['basedir'] . '/sb', 0777, true);
    }
    return '/* WordPress prefix */' . PHP_EOL . 'define(\'SB_WP_PREFIX\', \'' . $wpdb->prefix . '\');' . PHP_EOL . PHP_EOL . '/* Upload path */'. PHP_EOL . 'define(\'SB_UPLOAD_PATH\', \'' . $upload_directory['basedir'] . '/sb\');' . PHP_EOL . PHP_EOL . '/* Upload url */'. PHP_EOL . 'define(\'SB_UPLOAD_URL\', \'' . $upload_directory['baseurl'] . '/sb\');';
}

/*
 * -----------------------------------------------------------
 * WORDPRESS PASSWORD HASH
 * -----------------------------------------------------------
 *
 * Original WordPress password hash framework
 *
 */

class SBPasswordHash {
	var $itoa64;
	var $iteration_count_log2;
	var $portable_hashes;
	var $random_state;

	function __construct( $iteration_count_log2, $portable_hashes ) {
		$this->itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

		if ($iteration_count_log2 < 4 || $iteration_count_log2 > 31)
			$iteration_count_log2 = 8;
		$this->iteration_count_log2 = $iteration_count_log2;

		$this->portable_hashes = $portable_hashes;

		$this->random_state = microtime() . uniqid(rand(), TRUE); // removed getmypid() for compatibility reasons
	}

	public function PasswordHash( $iteration_count_log2, $portable_hashes ) {
		self::__construct( $iteration_count_log2, $portable_hashes );
	}

	function get_random_bytes($count) {
		$output = '';
		if ( @is_readable('/dev/urandom') &&
		    ($fh = @fopen('/dev/urandom', 'rb'))) {
			$output = fread($fh, $count);
			fclose($fh);
		}

		if (strlen($output) < $count) {
			$output = '';
			for ($i = 0; $i < $count; $i += 16) {
				$this->random_state =
				    md5(microtime() . $this->random_state);
				$output .=
				    pack('H*', md5($this->random_state));
			}
			$output = substr($output, 0, $count);
		}

		return $output;
	}

	function encode64($input, $count) {
		$output = '';
		$i = 0;
		do {
			$value = ord($input[$i++]);
			$output .= $this->itoa64[$value & 0x3f];
			if ($i < $count)
				$value |= ord($input[$i]) << 8;
			$output .= $this->itoa64[($value >> 6) & 0x3f];
			if ($i++ >= $count)
				break;
			if ($i < $count)
				$value |= ord($input[$i]) << 16;
			$output .= $this->itoa64[($value >> 12) & 0x3f];
			if ($i++ >= $count)
				break;
			$output .= $this->itoa64[($value >> 18) & 0x3f];
		} while ($i < $count);

		return $output;
	}

	function gensalt_private($input) {
		$output = '$P$';
		$output .= $this->itoa64[min($this->iteration_count_log2 +
			((PHP_VERSION >= '5') ? 5 : 3), 30)];
		$output .= $this->encode64($input, 6);

		return $output;
	}

	function crypt_private($password, $setting) {
		$output = '*0';
		if (substr($setting, 0, 2) == $output)
			$output = '*1';

		$id = substr($setting, 0, 3);
		if ($id != '$P$' && $id != '$H$')
			return $output;

		$count_log2 = strpos($this->itoa64, $setting[3]);
		if ($count_log2 < 7 || $count_log2 > 30)
			return $output;

		$count = 1 << $count_log2;

		$salt = substr($setting, 4, 8);
		if (strlen($salt) != 8)
			return $output;

		if (PHP_VERSION >= '5') {
			$hash = md5($salt . $password, TRUE);
			do {
				$hash = md5($hash . $password, TRUE);
			} while (--$count);
		} else {
			$hash = pack('H*', md5($salt . $password));
			do {
				$hash = pack('H*', md5($hash . $password));
			} while (--$count);
		}

		$output = substr($setting, 0, 12);
		$output .= $this->encode64($hash, 16);

		return $output;
	}

	function gensalt_extended($input) {
		$count_log2 = min($this->iteration_count_log2 + 8, 24);
		$count = (1 << $count_log2) - 1;

		$output = '_';
		$output .= $this->itoa64[$count & 0x3f];
		$output .= $this->itoa64[($count >> 6) & 0x3f];
		$output .= $this->itoa64[($count >> 12) & 0x3f];
		$output .= $this->itoa64[($count >> 18) & 0x3f];

		$output .= $this->encode64($input, 3);

		return $output;
	}

	function gensalt_blowfish($input) {
		$itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

		$output = '$2a$';
		$output .= chr(ord('0') + $this->iteration_count_log2 / 10);
		$output .= chr(ord('0') + $this->iteration_count_log2 % 10);
		$output .= '$';

		$i = 0;
		do {
			$c1 = ord($input[$i++]);
			$output .= $itoa64[$c1 >> 2];
			$c1 = ($c1 & 0x03) << 4;
			if ($i >= 16) {
				$output .= $itoa64[$c1];
				break;
			}

			$c2 = ord($input[$i++]);
			$c1 |= $c2 >> 4;
			$output .= $itoa64[$c1];
			$c1 = ($c2 & 0x0f) << 2;

			$c2 = ord($input[$i++]);
			$c1 |= $c2 >> 6;
			$output .= $itoa64[$c1];
			$output .= $itoa64[$c2 & 0x3f];
		} while (1);

		return $output;
	}

	function HashPassword($password) {
		if ( strlen( $password ) > 4096 ) {
			return '*';
		}

		$random = '';

		if (CRYPT_BLOWFISH == 1 && !$this->portable_hashes) {
			$random = $this->get_random_bytes(16);
			$hash =
			    crypt($password, $this->gensalt_blowfish($random));
			if (strlen($hash) == 60)
				return $hash;
		}

		if (CRYPT_EXT_DES == 1 && !$this->portable_hashes) {
			if (strlen($random) < 3)
				$random = $this->get_random_bytes(3);
			$hash =
			    crypt($password, $this->gensalt_extended($random));
			if (strlen($hash) == 20)
				return $hash;
		}

		if (strlen($random) < 6)
			$random = $this->get_random_bytes(6);
		$hash =
		    $this->crypt_private($password,
		    $this->gensalt_private($random));
		if (strlen($hash) == 34)
			return $hash;

		return '*';
	}

	function CheckPassword($password, $stored_hash) {
		if ( strlen( $password ) > 4096 ) {
			return false;
		}

		$hash = $this->crypt_private($password, $stored_hash);
		if ($hash[0] == '*')
			$hash = crypt($password, $stored_hash);

		return $hash === $stored_hash;
	}
}

?>