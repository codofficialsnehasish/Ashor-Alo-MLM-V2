<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BinaryTree extends Model
{
    use LogsActivity;

    protected $fillable = [
        'user_id', 
        'member_number',
        'sponsor_id',
        'parent_id', 
        'position', 
        'left_user_id', 
        'right_user_id',
        'status',
        'activated_at',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('binary-tree');
    }
    
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

    public function sponsor()
    {
        // The user who sponsored this node (through sponsor_id)
        return $this->belongsTo(BinaryTree::class, 'sponsor_id')->with('user');
    }

    public function sponsoredNodes()
    {
        // All nodes this user has sponsored
        return $this->hasMany(BinaryTree::class, 'sponsor_id');
    }
}
