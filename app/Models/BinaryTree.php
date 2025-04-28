<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BinaryTree extends Model
{
    protected $fillable = [
        'user_id', 
        'parent_id', 
        'position', 
        'left_user_id', 
        'right_user_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(BinaryTree::class, 'parent_id');
    }
    public function left()
    {
        return $this->hasOne(BinaryTree::class, 'id', 'left_user_id')->with('left', 'right', 'user');
    }

    public function right()
    {
        return $this->hasOne(BinaryTree::class, 'id', 'right_user_id')->with('left', 'right', 'user');
    }
}
