<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'categorieId', 'estCredit', 'montant', 'date'];

    public static function calculTotal()
    {
        return (Operation::where('estCredit', '1')->sum('montant')) - (Operation::where('estCredit', '0')->sum('montant'));
    }

    public static function calculOperationsFiltrer($operationsQuery)
    {
        $sum = 0;
        foreach($operationsQuery as $child) {
            if($child['estCredit'] === 1){
                $sum += $child['montant'];
            }else{
                $sum -= $child['montant'];
            }
        }

        return $sum;
    }
}
