<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dss_simple_scoring {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Alternative_model', 'alt');
        $this->CI->load->model('Criteria_model', 'cri');
        $this->CI->load->model('Alternative_score_model', 'sc');
    }

    public function run()
    {
        return $this->calculate();
    }

    /**
     * Tambahan: untuk laporan excel (pakai hitungan yang sama, tapi return detail juga)
     */
    public function report()
    {
        return $this->calculate(true);
    }

    /**
     * @param bool $with_detail kalau true -> return bobot norm, raw, norm, max/min, dll
     */
    public function calculate($with_detail = false)
    {
        $alternatives = $this->CI->alt->get_all();
        $criterias    = $this->CI->cri->all();
        $scores       = $this->CI->sc->get_all();

        if (empty($alternatives) || empty($criterias) || empty($scores)) {
            return [
                'ranking' => [],
                'errors'  => ['Data alternatif/kriteria/skor masih kosong.']
            ];
        }

        // ================= RAW MATRIX =================
        $raw = [];
        foreach ($scores as $s) {
            $raw[$s->alternative_id][$s->criteria_id] = (float)$s->score;
        }

        foreach ($alternatives as $a) {
            foreach ($criterias as $c) {
                if (!isset($raw[$a->id][$c->id])) {
                    $raw[$a->id][$c->id] = 0;
                }
            }
        }

        // ================= NORMALISASI BOBOT =================
        $totalWeight = 0;
        foreach ($criterias as $c) {
            $totalWeight += (float)$c->weight;
        }
        if ($totalWeight <= 0) {
            return [
                'ranking' => [],
                'errors'  => ['Total bobot kriteria 0. Periksa bobot kriteria.']
            ];
        }

        $weightNorm  = [];
        foreach ($criterias as $c) {
            $weightNorm[$c->id] = (float)$c->weight / $totalWeight;
        }

        // ================= MAX & MIN =================
        $max = [];
        $min = [];
        foreach ($criterias as $c) {
            $values = [];
            foreach ($alternatives as $a) {
                $values[] = (float)$raw[$a->id][$c->id];
            }
            $max[$c->id] = max($values);
            $min[$c->id] = min($values);
        }

        // ================= NORMALISASI NILAI =================
        $norm = [];
        foreach ($alternatives as $a) {
            foreach ($criterias as $c) {
                $x = (float)$raw[$a->id][$c->id];

                if ($c->type === 'benefit') {
                    $den = (float)$max[$c->id];
                    $norm[$a->id][$c->id] = ($den > 0) ? ($x / $den) : 0;
                } else {
                    $norm[$a->id][$c->id] = ($x > 0) ? ((float)$min[$c->id] / $x) : 0;
                }
            }
        }

        // ================= SKOR AKHIR =================
        $result = [];
        foreach ($alternatives as $a) {
            $total = 0;
            foreach ($criterias as $c) {
                $total += $weightNorm[$c->id] * $norm[$a->id][$c->id];
            }
            $result[] = [
                'alternative_id' => (int)$a->id,
                'alternative'    => $a->name,
                'score'          => round($total, 6)
            ];
        }

        // ================= RANKING =================
        usort($result, function($a, $b){
            return $b['score'] <=> $a['score'];
        });

        $rank = 1;
        foreach ($result as &$r) {
            $r['rank'] = $rank++;
        }

        $payload = [
            'ranking' => $result,
            'errors'  => []
        ];

        if ($with_detail) {
            $payload['total_weight'] = $totalWeight;

            // bikin list bobot norm versi tabel (code/name)
            $weight_norm_table = [];
            foreach ($criterias as $c) {
                $weight_norm_table[] = [
                    'criteria_id' => (int)$c->id,
                    'code'        => $c->code,
                    'name'        => $c->name,
                    'type'        => $c->type,
                    'weight'      => (float)$c->weight,
                    'norm'        => (float)$weightNorm[$c->id],
                ];
            }

            $payload['criterias']         = $criterias;
            $payload['alternatives']      = $alternatives;
            $payload['weight_norm']       = $weight_norm_table;
            $payload['raw_matrix']        = $raw;
            $payload['normalized_matrix'] = $norm;
            $payload['max']               = $max;
            $payload['min']               = $min;
        }

        return $payload;
    }
}
