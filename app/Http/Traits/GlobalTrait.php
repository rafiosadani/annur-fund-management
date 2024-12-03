<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

trait GlobalTrait
{
    public function cekRelasiTabel($data = []){
        foreach($data as $val):
            try{
                $getData = DB::table($val["table"])->where($val["foreign_key"], "LIKE", "%{$val['val']}%");
                // Jika ada multi_keys
                if(isset($val["multi_keys"]) && is_array($val["multi_keys"]) && count($val["multi_keys"]) >= 1):
                    foreach($val["multi_keys"] as $val2):
                        $getData->where($val2["foreign_key"], "LIKE", "%{$val2['val']}%");
                    endforeach;
                else:
                    $getData->where($val["foreign_key"], "LIKE", "%{$val['val']}%");
                endif;

                if ($val["table"] == "role_has_permissions" || $val["table"] == "model_has_permissions" || $val["table"] == "model_has_roles"
                    || $val["table"] == "m_book_category" || $val["table"] == "t_book_loans" || $val["table"] == "t_detail_book_loans" || $val["table"] == "t_book_fines"
                    || $val["table"] == "t_detail_class_equipment_loans") :
                    $result = $getData->first();
                else :
                    $result = $getData->whereNull("deleted_at")->first();
                endif;

                if($result != null){
                    return $success = [
                        "status"    => true,
                        "message"   => "Data berelasi pada " . $val["table"]
                    ];
                }
            } catch (Throwable $th){
                return $failed = [
                    "status"    => false,
                    "message"   => "Terjadi kesalahan pada server",
                    "dev"       => $th->getMessage() . " at line " . $th->getLine() . " in " . $th->getFile()
                ];
            }
        endforeach;

        return $failed = [
            "status"    => false,
            "message"   => "Data tidak berelasi pada tabel manapun"
        ];
    }

    public function processRupiahInput($request, $field)
    {
        $rawValue = str_replace([',', '.'], '', $request->input($field));
        $request->merge([$field => $rawValue]);

        if (!empty($rawValue)) {
            $formattedValue = number_format($rawValue, 0, ',', '.');
            session()->flash('original' . ucfirst($field), $formattedValue);
        }

        return (int) $rawValue;
    }
}
?>
