<?php

namespace App\Models;

use App\Rules\FilterName;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    //white list
    protected $fillable = [
        'name', 'parent_id', 'description', 'image', 'status', 'slug'
    ]; //  اللي هنا بتخزن


    //black list
    protected $guarded = []; // اللي بنحط هنا ما بتخزن 


    public function products()
    {
        //$this->hasMany(Product::class,'FK','LOcal key');
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required', 'string', 'min:4', 'max:255', 'unique:categories,name,' . $id,
                new FilterName(["sameralimoor", "admin"]),
                //  Rule::unique('categories', 'name')->ignore($id)
            ],
            'parent_id' => 'nullable', 'int|exists:categories,id',
            'image' => [
                'image',
                //mimes:png,
                'max:1048000', //1 mega
                'dimensions:min_width=100,min_height=100',

            ],
            'status' => 'in:active,inactive', // enum

        ];
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')
            ->withDefault([
                'name' => 'No Parent'
            ]);
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function scopeActive(Builder $builder) //local scope
    {
        $builder->where('status', '=', 'active');
    }
    public function scopeFilters(Builder $builder, $filter) //local scope
    {
        if ($filter['name'] ?? false) {
            $builder->where('name', 'LIKE', "%{$filter['name']}%");
        }
        if ($filter['status'] ?? false) {
            $builder->where('status', '=', $filter['status']);
        }
    }
}