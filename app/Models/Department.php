<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'portal_department_id',
        'company_id',
    ];

    public function jobs()
    {
        return $this->hasMany(JobPosting::class, 'department_id');
    }

    public function publishedJobs()
    {
        return $this->jobs()->where('status', 'published')->where(function ($query) {
            $query->whereNull('application_deadline')
                ->orWhere('application_deadline', '>=', now()->toDateString());
        });
    }
}
