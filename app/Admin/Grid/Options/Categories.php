<?php


namespace App\Admin\Grid\Options;

use App\Admin\Grid\Interfaces\OptionProviderInterface;
use App\Models\Category;
use App\Supports\Tree;

/**
 * Class Categories
 * @package App\Admin\Grid\Options
 * @Annotation
 */
class Categories implements OptionProviderInterface
{

    public function toArray(){
        $categories = Category::select(
            "id", "parent_id", "title"
        )->get();

        $tree = new Tree($categories->toArray());

        $items = $tree->toTreeList();

        $options = [
            0 => "根"
        ];

        foreach ($items as $item){
            $options[$item['id']] = str_repeat("—— ", $item['depth']) .  " {$item['title']}";
        }
        return $options;
    }


    public function toIterator()
    {
        return $this->toArray();
    }

}