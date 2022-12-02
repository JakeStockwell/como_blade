<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;


}

// SELECT g.group_name, u.name
// FROM members m 
// 	JOIN `groups` g ON g.id = m.group_id
//     JOIN `users` u ON u.id = m.user_id
// WHERE m.user_id = 11