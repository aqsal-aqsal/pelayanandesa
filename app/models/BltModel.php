<?php

class BltModel {
    private $table = 'program_bantuan';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getPrograms() {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getProgramById($id_program) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_program = :id');
        $this->db->bind('id', $id_program);
        return $this->db->single();
    }

    public function getAllPenerima() {
        $this->db->query("SELECT c.*, w.nama_lengkap, w.nik, p.nama_program, p.periode 
                          FROM calon_penerima c 
                          JOIN warga w ON c.id_warga = w.id_warga 
                          JOIN program_bantuan p ON c.id_program = p.id_program 
                          WHERE c.status = 'penerima' 
                          ORDER BY p.id_program DESC, w.nama_lengkap ASC");
        return $this->db->resultSet();
    }

    public function addProgram($data) {
        $this->db->query('INSERT INTO program_bantuan (nama_program, sumber_dana, periode, total_anggaran, kuota_penerima, status, created_at) VALUES (:nama, :sumber, :periode, :anggaran, :kuota, :status, NOW())');
        $this->db->bind('nama', $data['nama_program']);
        $this->db->bind('sumber', $data['sumber_dana']);
        $this->db->bind('periode', $data['periode']);
        $this->db->bind('anggaran', $data['total_anggaran'] ?? 0);
        $this->db->bind('kuota', $data['kuota_penerima'] ?? 0);
        $this->db->bind('status', $data['status'] ?? 'direncanakan');
        return $this->db->execute();
    }

    public function editProgram($data) {
        $this->db->query('UPDATE program_bantuan 
            SET nama_program = :nama, sumber_dana = :sumber, periode = :periode, 
                total_anggaran = :anggaran, kuota_penerima = :kuota, status = :status, updated_at = NOW() 
            WHERE id_program = :id');
        $this->db->bind('nama', $data['nama_program']);
        $this->db->bind('sumber', $data['sumber_dana']);
        $this->db->bind('periode', $data['periode']);
        $this->db->bind('anggaran', $data['total_anggaran'] ?? 0);
        $this->db->bind('kuota', $data['kuota_penerima'] ?? 0);
        $this->db->bind('status', $data['status'] ?? 'direncanakan');
        $this->db->bind('id', $data['id_program']);
        return $this->db->execute();
    }

    public function deleteProgram($id_program) {
        $this->db->query('DELETE FROM program_bantuan WHERE id_program = :id');
        $this->db->bind('id', $id_program);
        return $this->db->execute();
    }

    public function getKriteria() {
        $this->db->query('SELECT * FROM kriteria_bantuan ORDER BY id_kriteria ASC');
        $kriteria = $this->db->resultSet();
        
        // Tambahkan sub-kriteria untuk setiap kriteria
        foreach ($kriteria as &$k) {
            $k['sub_kriteria'] = $this->getSubKriteria($k['id_kriteria']);
        }
        
        return $kriteria;
    }
    
    public function getSubKriteria($id_kriteria) {
        $this->db->query('SELECT * FROM sub_kriteria WHERE id_kriteria = :id_kriteria ORDER BY nilai DESC');
        $this->db->bind('id_kriteria', $id_kriteria);
        return $this->db->resultSet();
    }
    
    public function addSubKriteria($id_kriteria, $label, $nilai) {
        $this->db->query('INSERT INTO sub_kriteria (id_kriteria, label, nilai, created_at) VALUES (:id_kriteria, :label, :nilai, NOW())');
        $this->db->bind('id_kriteria', $id_kriteria);
        $this->db->bind('label', $label);
        $this->db->bind('nilai', $nilai);
        return $this->db->execute();
    }
    
    public function deleteSubKriteria($id_sub_kriteria) {
        $this->db->query('DELETE FROM sub_kriteria WHERE id_sub_kriteria = :id');
        $this->db->bind('id', $id_sub_kriteria);
        return $this->db->execute();
    }
    
    public function getNilaiFromWargaData($id_kriteria, $warga) {
        $sub_kriteria = $this->getSubKriteria($id_kriteria);
        $nama_kriteria = $this->db->query('SELECT nama_kriteria FROM kriteria_bantuan WHERE id_kriteria = :id_kriteria');
        $this->db->bind('id_kriteria', $id_kriteria);
        $kriteria = $this->db->single();
        $nama_kriteria = $kriteria['nama_kriteria'];
        
        switch($nama_kriteria) {
            case 'Penghasilan':
                $penghasilan = (float) $warga['penghasilan'];
                if ($penghasilan <= 500000) return 5;
                elseif ($penghasilan <= 1500000) return 4;
                elseif ($penghasilan <= 2500000) return 3;
                elseif ($penghasilan <= 3500000) return 2;
                else return 1;
                break;
            case 'Jumlah Tanggungan':
                $tanggungan = (int) $warga['jumlah_tanggungan'];
                if ($tanggungan >= 5) return 5;
                else return $tanggungan;
                break;
            case 'Kondisi Rumah':
                $kondisi = $warga['kondisi_rumah'];
                switch($kondisi) {
                    case 'tidak_layak': return 4;
                    case 'kurang_layak': return 3;
                    case 'layak': return 2;
                    default: return 3;
                }
                break;
            case 'Pekerjaan':
                $pekerjaan = strtolower($warga['pekerjaan']);
                if (strpos($pekerjaan, 'pns') !== false || strpos($pekerjaan, 'tni') !== false || strpos($pekerjaan, 'polri') !== false || strpos($pekerjaan, 'karyawan tetap') !== false) return 1;
                elseif (strpos($pekerjaan, 'wiraswasta') !== false) return 2;
                elseif (strpos($pekerjaan, 'petani') !== false || strpos($pekerjaan, 'nelayan') !== false) return 3;
                elseif (strpos($pekerjaan, 'buruh') !== false) return 4;
                else return 5;
                break;
        }
        return null;
    }

    public function addKriteria($data) {
        $this->db->query('INSERT INTO kriteria_bantuan (nama_kriteria, bobot, tipe_kriteria, created_at) VALUES (:nama, :bobot, :tipe, NOW())');
        $this->db->bind('nama', $data['nama_kriteria']);
        $this->db->bind('bobot', $data['bobot']);
        $this->db->bind('tipe', $data['tipe_kriteria']);
        return $this->db->execute();
    }

    public function deleteKriteria($id_kriteria) {
        $this->db->query('DELETE FROM kriteria_bantuan WHERE id_kriteria = :id');
        $this->db->bind('id', $id_kriteria);
        return $this->db->execute();
    }

    public function getCalonPenerima($id_program) {
        $this->db->query('SELECT c.*, w.* FROM calon_penerima c JOIN warga w ON c.id_warga = w.id_warga WHERE c.id_program = :id_program ORDER BY c.created_at DESC');
        $this->db->bind('id_program', $id_program);
        $calon = $this->db->resultSet();
        
        // Tambahkan informasi apakah nilai sudah diinput dan nilai kriteria
        foreach ($calon as &$c) {
            $this->db->query('SELECT COUNT(*) as total FROM nilai_kriteria_calon WHERE id_calon = :id_calon');
            $this->db->bind('id_calon', $c['id_calon']);
            $c['total_nilai'] = $this->db->single()['total'];
            
            // Ambil nilai kriteria
            $c['nilai'] = [];
            $this->db->query('SELECT id_kriteria, nilai_asli FROM nilai_kriteria_calon WHERE id_calon = :id_calon');
            $this->db->bind('id_calon', $c['id_calon']);
            $nilaiList = $this->db->resultSet();
            foreach ($nilaiList as $n) {
                $c['nilai'][$n['id_kriteria']] = $n['nilai_asli'];
            }
        }
        
        return $calon;
    }

    public function isNikExistInProgram($id_program, $id_warga) {
        $this->db->query('SELECT COUNT(*) as total FROM calon_penerima WHERE id_program = :id_program AND id_warga = :id_warga');
        $this->db->bind('id_program', $id_program);
        $this->db->bind('id_warga', $id_warga);
        $res = $this->db->single();
        return $res['total'] > 0;
    }

    public function deleteCalonPenerima($id_calon) {
        // Hapus nilai kriteria terlebih dahulu
        $this->db->query('DELETE FROM nilai_kriteria_calon WHERE id_calon = :id_calon');
        $this->db->bind('id_calon', $id_calon);
        $this->db->execute();
        
        // Hapus calon penerima
        $this->db->query('DELETE FROM calon_penerima WHERE id_calon = :id_calon');
        $this->db->bind('id_calon', $id_calon);
        return $this->db->execute();
    }

    public function addCalonPenerima($id_program, $id_warga) {
        $this->db->query('INSERT INTO calon_penerima (id_warga, id_program, tanggal_usulan, status, created_at) VALUES (:id_warga, :id_program, CURDATE(), \'diusulkan\', NOW())');
        $this->db->bind('id_warga', $id_warga);
        $this->db->bind('id_program', $id_program);
        return $this->db->execute();
    }

    public function updateStatusCalon($id_calon, $status) {
        $this->db->query('UPDATE calon_penerima SET status = :status, updated_at = NOW() WHERE id_calon = :id_calon');
        $this->db->bind('status', $status);
        $this->db->bind('id_calon', $id_calon);
        return $this->db->execute();
    }

    public function saveNilaiKriteria($id_calon, $id_kriteria, $nilai_asli) {
        $this->db->query('SELECT id_nilai FROM nilai_kriteria_calon WHERE id_calon = :id_calon AND id_kriteria = :id_kriteria');
        $this->db->bind('id_calon', $id_calon);
        $this->db->bind('id_kriteria', $id_kriteria);
        $exists = $this->db->single();

        if ($exists) {
            $this->db->query('UPDATE nilai_kriteria_calon SET nilai_asli = :nilai, updated_at = NOW() WHERE id_calon = :id_calon AND id_kriteria = :id_kriteria');
        } else {
            $this->db->query('INSERT INTO nilai_kriteria_calon (id_calon, id_kriteria, nilai_asli, created_at) VALUES (:id_calon, :id_kriteria, :nilai, NOW())');
        }

        $this->db->bind('id_calon', $id_calon);
        $this->db->bind('id_kriteria', $id_kriteria);
        $this->db->bind('nilai', $nilai_asli);
        return $this->db->execute();
    }

    public function getNilaiKriteria($id_calon) {
        $this->db->query('SELECT n.*, k.nama_kriteria, k.bobot, k.tipe_kriteria FROM nilai_kriteria_calon n JOIN kriteria_bantuan k ON n.id_kriteria = k.id_kriteria WHERE n.id_calon = :id_calon');
        $this->db->bind('id_calon', $id_calon);
        return $this->db->resultSet();
    }

    /**
     * SAW Calculation Logic
     */
    public function calculateSAW($id_program) {
        $calon = $this->getCalonPenerima($id_program);
        $kriteria = $this->getKriteria();
        
        if (empty($calon) || empty($kriteria)) return false;

        // 1. Get all values for normalization
        $matrix = [];
        $max_min = [];

        foreach ($kriteria as $k) {
            $vals = [];
            foreach ($calon as $c) {
                $this->db->query('SELECT nilai_asli FROM nilai_kriteria_calon WHERE id_calon = :id_calon AND id_kriteria = :id_kriteria');
                $this->db->bind('id_calon', $c['id_calon']);
                $this->db->bind('id_kriteria', $k['id_kriteria']);
                $val = $this->db->single()['nilai_asli'] ?? 0;
                $matrix[$c['id_calon']][$k['id_kriteria']] = $val;
                $vals[] = $val;
            }
            if ($k['tipe_kriteria'] == 'benefit') {
                $max_min[$k['id_kriteria']] = max($vals);
            } else {
                $max_min[$k['id_kriteria']] = min($vals);
            }
        }

        // 2. Normalize and calculate final score
        $results = [];
        foreach ($calon as $c) {
            $total_score = 0;
            foreach ($kriteria as $k) {
                $val = $matrix[$c['id_calon']][$k['id_kriteria']];
                $norm = 0;
                if ($k['tipe_kriteria'] == 'benefit') {
                    $norm = ($max_min[$k['id_kriteria']] != 0) ? $val / $max_min[$k['id_kriteria']] : 0;
                } else {
                    $norm = ($val != 0) ? $max_min[$k['id_kriteria']] / $val : 0;
                }
                
                // Save normalization back to DB if needed
                $this->updateNormalization($c['id_calon'], $k['id_kriteria'], $norm);
                
                $total_score += ($norm * ($k['bobot'] / 100));
            }
            $results[] = [
                'id_calon' => $c['id_calon'],
                'id_program' => $id_program,
                'nilai_total' => $total_score
            ];
        }

        // 3. Sort by score descending
        usort($results, function($a, $b) {
            return $b['nilai_total'] <=> $a['nilai_total'];
        });

        // 4. Save results to hasil_saw_blt
        $this->saveSawResults($id_program, $results);

        $this->finalizeCalonStatus($id_program);

        return $results;
    }

    private function finalizeCalonStatus($id_program) {
        $this->db->query('SELECT kuota_penerima FROM program_bantuan WHERE id_program = :id_program');
        $this->db->bind('id_program', $id_program);
        $program = $this->db->single();
        $kuota = (int)($program['kuota_penerima'] ?? 0);

        $this->db->query('UPDATE calon_penerima SET status = \'tidak_terpilih\', updated_at = NOW() WHERE id_program = :id_program');
        $this->db->bind('id_program', $id_program);
        $this->db->execute();

        if ($kuota <= 0) return;

        $this->db->query('SELECT id_calon FROM hasil_saw_blt WHERE id_program = :id_program ORDER BY ranking ASC LIMIT ' . $kuota);
        $this->db->bind('id_program', $id_program);
        $top = $this->db->resultSet();

        foreach ($top as $row) {
            $this->db->query('UPDATE calon_penerima SET status = \'terpilih\', updated_at = NOW() WHERE id_program = :id_program AND id_calon = :id_calon');
            $this->db->bind('id_program', $id_program);
            $this->db->bind('id_calon', $row['id_calon']);
            $this->db->execute();
        }
    }

    private function updateNormalization($id_calon, $id_kriteria, $nilai_norm) {
        $this->db->query('UPDATE nilai_kriteria_calon SET nilai_normalisasi = :norm WHERE id_calon = :id_calon AND id_kriteria = :id_kriteria');
        $this->db->bind('norm', $nilai_norm);
        $this->db->bind('id_calon', $id_calon);
        $this->db->bind('id_kriteria', $id_kriteria);
        $this->db->execute();
    }

    private function saveSawResults($id_program, $results) {
        // Clear old results for this program
        $this->db->query('DELETE FROM hasil_saw_blt WHERE id_program = :id_program');
        $this->db->bind('id_program', $id_program);
        $this->db->execute();

        foreach ($results as $index => $res) {
            $this->db->query('INSERT INTO hasil_saw_blt (id_program, id_calon, nilai_total, ranking) VALUES (:id_program, :id_calon, :nilai, :rank)');
            $this->db->bind('id_program', $id_program);
            $this->db->bind('id_calon', $res['id_calon']);
            $this->db->bind('nilai', $res['nilai_total']);
            $this->db->bind('rank', $index + 1);
            $this->db->execute();
        }
    }

    public function getHasilSAW($id_program) {
        $this->db->query('SELECT h.*, w.nama_lengkap, w.nik, pb.bukti_penyerahan, pb.status_penyaluran 
                          FROM hasil_saw_blt h 
                          JOIN calon_penerima c ON h.id_calon = c.id_calon 
                          JOIN warga w ON c.id_warga = w.id_warga 
                          LEFT JOIN penetapan_bantuan pb ON pb.id_program = h.id_program AND pb.id_calon = h.id_calon
                          WHERE h.id_program = :id_program 
                          ORDER BY h.ranking ASC');
        $this->db->bind('id_program', $id_program);
        return $this->db->resultSet();
    }

    public function updateBuktiPenyaluran($id_program, $id_calon, $bukti_penyerahan, $status_penyaluran) {
        $this->db->query('SELECT id_penetapan FROM penetapan_bantuan WHERE id_program = :id_program AND id_calon = :id_calon');
        $this->db->bind('id_program', $id_program);
        $this->db->bind('id_calon', $id_calon);
        $exists = $this->db->single();
        
        if ($exists) {
            $this->db->query('UPDATE penetapan_bantuan 
                SET bukti_penyerahan = :bukti, 
                    status_penyaluran = :status, 
                    updated_at = NOW()
                WHERE id_penetapan = :id');
            $this->db->bind('bukti', $bukti_penyerahan);
            $this->db->bind('status', $status_penyaluran);
            $this->db->bind('id', $exists['id_penetapan']);
        } else {
            $this->db->query('INSERT INTO penetapan_bantuan 
                (id_program, id_calon, id_kades, no_sk, tanggal_penetapan, bukti_penyerahan, status_penyaluran, created_at) 
                VALUES (:id_program, :id_calon, :id_kades, :no_sk, CURDATE(), :bukti, :status, NOW())');
            $this->db->bind('id_program', $id_program);
            $this->db->bind('id_calon', $id_calon);
            $this->db->bind('id_kades', 1); // default kades id
            $this->db->bind('no_sk', 'SK-' . $id_program . '-' . $id_calon);
            $this->db->bind('bukti', $bukti_penyerahan);
            $this->db->bind('status', $status_penyaluran);
        }
        return $this->db->execute();
    }

    public function getHasilByNik($nik) {
        $this->db->query('SELECT h.*, p.nama_program, p.periode, w.nama_lengkap, c.status as status_penerimaan 
                          FROM hasil_saw_blt h 
                          JOIN calon_penerima c ON h.id_calon = c.id_calon 
                          JOIN program_bantuan p ON h.id_program = p.id_program 
                          JOIN warga w ON c.id_warga = w.id_warga 
                          WHERE w.nik = :nik 
                          ORDER BY h.created_at DESC');
        $this->db->bind('nik', $nik);
        return $this->db->resultSet();
    }

    public function getAverageSAWPerProgram() {
        $this->db->query("SELECT 
            p.id_program,
            p.nama_program,
            AVG(h.nilai_total) as rata_rata_nilai,
            p.total_anggaran,
            p.kuota_penerima,
            COUNT(DISTINCT pb.id_penetapan) as total_penerima,
            COUNT(DISTINCT CASE WHEN pb.status_penyaluran = 'selesai' THEN pb.id_penetapan END) as penerima_selesai,
            COUNT(DISTINCT CASE WHEN pb.bukti_penyerahan IS NOT NULL THEN pb.id_penetapan END) as dengan_bukti
            FROM program_bantuan p
            LEFT JOIN hasil_saw_blt h ON p.id_program = h.id_program
            LEFT JOIN penetapan_bantuan pb ON p.id_program = pb.id_program
            GROUP BY p.id_program, p.nama_program, p.total_anggaran, p.kuota_penerima
            ORDER BY p.id_program DESC");
        return $this->db->resultSet();
    }

    public function getManajerialStatsPerPeriode() {
        $this->db->query("SELECT 
            DATE_FORMAT(p.periode, '%Y-%m') as bulan,
            p.nama_program,
            SUM(p.total_anggaran) as total_anggaran,
            COUNT(DISTINCT c.id_calon) as calon,
            COUNT(DISTINCT CASE WHEN c.status = 'penerima' THEN c.id_calon END) as penerima,
            COUNT(DISTINCT pb.id_penetapan) as penyaluran
            FROM program_bantuan p
            LEFT JOIN calon_penerima c ON p.id_program = c.id_program
            LEFT JOIN penetapan_bantuan pb ON p.id_program = pb.id_program
            GROUP BY DATE_FORMAT(p.periode, '%Y-%m'), p.nama_program
            ORDER BY bulan DESC");
        return $this->db->resultSet();
    }

    /**
     * Get detailed SAW calculation per calon (perhitungan per kriteria)
     */
    public function getDetailedSAW($id_program) {
        $calon = $this->getCalonPenerima($id_program);
        $kriteria = $this->getKriteria();
        
        if (empty($calon) || empty($kriteria)) return [];

        // 1. Get normalization values (max for benefit, min for cost)
        $matrix = [];
        $max_min = [];
        
        foreach ($kriteria as $k) {
            $vals = [];
            foreach ($calon as $c) {
                $this->db->query('SELECT nilai_asli FROM nilai_kriteria_calon WHERE id_calon = :id_calon AND id_kriteria = :id_kriteria');
                $this->db->bind('id_calon', $c['id_calon']);
                $this->db->bind('id_kriteria', $k['id_kriteria']);
                $val = $this->db->single()['nilai_asli'] ?? 0;
                $matrix[$c['id_calon']][$k['id_kriteria']] = $val;
                $vals[] = $val;
            }
            
            if ($k['tipe_kriteria'] === 'benefit') {
                $max_min[$k['id_kriteria']] = max($vals);
            } else {
                $max_min[$k['id_kriteria']] = min($vals);
            }
        }

        // 2. Build detailed data for each calon
        $detailed_data = [];
        foreach ($calon as $c) {
            $item = [
                'id_calon' => $c['id_calon'],
                'nama_lengkap' => $c['nama_lengkap'],
                'nik' => $c['nik'],
                'kriteria' => []
            ];
            $total = 0;
            
            foreach ($kriteria as $k) {
                $val = $matrix[$c['id_calon']][$k['id_kriteria']] ?? 0;
                
                // Normalization
                if ($k['tipe_kriteria'] === 'benefit') {
                    $normalized = ($max_min[$k['id_kriteria']] > 0) ? ($val / $max_min[$k['id_kriteria']]) : 0;
                } else {
                    $normalized = ($val > 0) ? ($max_min[$k['id_kriteria']] / $val) : 0;
                }
                
                $weighted = $normalized * $k['bobot'];
                $total += $weighted;
                
                $item['kriteria'][] = [
                    'nama_kriteria' => $k['nama_kriteria'],
                    'bobot' => $k['bobot'],
                    'tipe' => $k['tipe_kriteria'],
                    'nilai_asli' => $val,
                    'nilai_normalisasi' => number_format($normalized, 4),
                    'nilai_terbobot' => number_format($weighted, 4),
                    'nilai_max_min' => $max_min[$k['id_kriteria']]
                ];
            }
            
            $item['nilai_total'] = number_format($total, 4);
            $detailed_data[] = $item;
        }

        // Sort by nilai_total descending
        usort($detailed_data, function($a, $b) {
            return (float)$b['nilai_total'] <=> (float)$a['nilai_total'];
        });

        // Add ranking
        foreach ($detailed_data as $index => &$d) {
            $d['ranking'] = $index + 1;
        }

        return $detailed_data;
    }
}
