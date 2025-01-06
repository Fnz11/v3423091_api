<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $fillable = ['name', 'type', 'file_path', 'size', 'status', 'restore_status'];

    public const TYPE_DATABASE = 'database';
    public const TYPE_PROJECT = 'project';
    
    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';
    
    public const RESTORE_STATUS_PENDING = 'restoring';
    public const RESTORE_STATUS_COMPLETED = 'restored';
    public const RESTORE_STATUS_FAILED = 'restore_failed';
    
    public function getIsCompletedAttribute()
    {
        return $this->status === self::STATUS_COMPLETED;
    }
    
    public function isRestoring()
    {
        return $this->restore_status === self::RESTORE_STATUS_PENDING;
    }
    
    public function isRestoreCompleted()
    {
        return in_array($this->restore_status, [
            self::RESTORE_STATUS_COMPLETED,
            self::RESTORE_STATUS_FAILED
        ]);
    }
}
