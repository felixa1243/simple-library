<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Member extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name'];
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
    
    public function canBorrow()
    {
        return $this->borrowings()->whereNull('returned_at')->count() < 2 && !$this->hasActivePenalty();
    }

    public function hasActivePenalty()
    {
        return Penalty::where('member_id', $this->id)
            ->whereDate('penalty_end', '>=', now())
            ->exists();
    }
}
