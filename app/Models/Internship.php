<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Internship extends Model
{
    protected $guarded = ['id'];

    public function evaluation()
    {
        return $this->hasOne(Evaluation::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class , 'student_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class , 'mentor_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // 1. Relasi ke Logbook (One to Many)
    public function dailyLogbooks()
    {
        return $this->hasMany(DailyLogbook::class);
    }

    // 2. Relasi ke Absensi (One to Many)
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function extensions()
    {
        return $this->hasMany(InternshipExtension::class);
    }

    /**
     * Local Scopes for Status
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFinished($query)
    {
        return $query->where('status', 'finished');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
