<?php

namespace App\Enum\User;

enum DegreeEnum: string
{
    case BACHELOR_STUDENT = 'bachelor_student';
    case BACHELOR = 'bachelor';
    case MASTER_STUDENT = 'master_student';
    case MASTER = 'master';
    case PHD_RESEARCHER = 'phd_researcher';
    case PHD = 'phd';
    case DOCTOR = 'doctor';
}
