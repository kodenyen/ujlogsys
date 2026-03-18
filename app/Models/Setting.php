<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Setting extends Model {
    public function get() {
        $stmt = $this->db->query("SELECT * FROM settings WHERE id = 1");
        return $stmt->fetch();
    }

    public function update($org_name, $footer_text, $org_logo = null) {
        if ($org_logo) {
            $stmt = $this->db->prepare("UPDATE settings SET org_name = ?, footer_text = ?, org_logo = ? WHERE id = 1");
            return $stmt->execute([$org_name, $footer_text, $org_logo]);
        } else {
            $stmt = $this->db->prepare("UPDATE settings SET org_name = ?, footer_text = ? WHERE id = 1");
            return $stmt->execute([$org_name, $footer_text]);
        }
    }
}
