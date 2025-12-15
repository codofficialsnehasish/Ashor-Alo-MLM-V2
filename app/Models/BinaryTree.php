<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Kalnoy\Nestedset\NodeTrait;
use App\Models\TopUp;

class BinaryTree extends Model
{
    use LogsActivity, NodeTrait;

    protected $fillable = [
        'user_id', 
        'member_number',
        'sponsor_id',
        'parent_id', 
        'position', 
        'left_user_id', 
        'right_user_id',
        'status',
        'joining_amount',
        'join_by',
        'joining_order_id',
        'activated_at',
        'payout_type',
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

    // public function left()
    // {
    //     return $this->hasOne(BinaryTree::class, 'id', 'left_user_id')->with('left', 'right', 'user');
    // }

    // public function right()
    // {
    //     return $this->hasOne(BinaryTree::class, 'id', 'right_user_id')->with('left', 'right', 'user');
    // }

    public function left()
    {
        return $this->hasOne(BinaryTree::class, 'parent_id', 'id')->where('position', 'left')->with('user');
    }

    public function right()
    {
        return $this->hasOne(BinaryTree::class, 'parent_id', 'id')->where('position', 'right')->with('user');
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

    // Recursive relationships for counts
    // public function leftUsers()  
    // {
    //     return $this->descendants()->where('position', 'left')->with('user');
    // }
    
    // public function leftUsers()  
    // {
    //     return $this->left->descendants()->with('user');
    // }
    
    public function getLeftUsersAttribute()
    {
        $left = $this->left; // assuming 'left' relationship is already eager loaded
    
        if (!$left) {
            return collect(); // empty collection
        }
    
        $descendants = $left->descendants()->with('user')->get();
    
        return $descendants->prepend($left);
    }



    

    // public function rightUsers()
    // {
    //     return $this->descendants()->where('position', 'right')->with('user');
    // }
    
    // public function rightUsers()  
    // {
    //     return $this->right->descendants()->with('user');
    // }
    
    public function getRightUsersAttribute()
    {
        $right = $this->right; // assuming 'left' relationship is already eager loaded
    
        if (!$right) {
            return collect(); // empty collection
        }
    
        $descendants = $right->descendants()->with('user')->get();
    
        return $descendants->prepend($right);
    }
    
    public function joinedBy()
    {
        return $this->belongsTo(User::class, 'join_by');
    }
    
    
    /**
     * Calculate left side business volume
     */
    public function calculateLeftBusiness($start_date = null, $end_date = null): float
    {
        return $this->calculateSideBusiness($this->left(), $start_date, $end_date);
    }

    /**
     * Calculate right side business volume
     */
    public function calculateRightBusiness($start_date = null, $end_date = null): float
    {
        return $this->calculateSideBusiness($this->right(), $start_date, $end_date);
    }

    /**
     * Helper method to calculate business for a specific side
     */
    protected function calculateSideBusiness($sideRelation, $start_date = null, $end_date = null): float
    {
        $sideNode = $sideRelation->first();
        
        if (!$sideNode) {
            return 0;
        }

        // Get all user IDs in this subtree (including the side node itself)
        $userIds = BinaryTree::whereDescendantOf($sideNode)
            ->orWhere('id', $sideNode->id)
            ->pluck('user_id')
            ->toArray();

        if (empty($userIds)) {
            return 0;
        }

        $query = TopUp::whereIn('user_id', $userIds)
            ->where(function ($q) {
                $q->where('is_show_on_business', 1);
            });

        if ($start_date && $end_date) {
            $query->whereDate('start_date', '>=', $start_date)
                  ->whereDate('start_date', '<=', $end_date);
        }

        return (float) $query->sum('total_amount');
    }
}
