<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'checklist_id',
        'is_completed',
        'completed_at',
        'due',
        'urgency',
        'assignee_id',
        'task_id',
        'updated_by',
        'created_by'
    ];
    protected $table = 'checklistitems';
}
