<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\TeacherLevel;
use \App\Models\TeacherCurriculum;
use \App\Models\TeacherCertificate;
use \App\Models\TeacherExperience;
use \App\Models\TeacherStudyType;
use \App\Models\TeacherTopic;
use \App\Models\TeacherTrain;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','have_certificates','have_experiences','have_assay_experiences','timezone','order_immediatly','teacher_language','video', 'teach_gender', 'weekly_hours','heading_en','description_en','heading_ar','description_ar', 'fees'
    ];

    public function levels() {
        return $this->hasMany(TeacherLevel::class, 'teacher_id', 'user_id');
    }

    public function curriculums() {
        return $this->hasMany(TeacherCurriculum::class, 'teacher_id', 'user_id');
    }

    public function certificates() {
        return $this->hasMany(TeacherCertificate::class, 'teacher_id', 'user_id');
    }

    public function experiences() {
        return $this->hasMany(TeacherExperience::class, 'teacher_id', 'user_id');
    }

    public function topics() {
        return $this->hasMany(TeacherTopic::class, 'teacher_id', 'user_id');
    }

    public function trains() {
        return $this->hasMany(TeacherTrain::class, 'teacher_id', 'user_id');
    }

    public function availability() {
        return $this->hasMany(TeacherAvailablity::class, 'teacher_id', 'user_id');
    }

    public function packages() {
        return $this->hasMany(TeacherPackage::class, 'teacher_id', 'user_id');
    }
}
