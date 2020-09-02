<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait CanBindFormTrait
 * @package App\Models
 * @mixin Model
 */
trait CanBindFormTrait
{

    public function forms(){
        return $this->hasMany(FormBinding::class, "entity_id", "id")
            ->where("entity_type", $this->getTable());
    }


    public function newFormBinding(Form $form){
        $attributes = [
            'entity_type' => $this->getTable(),
            'entity_id' => $this->getKey(),
            'form_id' => $form->getKey(),
            'is_collection' => $form,
        ];
        return new FormBinding($attributes);
    }
}